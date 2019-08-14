<?php


namespace highlyprofessionalscum\Twig\CacheExtension\CacheStrategy;

use highlyprofessionalscum\Twig\CacheExtension\CacheStrategyInterface;
use highlyprofessionalscum\Twig\CacheExtension\Exception\NonExistingStrategyException;
use highlyprofessionalscum\Twig\CacheExtension\Exception\NonExistingStrategyKeyException;

class IndexedChainingCacheStrategy implements CacheStrategyInterface
{
    
    private $strategies;
    private $ttl;
    private $strategyKey;


    public function __construct(array $strategies, int $ttl)
    {
        $this->strategies = $strategies;
        $this->ttl = $ttl;
    }


    public function fetchBlock(string $key): ?string
    {
        return $this->strategies[$this->strategyKey]->fetchBlock($key);
    }


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


    public function saveBlock(string $key, string $block, ?int $ttl = null ) : bool
    {
        return $this->strategies[$this->strategyKey]->saveBlock($key, $block, $ttl ?? $this->ttl);
    }
}
