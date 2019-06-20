<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheProvider;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use Symfony\Contracts\Cache;

class SymfonyCacheAdapter implements CacheProviderInterface
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
        $item = $this->cache->getItem($key);

        return  $item->isHit() ? $item->get() : null;
    }


    /**
     * {@inheritDoc}
     */
    public function save($key, $value, $lifetime = 0): bool
    {
        return $this->cache->save($key, $value, $lifetime);
    }
}
