<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheProvider;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class PsrCacheAdapter implements CacheProviderInterface
{


    private $cache;


    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }



    public function fetch(string $key) : ?string
    {
        $item = $this->cache->getItem($key);

        return  $item->isHit() ? $item->get() : null;
    }


    public function save(string $key, string  $value, ?int $lifetime = 0): bool
    {
        $item = $this->cache->getItem($key);
        $item->set($value);
        $item->expiresAfter($lifetime);

        return $this->cache->save($item);
    }
}
