<?php

namespace highlyprofessionalscum\Twig\CacheExtension\Exception;


class InvalidCacheLifetimeException extends BaseException
{
    public function __construct($lifetime, $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('Value "%s" is not a valid lifetime.', gettype($lifetime)), $code, $previous);
    }
}