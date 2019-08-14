<?php
namespace  highlyprofessionalscum\TwigCacheBundle\KeyGenerator;

use highlyprofessionalscum\Twig\CacheExtension\KeyGeneratorInterface;

/**
 * Key generator based on spl_object_hash.
 *
 */
class SplObjectHashKeyGenerator implements KeyGeneratorInterface
{

    public function generateKey($value) : string
    {
        if (!is_object($value)) {
            $value = (object) $value;
        }

        return spl_object_hash($value);
    }
}
