<?php


namespace highlyprofessionalscum\Twig\CacheExtension\CacheStrategy;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use highlyprofessionalscum\Twig\CacheExtension\CacheStrategyInterface;
use highlyprofessionalscum\Twig\CacheExtension\Exception\InvalidCacheKeyException;
use highlyprofessionalscum\Twig\CacheExtension\KeyGeneratorInterface;


class GenerationalCacheStrategy implements CacheStrategyInterface
{
    private $keyGenerator;

    private $cache;

    private $ttl;


    public function __construct(CacheProviderInterface $cache, KeyGeneratorInterface $keyGenerator, int $ttl)
    {
        $this->keyGenerator = $keyGenerator;
        $this->cache        = $cache;
        $this->ttl          = $ttl;
    }

    public function fetchBlock(string $key): ?string
    {
        return $this->cache->fetch($key);
    }

    public function generateKey($annotation, $value): string
    {
        $key = $this->keyGenerator->generateKey($value);

        if (null === $key) {
            throw new InvalidCacheKeyException();
        }

        return $annotation . '__GCS__' . $key;
    }

    public function saveBlock(string $key, string $block, ?int $ttl = null ) : bool
    {
        return $this->cache->save($key, $block, $ttl ?? $this->ttl);
    }

}
