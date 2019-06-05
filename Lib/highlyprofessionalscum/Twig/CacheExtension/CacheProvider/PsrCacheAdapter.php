<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheProvider;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use Psr\Cache\CacheItemPoolInterface;

class PsrCacheAdapter implements CacheProviderInterface
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
     * @param string $key
     * @return mixed|false
     */
    public function fetch($key)
    {
        // PSR-6 implementation returns null, CacheProviderInterface expects false
        $item = $this->cache->getItem($key);
        if ($item->isHit()) {
            return $item->get();
        }

        return false;
    }

    /**
     * @param string $key
     * @param string $value
     * @param int|\DateInterval $lifetime
     * @return bool
     */
    public function save($key, $value, $lifetime = 0)
    {
        $item = $this->cache->getItem($key);
        $item->set($value);
        $item->expiresAfter($lifetime);

        return $this->cache->save($item);
    }
}