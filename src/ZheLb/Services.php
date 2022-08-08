<?php

namespace ZheService\ZheLb;

use ZheService\Exceptions\ApiException;
use ZheService\Interfaces\ZheLb;

class Services implements ZheLb
{
    private $client;
    private $personalTicketUrl;
    private $personalUserUrl;
    private $legalUserUrl;
    private $ssoTokenUrl;
    private $ssoUserUrl;

    private static $accessKey;
    private static $secretKey;

    public function __construct()
    {
        $env = env('ZLB_ENV');
        if (!$env || !env('ZLB_ACCESS_KEY') || !env('ZLB_SECRET_KEY')) {
            throw new ApiException(['msg' => '请配置开发环境参数.', 'code' => 1]);
        }
        
        $config = Config::API_URL[$env];
        $this->client = new Client();
        $this->personalTicketUrl = $config['PERSONAL_TICKET_URL'];
        $this->personalUserUrl = $config['PERSONAL_USER_URL'];
        $this->legalUserUrl = $config['LEGAL_USER_URL'];
        $this->ssoTokenUrl = $config['SSO_TOKEN_URL'];
        $this->ssoUserUrl = $config['SSO_USER_URL'];

        self::$accessKey = env('ZLB_ACCESS_KEY');
        self::$secretKey = env('ZLB_SECRET_KEY');
    }

    /**
     * 个人登录 票据认证
     *
     * @param String $st
     * @return array
     */
    public function personalTicket(String $st)
    {
        $headers = $this->client->getHeaders($this->personalTicketUrl, 'person');
        list($servicecode, $time, $sign) = $this->client->getHttpParams();

        return $this->client->curl($this->personalTicketUrl, $headers, [
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
     */
    public function personalInfo(String $token)
    {
        $headers = $this->client->getHeaders($this->personalUserUrl, 'person');
        list($servicecode, $time, $sign) = $this->client->getHttpParams();

        $result = $this->client->curl($this->personalUserUrl, $headers, [
            'form_params' => [
                'method' => 'getUserInfo',
                'datatype' => 'json',
                'servicecode' => $servicecode,
                'time' => $time,
                'sign' => $sign,
                'token' => $token,
            ],
        ]);

        if ($result['result']) {
            throw new APIException(['msg' => $result['errmsg'], 'code' => $result['result']]);
        }

        return $result;
    }

    /**
     * 法人登录 获取用户信息
     *
     * @param String $ssoToken
     * @return array
     */
    public function legalInfo(String $ssoToken)
    {
        $headers = $this->client->getHeaders($this->legalUserUrl);
        $result = $this->client->curl($this->legalUserUrl, $headers, [
            'json' => ['token' => $ssoToken],
        ]);

        if (!$result['success']) {
            throw new ApiException(['code' => $result['errCode'], 'msg' => $result['msg']]);
        }

        return $result;
    }

    /**
     * 微信单点登录-获取token
     *
     * @param String $ticketId
     * @param String $appId
     * @return void
     */
    public function ssoToken(String $ticketId, String $appId)
    {
        $this->setSSOKey();
        $headers = $this->client->getHeaders($this->ssoTokenUrl);
        $result = $this->client->curl($this->ssoTokenUrl, $headers, [
            'json' => ['ticketId' => $ticketId, 'appId' => $appId],
        ]);

        if (!$result['success']) {
            throw new ApiException(['code' => $result['resultCode'], 'msg' => $result['errorMsg']]);
        }

        return $result;
    }

    /**
     * 微信单点登录-获取用户信息
     *
     * @param String $token
     * @return void
     */
    public function ssoInfo(String $token)
    {
        $this->setSSOKey();
        $headers = $this->client->getHeaders($this->ssoUserUrl);
        $result = $this->client->curl($this->ssoUserUrl, $headers, [
            'json' => ['token' => $token],
        ]);

        if (!$result['success']) {
            throw new ApiException(['code' => $result['resultCode'], 'msg' => $result['errorMsg']]);
        }

        return $result;
    }

    /**
     * 设置单点登录key
     *
     * @return void
     */
    private function setSSOKey()
    {
        if (!env('SSO_ACCESS_KEY') || !env('SSO_SECRET_KEY')) {
            throw new ApiException(['msg' => '请配置微信单点登录开发环境参数.', 'code' => 1]);
        }

        self::$accessKey = env('SSO_ACCESS_KEY');
        self::$secretKey = env('SSO_SECRET_KEY');
    }

    /**
     * 返回accessKey
     *
     * @return String
     */
    public static function accessKey()
    {
        return self::$accessKey;
    }

    /**
     * 返回secretKey
     *
     * @return String
     */
    public static function secretKey()
    {
        return self::$secretKey;
    }
}
