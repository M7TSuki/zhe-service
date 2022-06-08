<?php

namespace ZheService\Interfaces;

interface ZheNm
{
    public function applyCode(array $params);

    public function updateCode(array $params);

    public function codeInfo(String $params);

    public function codeDisplay(array $params);
}