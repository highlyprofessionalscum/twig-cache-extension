<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheProvider;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

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
     * @throws InvalidArgumentException
     */
    public function fetch($key) : ?string
    {
        $item = $this->cache->getItem($key);

        return  $item->isHit() ? $item->get() : null;
    }

    /**
     * @param string $key
     * @param string $value
     * @param int|\DateInterval|null $lifetime
     * @return bool
     * @throws InvalidArgumentException
     */
    public function save($key, $value, $lifetime = null) : bool
    {
        $item = $this->cache->getItem($key);
        $item->set($value);
        $item->expiresAfter($lifetime);

        return $this->cache->save($item);
    }
}