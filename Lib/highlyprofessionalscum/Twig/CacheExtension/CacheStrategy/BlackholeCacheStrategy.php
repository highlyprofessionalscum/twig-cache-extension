<?php

namespace highlyprofessionalscum\Twig\CacheExtension;


use highlyprofessionalscum\Twig\CacheExtension\CacheStrategyInterface;

class BlackholeCacheStrategy implements CacheStrategyInterface
{

    public function fetchBlock($key)
    {
        return false;
    }


    public function generateKey($annotation, $value)
    {
        return microtime(true) . mt_rand();
    }


    public function saveBlock($key, $block)
    {
    }
}
