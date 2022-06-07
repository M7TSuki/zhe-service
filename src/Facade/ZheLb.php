<?php

namespace ZheService\Facade;

use Illuminate\Support\Facades\Facade;

class ZheLb extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ZheLb';
    }
}