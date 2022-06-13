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
}
