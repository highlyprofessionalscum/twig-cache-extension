<?php


namespace highlyprofessionalscum\Twig\CacheExtension\TokenParser;

use Twig\TokenParser\AbstractTokenParser;
use Twig\Token;
use highlyprofessionalscum\Twig\CacheExtension\Node\CacheNode;

class Cache extends AbstractTokenParser
{
    public function decideCacheEnd(Token $token) : bool
    {
        return $token->test('endcache');
    }


    public function getTag() : string
    {
        return 'cache';
    }


    public function parse(Token $token): CacheNode
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $annotation = $this->parser->getExpressionParser()->parseExpression();

        $key = $this->parser->getExpressionParser()->parseExpression();

        $stream->expect(Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideCacheEnd'), true);
        $stream->expect(Token::BLOCK_END_TYPE);

        return new CacheNode($annotation, $key, $body, $lineno, $this->getTag());
    }
}