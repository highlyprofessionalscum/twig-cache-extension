<?php

namespace highlyprofessionalscum\Twig\CacheExtension;

interface KeyGeneratorInterface
{
    /**
     * Generate a cache key for a given value.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function generateKey($value): string;

}
