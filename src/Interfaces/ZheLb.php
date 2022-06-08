<?php

namespace ZheService\Interfaces;

interface ZheLb
{
    public function personalTicket(String $st);

    public function personalInfo(String $token);

    public function legalInfo(String $ssotoken);
}