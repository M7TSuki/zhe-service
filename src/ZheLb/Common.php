<?php

namespace ZheService\ZheLb;

use GuzzleHttp\Client;

class Common
{
    /**
     * 生成请求头
     *
     * @param [type] $HTTP_URI 接口地址
     * @param [type] $type 区分用户
     * @return void
     * @author Dunstan
     * @date 2022-05-31
     */
    public function getHeaders($HTTP_URI, $type = null)
    {
        $gmDate = gmdate("D, d M Y H:i:s ") . "GMT";
        $headers = [
            'X-BG-HMAC-SIGNATURE' => $this->getSignature($HTTP_URI, $gmDate),
            'X-BG-HMAC-ALGORITHM' => 'hmac-sha256',
            'X-BG-HMAC-ACCESS-KEY' => env('ZLB_ACCESS_KEY'),
            'X-BG-DATE-TIME' => $gmDate,
        ];

        if ($type) {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }
        
        return $headers;
    }

    /**
     * 生成signature
     *
     * @param [type] $HTTP_URI 接口URI
     * @param [type] $gmDate
     * @return String
     * @author Dunstan
     * @date 2022-05-31
     */
    private function getSignature($HTTP_URI, $gmDate)
    {
        $QUERY_STREAM = '';
        $signing_string = "POST" . "\n" . $HTTP_URI . "\n" . $QUERY_STREAM . "\n" . env('ZLB_ACCESS_KEY') . "\n" . $gmDate . "\n";

        $hash = hash_hmac("sha256", $signing_string, env('ZLB_SECRET_KEY'), true);

        return base64_encode($hash);
    }

    /**
     * 个人登录 输入参数
     *
     * @return array
     * @author Dunstan
     * @date 2022-05-31
     */
    public function getHttpParams()
    {
        $time = $this->getTime();
        $sign = $this->sign($time);

        return [env('ZLB_ACCESS_KEY'), $time, $sign];
    }

    // 获取时间
    private function getTime()
    {
        return strval(date('YmdHis'));
    }

    // 浙里办签名
    private function sign($time)
    {
        return strtolower(md5(env('ZLB_ACCESS_KEY') . env('ZLB_SECRET_KEY') . $time));
    }

    /**
     * 请求
     *
     * @param $params
     * @return mixed
     */
    public function curl($url, $headers, $params)
    {
        $client = new Client([
            'verify' => false,
            'headers' => $headers,
        ]);

        $response = $client->request('POST', $url, $params);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        }
    }
}
