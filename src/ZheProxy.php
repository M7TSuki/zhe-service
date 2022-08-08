<?php

namespace ZheService;

use ZheService\Interfaces\Image as ImageInterface;
use ZheService\Interfaces\ZheLb;
use ZheService\Interfaces\ZheNm;
use ZheService\ZheLb\Image;
use ZheService\ZheLb\Services as zlbService;
use ZheService\ZheNm\Services as znmService;

class ZheProxy implements ZheLb, ZheNm, ImageInterface
{
    private static $zlbInstance;
    private static $imageInstance;
    private static $znmInstance;

    public function personalTicket(String $st)
    {
        if (!isset(self::$zlbInstance)) {
            self::$zlbInstance = new zlbService();
        }
        return self::$zlbInstance->{__FUNCTION__}($st);
    }

    public function personalInfo(String $token)
    {
        if (!isset(self::$zlbInstance)) {
            self::$zlbInstance = new zlbService();
        }
        return self::$zlbInstance->{__FUNCTION__}($token);
    }
    
    public function legalInfo(String $ssotoken)
    {
        if (!isset(self::$zlbInstance)) {
            self::$zlbInstance = new zlbService();
        }
        return self::$zlbInstance->{__FUNCTION__}($ssotoken);
    }

    public function applyCode(array $params)
    {
        if (!isset(self::$znmInstance)) {
            self::$znmInstance = new znmService();
        }
        return self::$znmInstance->{__FUNCTION__}($params);
    }

    public function updateCode(array $params)
    {
        if (!isset(self::$znmInstance)) {
            self::$znmInstance = new znmService();
        }
        return self::$znmInstance->{__FUNCTION__}($params);
    }

    public function codeInfo(String $znm_uid)
    {
        if (!isset(self::$znmInstance)) {
            self::$znmInstance = new znmService();
        }
        return self::$znmInstance->{__FUNCTION__}($znm_uid);
    }

    public function codeDisplay(array $params)
    {
        if (!isset(self::$znmInstance)) {
            self::$znmInstance = new znmService();
        }
        return self::$znmInstance->{__FUNCTION__}($params);
    }

    public function imageInfo(String $osspath)
    {
        if (!isset(self::$imageInstance)) {
            self::$imageInstance = new Image();
        }
        return self::$zlbInstance->{__FUNCTION__}($osspath);
    }

    public function ssoToken(String $ticketId, String $appId)
    {
        if (!isset(self::$zlbInstance)) {
            self::$zlbInstance = new zlbService();
        }
        return self::$zlbInstance->{__FUNCTION__}($ticketId, $appId);
    }

    public function ssoInfo(String $token)
    {
        if (!isset(self::$zlbInstance)) {
            self::$zlbInstance = new zlbService();
        }
        return self::$zlbInstance->{__FUNCTION__}($token);
    }
}
