<?php


namespace highlyprofessionalscum\Twig\CacheExtension;

use Twig\Node\Node;
use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Environment;

class CacheNode extends Node
{
    private static $cacheCount = 1;


    public function __construct(AbstractExpression $annotation, AbstractExpression $keyInfo, Node $body, $lineno, $tag = null)
    {
        parent::__construct(array('key_info' => $keyInfo, 'body' => $body, 'annotation' => $annotation), array(), $lineno, $tag);
    }


    public function compile(Compiler $compiler)
    {
        $i = self::$cacheCount++;

        if (version_compare(Environment::VERSION, '1.26.0', '>=')) {
            $extension = 'Asm89\Twig\CacheExtension\Extension';
        } else {
            $extension = 'asm89_cache';
        }

        $compiler
            ->addDebugInfo($this)
            ->write("\$asm89CacheStrategy".$i." = \$this->env->getExtension('{$extension}')->getCacheStrategy();\n")
            ->write("\$asm89Key".$i." = \$asm89CacheStrategy".$i."->generateKey(")
            ->subcompile($this->getNode('annotation'))
            ->raw(", ")
            ->subcompile($this->getNode('key_info'))
            ->write(");\n")
            ->write("\$asm89CacheBody".$i." = \$asm89CacheStrategy".$i."->fetchBlock(\$asm89Key".$i.");\n")
            ->write("if (\$asm89CacheBody".$i." === false) {\n")
            ->indent()
            ->write("ob_start();\n")
            ->indent()
            ->subcompile($this->getNode('body'))
            ->outdent()
            ->write("\n")
            ->write("\$asm89CacheBody".$i." = ob_get_clean();\n")
            ->write("\$asm89CacheStrategy".$i."->saveBlock(\$asm89Key".$i.", \$asm89CacheBody".$i.");\n")
            ->outdent()
            ->write("}\n")
            ->write("echo \$asm89CacheBody".$i.";\n")
        ;
    }
}
