<?php

namespace highlyprofessionalscum\Twig\CacheExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Extension extends AbstractExtension
{

    private $cacheStrategy;

    /**
     * @param CacheStrategyInterface $cacheStrategy
     */
    public function __construct(CacheStrategyInterface $cacheStrategy)
    {
        $this->cacheStrategy = $cacheStrategy;
    }
    /**
     * @return CacheStrategyInterface
     */
    public function getCacheStrategy() : CacheStrategyInterface
    {
        return $this->cacheStrategy;
    }
    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return get_class($this);
    }
    /**
     * {@inheritDoc}
     */
    public function getTokenParsers()
    {
        return [
            new TokenParser\Cache(),
        ];
    }
}
