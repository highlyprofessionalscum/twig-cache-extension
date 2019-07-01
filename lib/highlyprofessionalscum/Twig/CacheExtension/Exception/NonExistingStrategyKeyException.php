<?php

namespace highlyprofessionalscum\Twig\CacheExtension\Exception;

class NonExistingStrategyKeyException extends BaseException
{

    public function __construct($message = 'No strategy key found in value.', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}