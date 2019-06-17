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
     * @param array $strategies
     */
    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchBlock($key): string
    {
        return $this->strategies[$key['strategyKey']]->fetchBlock($key['key']);
    }

    /**
     * {@inheritDoc}
     */
    public function generateKey($annotation, $value): array
    {
        if (!is_array($value) || null === $strategyKey = key($value)) {
            throw new NonExistingStrategyKeyException();
        }

        if (!isset($this->strategies[$strategyKey])) {
            throw new NonExistingStrategyException($strategyKey);
        }

        return array(
            'strategyKey' => $strategyKey,
            'key'         => $this->strategies[$strategyKey]->generateKey($annotation, current($value)),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function saveBlock($key, $block) : bool
    {
        return $this->strategies[$key['strategyKey']]->saveBlock($key['key'], $block);
    }
}
