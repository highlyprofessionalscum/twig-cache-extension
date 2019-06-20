<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheProvider;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class DoctrineCacheAdapter implements CacheProviderInterface
{

    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }


    /**
     * {@inheritDoc}
     */
    public function fetch($key): string
    {
        return $this->cache->fetch($key);
    }


    /**
     * {@inheritDoc}
     */
    public function save($key, $value, $lifetime = 0): bool
    {
        return $this->cache->save($key, $value, $lifetime);
    }
}