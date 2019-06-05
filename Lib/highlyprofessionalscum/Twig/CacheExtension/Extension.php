<?php

namespace highlyprofessionalscum\Twig\CacheExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
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
    public function getCacheStrategy()
    {
        return $this->cacheStrategy;
    }
    /**
     * {@inheritDoc}
     */
    public function getName()
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
