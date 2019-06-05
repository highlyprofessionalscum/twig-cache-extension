<?php


namespace highlyprofessionalscum\Twig\CacheExtension\Node;

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

        $extension = 'highlyprofessionalscum\Twig\CacheExtension\Extension';

        $compiler
            ->addDebugInfo($this)
            ->write("\$highlyprofessionalscumCacheStrategy".$i." = \$this->env->getExtension('{$extension}')->getCacheStrategy();\n")
            ->write("\$highlyprofessionalscumKey".$i." = \$highlyprofessionalscumCacheStrategy".$i."->generateKey(")
            ->subcompile($this->getNode('annotation'))
            ->raw(", ")
            ->subcompile($this->getNode('key_info'))
            ->write(");\n")
            ->write("\$highlyprofessionalscumCacheBody".$i." = \$highlyprofessionalscumCacheStrategy".$i."->fetchBlock(\$highlyprofessionalscumKey".$i.");\n")
            ->write("if (\$highlyprofessionalscumCacheBody".$i." === false) {\n")
            ->indent()
            ->write("ob_start();\n")
            ->indent()
            ->subcompile($this->getNode('body'))
            ->outdent()
            ->write("\n")
            ->write("\$highlyprofessionalscumCacheBody".$i." = ob_get_clean();\n")
            ->write("\$highlyprofessionalscumCacheStrategy".$i."->saveBlock(\$highlyprofessionalscumKey".$i.", \$highlyprofessionalscumCacheBody".$i.");\n")
            ->outdent()
            ->write("}\n")
            ->write("echo \$highlyprofessionalscumCacheBody".$i.";\n")
        ;
    }
}
