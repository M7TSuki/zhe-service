<?php

namespace ZheService\ZheNm;

use ZheService\Exceptions\ApiException;
use ZheService\Interfaces\ZheNm;

class Services implements ZheNm
{
    public static $clientId; // 浙农码--clientId
    public static $clientSecret; // 浙农码--clientSecret
    public static $domain; // 浙农码--域名

    public function __construct()
    {
        $env = env('ZNM_ENV');
        self::$clientId = env('ZNM_CLIENT_ID');
        self::$clientSecret = env('ZNM_CLIENT_SECRET');
        if (!isset($env, self::$clientId, self::$clientSecret)) {
            throw new ApiException(['msg' => '请配置开发环境参数.', 'code' => 1]);
        }
        // TODO 确认正确域名
        self::$domain = $env == 'live' ? 'https://znm.zjagri.cn/api/' : 'http://znm.kf315.net/api/';
    }

    /**
     * 申请浙农码
     * [
     *        'callbackUrl' => '',
     *       'clientId' => env('ZNM_CLIENT_ID'),
     *       'extendCodeFileUrl' => '',
     *        'extendType' => 3,
     *       'resolveUrl' => env('ZNM_H5_URL'),
     *      'uploadParamsDtoList' => [
     *         [
     *            'areaNumber' => '330122', //地区行政区代码 必填桐庐
     *           "attributeParamDtoList" => [ //非必填 看情况
     *              [
     *                 "key" => "mobile",
     *                "keyName" => " 手机号",
     *               "value" => $userInfo->mobile,
     *          ],
     *     ],
     *     "belong" => "",
     *     "belongType" => 0,
     *               "extendCode" => $userInfo->id_card, //必填身份证
     *               "extendCodeType" => 2,
     *               "imageUrl" => "",
     *               "objectName" => $userInfo->realname, //必填姓名
     *           ],
     *       ],
     *       'useForCode' => '020501',
     *   ];
     *
     * @param array $params
     * @return
     *  {
     *       "state": 200,
     *       "internalErrorCode": "0",
     *       "msg": "success",
     *       "results": {
     *           "znmBatchId": 45104, //批次
     *           "list": [
     *               {
     *                   "extendCode": "380824197808084781",  //扩展码
     *                   "znmCode": "1003161503447151680",  //浙农码
     *                   "znmUrlCode": "http://dev-znm.kf315.net/u/12/1003161503447151680"
     *               }
     *           ]
     *       }
     *   }
     */
    public function applyCode(array $params)
    {
        $result = (new Client())->curl(self::$domain . Config::APPLY_CODE_API, 'POST', $params);
        if ($result['state'] != 200) {
            throw new ApiException(['msg' => $result['msg'], 'code' => 1]);
        }
        return $result;
    }

    /**
     * 更新赋码信息
     *
     * @return bool
     * { "internalErrorCode": "", "msg": "", "results": {}, "state": 200 }
     */
    public function updateCode(array $params)
    {
        $result = (new Client())->curl(self::$domain . Config::UPDATE_CODE_API, 'POST', $params);
        if ($result['state'] != 200) {
            throw new ApiException(['msg' => $result['msg'], 'code' => 1]);
        }
        return true;
    }

    /**
     * 获取浙农码 扩展码
     *
     * [
     *       [
     *           "address" => "",
     *           "areaNumber" => "",
     *           "colorReason" => "主体展示",
     *           "colorSettingMode" => 1,
     *           "extendCode" => $userInfo->id_card, //身份证必填
     *          "ip" => "",
     *          "latitude" => "",
     *          "longitude" => "",
     *          "qrCodeColor" => 0,
     *          "qrSize" => 200,
     *          "systemType" => "",
     *          "systemVersion" => "",
     *      ],
     *  ]
     * @param String $znm_uid
     * @return
     *      {
     *          "internalErrorCode": "",
     *          "msg": "",
     *          "results": {
     *              "extendCode": "3308**********4781"  //身份证
     *          },
     *          "state": 200
     *      }
     */
    public function codeInfo(String $znm_uid)
    {
        $params = [
            'znm-uid' => $znm_uid,
        ];
        $result = (new Client())->curl(self::$domain . Config::GET_USER_BY_CODE_API, 'GET', $params);
        if ($result['state'] != 200) {
            throw new ApiException(['msg' => $result['msg'], 'code' => 1]);
        }
        return $result;
    }

    /**
     * 通过list批量浙农码二维码
     *
     * @param array $list
     * @return
     *
     * {
     *       "internalErrorCode": "",
     *       "msg": "",
     *       "results": [
     *           {
     *               "extendCode": "522426199709066251",
     *               "qrCodeBase64": "sd56sd4g54g64gsdf546f8g46sf1sdeyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOlsicmVzMSJdLCJzY2 9wZSI6WyJhbGwiXSwiZXhwIjoxNjM4NDMzNjQzLCJhdXRob3JpdGllcyI6WyJwMSIsInAyIl0sImp0aSI6Ijhm ZTk0NTNkLTIxZmUtNGZlZi05ZDE0LTllMjI4MmQ1NDhmYSIsImNsaWVudF9pZCI6InNoYW5qdXphaXhpY W4ifQ.qJAklhXVRiQhVyMH-scEX2pd0OQsR1ozPgPZoJ4hKow56sd4g54g64gsdf546f8g46sf1",
     *               "znmCode": "9000000410555922"
     *           }
     *       ],
     *       "state": 200
     *   }
     */
    public function codeDisplay(array $list)
    {
        $params = [
            'list' => $list,
        ];
        $result = (new Client())->curl(self::$domain . Config::BATCH_GET_QR_CODE_API, 'POST', $params);

        if ($result['state'] != 200) {
            throw new ApiException(['msg' => $result['msg'], 'code' => 1]);
        }
        return $result;
    }
}
