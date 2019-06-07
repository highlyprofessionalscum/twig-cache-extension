<?php

namespace highlyprofessionalscum\Twig\CacheExtension\Exception;

class InvalidCacheKeyException extends BaseException
{
    public function __construct($message = 'Key generator did not return a key.', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}