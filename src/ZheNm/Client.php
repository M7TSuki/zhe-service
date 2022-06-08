<?php

namespace ZheService\ZheNm;

use function GuzzleHttp\json_decode;
use GuzzleHttp\Client as GuzzleClient;
use ZheService\Exceptions\ApiException;

class Client
{
    // 浙农码--clientId
    private $clientId = '';

    // 浙农码--clientSecret
    private $clientSecret = '';

    // 浙农码--服务url
    private $znmUrl = '';

    public function __construct()
    {
        $this->clientId = env('ZNM_CLIENT_ID');
        $this->clientSecret = env('ZNM_CLIENT_SECRET');

        $env = env('ZNM_ENV');
        if (!isset($this->clientId, $this->clientSecret, $env)) {
            throw new ApiException(['msg' => '请配置开发环境参数.', 'code' => 1]);
        }
        // TODO 确认正确地址
        $this->znmUrl = $env == 'live' ? 'https://znm.zjagri.cn/api/' : 'https://znm.zjagri.cn/api/';
    }

    // 获取客户端id
    public function getClientId()
    {
        return $this->clientId;
    }

    // 获取客户端密钥
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    // curl请求
    public function curl($api, $method = 'GET', $httpParams = [], $isDecode = true, $needToken = true)
    {
        $client = new GuzzleClient([
            'verify' => false,
        ]);
        $queryKey = $method === 'GET' ? 'query' : 'json';
        $url = $this->znmUrl . $api;
        $curlParams = [$queryKey => $httpParams];
        if ($needToken) {
            $curlParams['headers'] = (new Token())->token();
        }

        $response = $client->request($method, $url, $curlParams);
        if ($response->getStatusCode() == 200) {
            $contents = $response->getBody()->getContents();
            if ($isDecode) {
                return json_decode($contents, true);
            } else {
                return $contents;
            }
        }
    }
}
