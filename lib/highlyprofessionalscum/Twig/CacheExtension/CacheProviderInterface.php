<?php


namespace highlyprofessionalscum\Twig\CacheExtension;

interface CacheProviderInterface

{

    public function fetch(string $key): ?string;

    public function save(string $key, string  $value, ?int $lifetime = 0): bool;
}
