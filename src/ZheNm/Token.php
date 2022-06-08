<?php

namespace ZheService\ZheNm;

use Illuminate\Support\Facades\Redis;
use ZheService\Exceptions\ApiException;
use ZheService\ZheNm\Consts\Api;
use ZheService\ZheNm\Consts\Config;

class Token
{
    // 获取浙农码认证登录返回的token
    public function token()
    {
        $token = Redis::get(Config::ZHE_NM_TOKEN_KEY);
        if ($token) {
            return $token;
        }
        $token = $this->oauthToken();
        $status = Redis::setex(Config::ZHE_NM_TOKEN_KEY, Config::ZHE_NM_TOKEN_EXPIRE, $token);
        if (!$status) {
            return Redis::get(Config::ZHE_NM_TOKEN_KEY);
        }
        return $token;
    }

    // 浙农码--认证登录
    private function oauthToken()
    {
        $client = new Client();

        $response = $client->curl(Api::OAUTH_TOKEN_API, 'POST', [
            'clientId' => $client->getClientId(),
            'clientSecret' => $client->getClientSecret(),
            'grantType' => 'client_credentials',
        ], true, false);

        if ($response['state'] != 200) {
            throw new ApiException(['msg' => '系统异常.', 'code' => 1]);
        }
        $tokenType = $response['results']['tokenType'] ?? '';
        $accessToken = $response['results']['accessToken'] ?? '';
        return $tokenType . ' ' . $accessToken;
    }
}
