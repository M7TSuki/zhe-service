<?php

namespace ZheService\ZheLb;

use App\Models\Images;
use GuzzleHttp\Client;
use zheService\Exceptions\ApiException;

class OssService
{
    // 获取图片的基本信息
    public function getImageInfo($params, $userId)
    {
        if (!isset($params['osspath'])) {
            throw new ApiException(["code" => 1, "msg" => "图片路径不能为空"]);
        }

        return $this->addImageToDbImages(urldecode($params['osspath']), $userId);
    }
    
    // 上传图片到自己服务器的`lv_image`表
    private function addImageToDbImages($osspath, $userId)
    {
        $imageInfo = $this->getOssImageInfo($osspath);

        $imageUrl = $osspath;
        $width = $imageInfo['ImageWidth']['value'];
        $height = $imageInfo['ImageHeight']['value'];
        $size = $imageInfo['FileSize']['value'];
        $status = 0;
        $ossArr = explode('/', $osspath);
        $title = $ossArr[4] ?? '';
        $titleArr = explode('.', $title);
        $imageNo = $titleArr[0] ?? '';
        $titleCount = count($titleArr);
        $suffix = $titleArr[$titleCount - 1];

        if ($isExist = Images::getImageInfoByImageNo($imageNo)) {
            return $isExist;
        }

        $imageId = Images::query()->insertGetId(
            [
                'user_id' => $userId,
                'user_type' => 1,
                'title' => $title,
                'path_class' => $ossArr['3'] ?? '',
                'image_no' => $imageNo,
                'suffix' => $suffix,
                'size' => $size,
                'width' => $width,
                'height' => $height,
                'status' => $status,
            ]);

        return [
            'id' => $imageId,
            'url' => $imageUrl,
            'width' => $width,
            'height' => $height,
        ];
    }

    // 获取oss图片的基本信息
    private function getOssImageInfo($osspath)
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
