<?php

namespace ZheService\Exceptions;

use RuntimeException;
use Throwable;

class ApiException extends RuntimeException
{
    /**
     * ApiException constructor.
     *
     * @param array $codeInfo
     * @param array $formatKeys
     * @param Throwable|null $previous
     */
    public function __construct(array $codeInfo, array $formatKeys = [], Throwable $previous = null)
    {
        $message = $codeInfo['msg'];
        if (!empty($formatKeys)) {
            $message = call_user_func_array('sprintf', array_merge([$message], $formatKeys));
        }
        parent::__construct($message, $codeInfo['code'], $previous);
    }
}
