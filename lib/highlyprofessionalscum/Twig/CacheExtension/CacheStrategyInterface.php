<?php


namespace highlyprofessionalscum\Twig\CacheExtension;

interface CacheStrategyInterface
{

    public function fetchBlock(string $key): ?string;


    public function generateKey($annotation, $value): string;


    public function saveBlock(string $key, string $block, ?int $ttl = null): bool;
}
