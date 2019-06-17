<?php


namespace highlyprofessionalscum\Twig\CacheExtension;

interface CacheStrategyInterface
{

    public function fetchBlock($key): ?string;


    public function generateKey($annotation, $value);


    public function saveBlock($key, $block): bool;
}
