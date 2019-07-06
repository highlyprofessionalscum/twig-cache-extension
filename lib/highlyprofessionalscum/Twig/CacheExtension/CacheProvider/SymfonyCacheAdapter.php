<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheProvider;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class SymfonyCacheAdapter implements CacheProviderInterface
{
    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @var \DateTime
     */
    private $lifetime;

    /**
     * @param AdapterInterface $cache
     */
    public function __construct(AdapterInterface $cache)
    {
        $this->cache = $cache;
        $this->lifetime = new \DateTime();
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
        $item = $this->cache->getItem($key);


        if (null !== $lifetime)
            $lifetime = $this->lifetime->setTimestamp(time() + $lifetime);

        $item->set($value)
            ->expiresAt($lifetime)
        ;

        return $this->cache->save($item);
    }
}
