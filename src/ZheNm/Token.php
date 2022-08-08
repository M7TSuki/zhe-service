<?php

namespace ZheService\ZheNm;

use Illuminate\Support\Facades\Redis;
use ZheService\Exceptions\ApiException;

class Token
{
    /**
     * 获取浙农码认证登录返回的token
     *
     * @return void
     */
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

    /**
     * 浙农码--认证登录
     *
     * @return void
     */
    private function oauthToken()
    {
        $client = new Client();

        $response = $client->curl(Services::$domain . Config::OAUTH_TOKEN_API, 'POST', [
            'clientId' => Services::$clientId,
            'clientSecret' => Services::$clientSecret,
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
