<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheProvider;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use Doctrine\Common\Cache\Cache;

class DoctrineCacheAdapter implements CacheProviderInterface
{


    private $cache;


    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }



    public function fetch(string $key): string
    {
        return $this->cache->fetch($key);
    }



    public function save(string $key, string  $value, ?int $lifetime = 0): bool
    {
        return $this->cache->save($key, $value, $lifetime);
    }
}
