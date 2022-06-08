<?php

namespace ZheService\ZheLb;

use GuzzleHttp\Client;
use ZheService\Interfaces\Image as ImageInterface;

class Image implements ImageInterface
{       
    /**
     * 从oss获取图片信息
     *
     * @param String $osspath
     * @return void
     * @author Dunstan
     * @date 2022-06-08
     */
    public function imageInfo(String $osspath)
    {
        $client = new Client([
            'verify' => false,
        ]);
        
        $routeParams = '?x-oss-process=image/info';
        $url = $osspath . $routeParams;
        $response = $client->get($url);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        }
        return [];
    }
}
