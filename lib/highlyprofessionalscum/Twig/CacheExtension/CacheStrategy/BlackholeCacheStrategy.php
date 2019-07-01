<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheStrategy;


use highlyprofessionalscum\Twig\CacheExtension\CacheStrategyInterface;

class BlackholeCacheStrategy implements CacheStrategyInterface
{

    public function fetchBlock(string $key): ?string
    {
        return null;
    }


    public function generateKey($annotation, $value) : string
    {
        return (string) microtime(true) . mt_rand();
    }


    public function saveBlock(string $key,string $block, ?int $ttl = null) : bool
    {
        return false;
    }
}
