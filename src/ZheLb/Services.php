<?php

namespace ZheService\ZheLb;

use ZheService\Exceptions\ApiException;
use ZheService\Interfaces\ZheLb;

class Services implements ZheLb
{
    private $zlbCommon;
    private $zlb_personal_ticket_url;
    private $zlb_personal_user_url;
    private $zlb_legal_user_url;

    public function __construct()
    {
        $this->zlbCommon = new Common();
        $env = env('ZLB_ENV');
        if (!$env || !env('ZLB_ACCESS_KEY') || !env('ZLB_SECRET_KEY')) {
            throw new ApiException(['msg' => '请配置开发环境参数.', 'code' => 1]);
        }
        $config = $this->apiConfig($env);
        $this->zlb_personal_ticket_url = $config['ZLB_PERSONAL_TICKET_URL'];
        $this->zlb_personal_user_url = $config['ZLB_PERSONAL_USER_URL'];
        $this->zlb_legal_user_url = $config['ZLB_LEGAL_USER_URL'];
    }

    /**
     * 个人登录 票据认证
     *
     * @param String $st
     * @return array
     * @author Dunstan
     * @date 2022-06-01
     */
    public function personalTicket(String $st)
    {
        $headers = $this->zlbCommon->getHeaders($this->zlb_personal_ticket_url, 'person');
        list($servicecode, $time, $sign) = $this->zlbCommon->getHttpParams();

        return $this->zlbCommon->curl($this->zlb_personal_ticket_url, $headers, [
            'form_params' => [
                'servicecode' => $servicecode,
                'time' => $time,
                'sign' => $sign,
                'method' => 'ticketValidation',
                'st' => $st,
                'datatype' => 'json',
            ],
        ]);
    }

    /**
     * 个人登录 获取个人信息
     *
     * @param String $token
     * @return array
     * @author Dunstan
     * @date 2022-06-01
     */
    public function personalInfo(String $token)
    {
        $headers = $this->zlbCommon->getHeaders($this->zlb_personal_user_url, 'person');
        list($servicecode, $time, $sign) = $this->zlbCommon->getHttpParams();

        $resParams = $this->zlbCommon->curl($this->zlb_personal_user_url, $headers, [
            'form_params' => [
                'method' => 'getUserInfo',
                'datatype' => 'json',
                'servicecode' => $servicecode,
                'time' => $time,
                'sign' => $sign,
                'token' => $token,
            ],
        ]);

        if ($resParams['result']) {
            throw new APIException(['msg' => $resParams['errmsg'], 'code' => $resParams['result']]);
        }

        return $resParams;
    }

    /**
     * 法人登录 获取用户信息
     *
     * @param String $ssoToken
     * @return array
     * @author Dunstan
     * @date 2022-06-01
     */
    public function legalInfo(String $ssotoken)
    {
        $headers = $this->zlbCommon->getHeaders($this->zlb_legal_user_url);
        $resParams = $this->zlbCommon->curl($this->zlb_legal_user_url, $headers, [
            'json' => ['token' => $ssotoken],
        ]);

        if (!$resParams['success']) {
            throw new ApiException(['code' => $resParams['errCode'], 'msg' => $resParams['msg']]);
        }

        return $resParams;
    }
    
    private function apiConfig($env)
    {
        $config = [
            'test' => [
                'ZLB_PERSONAL_TICKET_URL' => 'https://ibcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220228000002/sso/servlet/simpleauth',
                'ZLB_PERSONAL_USER_URL' => 'https://ibcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220228000004/sso/servlet/simpleauth',
                'ZLB_LEGAL_USER_URL' => 'https://ibcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220309000001/rest/user/query',
            ],

            'live' => [
                'ZLB_PERSONAL_TICKET_URL' => 'https://bcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220228000002/sso/servlet/simpleauth',
                'ZLB_PERSONAL_USER_URL' => 'https://bcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220228000004/sso/servlet/simpleauth',
                'ZLB_LEGAL_USER_URL' => 'https://bcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220309000001/rest/user/query',
            ],
        ];

        return $config[$env];
    }
}
