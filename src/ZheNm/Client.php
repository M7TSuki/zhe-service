<?php

namespace ZheService\ZheNm;

use function GuzzleHttp\json_decode;
use GuzzleHttp\Client as GuzzleClient;

class Client
{
    public function curl($url, $method = 'GET', $httpParams = [], $isDecode = true, $needToken = true)
    {
        $client = new GuzzleClient([
            'verify' => false,
        ]);
        $queryKey = $method === 'GET' ? 'query' : 'json';
        $params = [$queryKey => $httpParams];

        if ($needToken) {
            $params['headers'] = ['Authorization' => (new Token())->token()];
        }

        $response = $client->request($method, $url, $params);
        if ($response->getStatusCode() == 200) {
            $contents = $response->getBody()->getContents();
            if ($isDecode) {
                return json_decode($contents, true);
            }
            return $contents;
        }
    }
}
