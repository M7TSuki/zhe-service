<?php

namespace ZheService\ZheLb;

use GuzzleHttp\Client;
use ZheService\Interfaces\Image as ImageInterface;

class Image implements ImageInterface
{
    /**
     * 从oss获取图片信息
     *
     * @param String $ossPath
     * @return void
     */
    public function imageInfo(String $ossPath)
    {
        $client = new Client([
            'verify' => false,
        ]);

        $routeParams = '?x-oss-process=image/info';
        $response = $client->get($ossPath . $routeParams);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        }
        return [];
    }
}
