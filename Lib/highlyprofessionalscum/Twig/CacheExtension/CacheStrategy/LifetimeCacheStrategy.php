<?php


namespace highlyprofessionalscum\Twig\CacheExtension\CacheStrategy;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use highlyprofessionalscum\Twig\CacheExtension\CacheStrategyInterface;
use highlyprofessionalscum\Twig\CacheExtension\Exception\InvalidCacheLifetimeException;

class LifetimeCacheStrategy implements CacheStrategyInterface
{
    private $cache;


    public function __construct(CacheProviderInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchBlock($key)
    {
        return $this->cache->fetch($key['key']);
    }

    /**
     * {@inheritDoc}
     */
    public function generateKey($annotation, $value)
    {
        if (!is_numeric($value)) {
            throw new InvalidCacheLifetimeException($value);
        }

        return array(
            'lifetime' => $value,
            'key'      => '__LCS__' . $annotation,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function saveBlock($key, $block)
    {
        return $this->cache->save($key['key'], $block, $key['lifetime']);
    }
}
