<?php


namespace highlyprofessionalscum\Twig\CacheExtension\CacheStrategy;

use highlyprofessionalscum\Twig\CacheExtension\CacheStrategyInterface;
use highlyprofessionalscum\Twig\CacheExtension\Exception\NonExistingStrategyException;
use highlyprofessionalscum\Twig\CacheExtension\Exception\NonExistingStrategyKeyException;

class IndexedChainingCacheStrategy implements CacheStrategyInterface
{
    /**
     * @var CacheStrategyInterface[]
     */
    private $strategies;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var string
     */
    private $strategyKey;

    /**
     * @param array $strategies
     * @param int $ttl
     */
    public function __construct(array $strategies, int $ttl)
    {
        $this->strategies = $strategies;
        $this->ttl = $ttl;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchBlock($key): ?string
    {
        return $this->strategies[$this->strategyKey]->fetchBlock($key);
    }

    /**
     * {@inheritDoc}
     */
    public function generateKey($annotation, $value): string
    {
        if (!is_array($value) || null === $strategyKey = key($value)) {
            throw new NonExistingStrategyKeyException();
        }

        if (!array_key_exists($strategyKey, $this->strategies)) {
            throw new NonExistingStrategyException($strategyKey);
        }

        $this->strategyKey = $strategyKey;

        return $this->strategies[$strategyKey]->generateKey($annotation, current($value));
    }

    /**
     * {@inheritDoc}
     */
    public function saveBlock($key, $block, $ttl = null ) : bool
    {
        return $this->strategies[$this->strategyKey]->saveBlock($key, $block, $ttl ?? $this->ttl);
    }
}
