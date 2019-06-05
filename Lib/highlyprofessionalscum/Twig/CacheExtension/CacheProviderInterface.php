<?php


namespace highlyprofessionalscum\Twig\CacheExtension;

interface CacheProviderInterface

{
    /**
     * @param string $key
     *
     * @return mixed False, if there was no value to be fetched. Null or a string otherwise.
     */
    public function fetch($key);
    /**
     * @param string  $key
     * @param string  $value
     * @param integer $lifetime
     *
     * @return boolean
     */
    public function save($key, $value, $lifetime = 0);
}