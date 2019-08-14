<?php

namespace highlyprofessionalscum\Twig\CacheExtension;

interface KeyGeneratorInterface
{
    public function generateKey($value): string;
}
