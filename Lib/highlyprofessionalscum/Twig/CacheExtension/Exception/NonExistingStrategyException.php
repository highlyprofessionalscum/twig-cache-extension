<?php

namespace highlyprofessionalscum\Twig\CacheExtension\Exception;

class NonExistingStrategyException extends BaseException
{

    public function __construct($strategyKey, $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('No strategy configured with key "%s".', $strategyKey), $code, $previous);
    }
}