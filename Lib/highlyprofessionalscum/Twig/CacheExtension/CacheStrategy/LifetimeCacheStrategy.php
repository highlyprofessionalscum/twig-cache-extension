<?php


namespace highlyprofessionalscum\Twig\CacheExtension\CacheStrategy;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use highlyprofessionalscum\Twig\CacheExtension\CacheStrategyInterface;
use highlyprofessionalscum\Twig\CacheExtension\Exception\InvalidCacheLifetimeException;

class LifetimeCacheStrategy implements CacheStrategyInterface
{
    /**
     * @var CacheProviderInterface
     */
    private $cache;

    /**
     * @var int
     */
    private $ttl;


    public function __construct(CacheProviderInterface $cache, int $ttl)
    {
        $this->cache = $cache;
        $this->ttl   = $ttl;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchBlock(string $key): ?string
    {
        return $this->cache->fetch($key);
    }

    /**
     * {@inheritDoc}
     */
    public function generateKey($annotation, $value) : string
    {
        if (!is_numeric($value)) {
            throw new InvalidCacheLifetimeException($value);
        }

        $this->ttl = $value;

        return '__LCS__' . $annotation;
    }

    /**
     * {@inheritDoc}
     */
    public function saveBlock(string $key, string $block, ?int $ttl = null): bool
    {
        return $this->cache->save($key, $block, $ttl ?? $this->ttl);
    }
}
