<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheProvider;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;

class SymfonyCacheAdapter implements CacheProviderInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }


    /**
     * {@inheritDoc}
     */
    public function fetch(string $key): string
    {
        $item = $this->cache->getItem($key);

        return  $item->isHit() ? $item->get() : null;
    }


    /**
     * {@inheritDoc}
     */
    public function save(string $key, string  $value, ?int $lifetime = 0): bool
    {
        return $this->cache->save($key, $value, $lifetime);
    }
}
