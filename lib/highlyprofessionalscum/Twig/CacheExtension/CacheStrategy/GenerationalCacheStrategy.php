<?php


namespace highlyprofessionalscum\Twig\CacheExtension\CacheStrategy;

use highlyprofessionalscum\Twig\CacheExtension\CacheProviderInterface;
use highlyprofessionalscum\Twig\CacheExtension\CacheStrategyInterface;
use highlyprofessionalscum\Twig\CacheExtension\Exception\InvalidCacheKeyException;
use highlyprofessionalscum\Twig\CacheExtension\KeyGeneratorInterface;

/**
 * Strategy for generational caching.
 *
 * In theory the strategy only saves fragments to the cache with infinite
 * lifetime. The key of the strategy lies in the fact that the keys for blocks
 * will change as the value for which the key is generated changes.
 *
 * For example: entities containing a last update time, would include a
 * timestamp in the key.
 *
 * @see http://37signals.com/svn/posts/3113-how-key-based-cache-expiration-works
 *
 */
class GenerationalCacheStrategy implements CacheStrategyInterface
{
    /**
     * @var KeyGeneratorInterface
     */
    private $keyGenerator;

    /**
     * @var CacheProviderInterface
     */
    private $cache;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @param CacheProviderInterface $cache
     * @param KeyGeneratorInterface  $keyGenerator
     * @param integer                $lifetime
     */
    public function __construct(CacheProviderInterface $cache, KeyGeneratorInterface $keyGenerator, int $ttl)
    {
        $this->keyGenerator = $keyGenerator;
        $this->cache        = $cache;
        $this->ttl          = $ttl;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchBlock(string $key): ?string
    {
        return $this->cache->fetch($key);
    }

    /**
     * {@inheritDoc}
     */
    public function generateKey($annotation, $value): string
    {
        $key = $this->keyGenerator->generateKey($value);

        if (null === $key) {
            throw new InvalidCacheKeyException();
        }

        return $annotation . '__GCS__' . $key;
    }

    /**
     * {@inheritDoc}
     */
    public function saveBlock(string $key, string $block, ?int $ttl = null ) : bool
    {
        return $this->cache->save($key, $block, $ttl ?? $this->ttl);
    }

}
