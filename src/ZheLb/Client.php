<?php

namespace ZheService\ZheLb;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * 生成请求头
     *
     * @param [type] $HTTP_URI 接口地址
     * @param [type] $type 区分用户
     * @return Array
     */

    public function getHeaders($HTTP_URI, $type = null)
    {
        $gmDate = gmdate("D, d M Y H:i:s ") . "GMT";
        $headers = [
            'X-BG-HMAC-SIGNATURE' => $this->getSignature($HTTP_URI, $gmDate),
            'X-BG-HMAC-ALGORITHM' => 'hmac-sha256',
            'X-BG-HMAC-ACCESS-KEY' => Services::accessKey(),
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
     */
    private function getSignature($HTTP_URI, $gmDate)
    {
        $HTTP_URI = parse_url($HTTP_URI)['path'];
        $QUERY_STREAM = '';
        $signing_string = "POST" . "\n" . $HTTP_URI . "\n" . $QUERY_STREAM . "\n" . Services::accessKey() . "\n" . $gmDate . "\n";

        $hash = hash_hmac("sha256", $signing_string, Services::secretKey(), true);

        return base64_encode($hash);
    }

    /**
     * 个人登录 输入参数
     *
     * @return array
     */
    public function getHttpParams()
    {
        $time = $this->getTime();
        $sign = $this->sign($time);

        return [Services::accessKey(), $time, $sign];
    }

    // 获取时间
    private function getTime()
    {
        return strval(date('YmdHis'));
    }

    // 浙里办签名
    private function sign($time)
    {
        return strtolower(md5(Services::accessKey() . Services::secretKey() . $time));
    }

    /**
     * 请求
     *
     * @param $params
     * @return mixed
     */
    public function curl($url, $headers, $params)
    {
        $client = new GuzzleClient([
            'verify' => false,
            'headers' => $headers,
        ]);

        $response = $client->request('POST', $url, $params);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        }
    }
}
