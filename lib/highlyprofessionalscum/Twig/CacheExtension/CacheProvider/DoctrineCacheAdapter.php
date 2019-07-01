<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheProvider;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use Doctrine\Common\Cache\Cache;

class DoctrineCacheAdapter implements CacheProviderInterface
{

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
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