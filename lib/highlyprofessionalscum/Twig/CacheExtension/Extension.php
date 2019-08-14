<?php

namespace highlyprofessionalscum\Twig\CacheExtension;

use Twig\Extension\AbstractExtension;

class Extension extends AbstractExtension
{

    private $cacheStrategy;


    public function __construct(CacheStrategyInterface $cacheStrategy)
    {
        $this->cacheStrategy = $cacheStrategy;
    }


    public function getCacheStrategy() : CacheStrategyInterface
    {
        return $this->cacheStrategy;
    }


    public function getName(): string
    {
        return get_class($this);
    }


    public function getTokenParsers(): array
    {
        return [
            new TokenParser\Cache(),
        ];
    }
}
