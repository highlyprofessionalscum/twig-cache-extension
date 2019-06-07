<?php

namespace highlyprofessionalscum\Twig\CacheExtension\CacheStrategy;


use highlyprofessionalscum\Twig\CacheExtension\CacheStrategyInterface;

class BlackholeCacheStrategy implements CacheStrategyInterface
{

    public function fetchBlock($key) : bool
    {
        return false;
    }


    public function generateKey($annotation, $value) : string
    {
        return (string) microtime(true) . mt_rand();
    }


    public function saveBlock($key, $block) : bool
    {
        return false;
    }
}
