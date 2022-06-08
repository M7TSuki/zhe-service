<?php

namespace ZheService\ZheNm;

use ZheService\Exceptions\ApiException;
use ZheService\Interfaces\ZheNm;
use ZheService\ZheNm\Consts\Api;

class Services implements ZheNm
{
    /**
     * 申请浙农码
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
     * @author Dunstan
     * @date 2022-06-07
     */
    public function applyCode(array $params)
    {
        $result = (new Client())->curl(Api::APPLY_CODE_API, 'POST', $params);
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
     * @author Dunstan
     * @date 2022-06-07
     */
    public function updateCode(array $params)
    {
        $result = (new Client())->curl(Api::UPDATE_CODE_API, 'POST', $params);
        if ($result['state'] != 200) {
            throw new ApiException(['msg' => $result['msg'], 'code' => 1]);
        }
        return true;
    }

    /**
     * 获取浙农码 扩展码
     *
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
     * @author Dunstan
     * @date 2022-06-07
     */
    public function codeInfo(String $znm_uid)
    {
        $params = [
            'znm-uid' => $znm_uid,
        ];
        $result = (new Client())->curl(Api::GET_USER_BY_CODE_API, 'GET', $params);
        if ($result['state'] != 200) {
            throw new ApiException(['msg' => $result['msg'], 'code' => 1]);
        }
        return result;
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
     * @author Dunstan
     * @date 2022-06-07
     */
    public function codeDisplay(array $list)
    {
        $params = [
            'list' => $list,
        ];
        $result = (new Client())->curl(Api::BATCH_GET_QR_CODE_API, 'POST', $params);
        if ($result['state'] != 200) {
            throw new ApiException(['msg' => $result['msg'], 'code' => 1]);
        }
        return $result;
    }
    
    // // 浙农码--浙农码下载
    // public function znmCodeDownload(int $znmBatchId)
    // {
    //     $httpParams = [
    //         'znmBatchId' => $znmBatchId,
    //     ];
    //     return (new Client())->curl(Api::CODE_DOWNLOAD_API, 'GET', $httpParams, false);
    // }

    // // 浙农码--浙农码作废
    // public function znmCodeInvalid(array $params)
    // {
    //     $httpParams = [
    //         'clientId' => env('ZNM_CLIENT_ID'),
    //         'clientName' => env('ZNM_CLIENT_NAME'),
    //         'extendCodeList' => $params['extendCodeList'] ?? [],
    //         'invalidReason' => $params['invalidReason'] ?? '',
    //     ];
    //     return (new Client())->curl(Api::CODE_INVALID_API, 'POST', $httpParams);
    // }

    // // 浙农码--浙农码清空作废
    // public function znmRemoveInvalidCode(array $params)
    // {
    //     $httpParams = [
    //         'clientId' => env('ZNM_CLIENT_ID'),
    //         'clientName' => env('ZNM_CLIENT_NAME'),
    //         'extendCodeList' => $params['extendCodeList'] ?? [],
    //         'removeInvalidReason' => $params['removeInvalidReason'] ?? '',
    //     ];
    //     return (new Client())->curl(Api::REMOVE_INVALID_CODE_API, 'POST', $httpParams);
    // }

    // // 浙农码--通过浙农码获取扩展码
    // public function getZnmExtendCodeByZnm(String $mainCode)
    // {
    //     $httpParams = [
    //         'mainCode' => $$mainCode,
    //     ];
    //     return (new Client())->curl(Api::GET_EXTEND_CODE_BY_ZNM_API, 'GET', $httpParams);
    // }

    // // 浙农码--获取扩展码对应的浙农码
    // public function getZnmCodeByExtendCode(String $extendCode)
    // {
    //     $httpParams = [
    //         'clientId' => env('ZNM_CLIENT_ID'),
    //         'extendCode' => $extendCode,
    //     ];
    //     return (new Client())->curl(Api::GET_ZNM_CODE_BY_EXTEND_CODE_API, 'GET', $httpParams);
    // }

    // // 浙农码--获取浙农码的生码状态
    // public function getZnmApplyStatus(int $znmBatchId)
    // {
    //     $httpParams = [
    //         'znmBatchId' => $znmBatchId,
    //     ];
    //     return (new Client())->curl(Api::GET_ZNM_APPLY_STATUS_API, 'GET', $httpParams);
    // }

    // // 浙农码--获取某个应用(客户端)的用码/示码/扫码总数
    // public function getZnmCodeUseRecord(array $params)
    // {
    //     $httpParams = [
    //         'clientId' => env('ZNM_CLIENT_ID'),
    //         'type' => $params['type'] ?? 0,
    //     ];
    //     if (isset($params['areaNumber'])) {
    //         $httpParams['areaNumber'] = $params['areaNumber'];
    //     }

    //     return (new Client())->curl(Api::GET_ZNM_CODE_USE_RECORD_API, 'GET', $httpParams);
    // }

    // // 浙农码--获取码申请记录列表
    // public function getZnmCodeRecordList(array $params)
    // {
    //     $httpParams = [
    //         'clientId' => env('ZNM_CLIENT_ID'),
    //         'current' => $params['current'] ?? '',
    //         'flag' => $params['flag'] ?? 1,
    //         'pageSize' => $params['pageSize'] ?? 10,
    //         'search' => $params['search'] ?? '',
    //         'time' => $params['time'] ?? '2021-01-01~2021-12-31', // 时间格式 2021-01-01~2021-12-31
    //         'useForCode' => $params['useForCode'] ?? '',
    //         'znmBatchId' => $params['znmBatchId'] ?? '',
    //     ];
    //     return (new Client())->curl(Api::GET_ZNM_CODE_RECORD_LIST_API, 'POST', $httpParams);
    // }

    // 浙农码--根据codeCredentials获取浙农码信息
    // public function getZnmInfoByCodeCredentials(String $codeCredentials, $isDecode = true)
    // {
    //     $client = new Client([
    //         'verify' => false,
    //     ]);
    //     $urlPrefix = rtrim(env('ZNM_URL'), '/api');
    //     $url = $urlPrefix . Config::ZNM_CODE_CREDENTIALS_URL;
    //     $response = $client->request('POST', $url, [
    //         'json' => [
    //             'codeCredentials' => $codeCredentials,
    //             'scanEntryType' => Config::ZNM_SCAN_ENTRY_TYPE_COMMON,
    //         ],
    //     ]);
    //     if ($response->getStatusCode() == 200) {
    //         $contents = $response->getBody()->getContents();
    //         if ($isDecode) {
    //             return \GuzzleHttp\json_decode($contents, true);
    //         } else {
    //             return $contents;
    //         }
    //     }
    // }
}
