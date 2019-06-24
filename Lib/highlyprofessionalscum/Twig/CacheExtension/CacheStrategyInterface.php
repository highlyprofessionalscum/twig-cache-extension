<?php


namespace highlyprofessionalscum\Twig\CacheExtension;

interface CacheStrategyInterface
{

    public function fetchBlock($key): ?string;


    public function generateKey($annotation, $value): string;


    public function saveBlock($key, $block, $ttl = null): bool;
}
