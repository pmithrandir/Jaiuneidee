<?php

namespace Gloomy\PagerBundle\Twig\TokenParser;

use Gloomy\PagerBundle\Twig\Node\DatagridThemeNode;

class DatagridThemeTokenParser extends \Twig_TokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param  \Twig_Token $token A Twig_Token instance
     *
     * @return \Twig_NodeInterface A Twig_NodeInterface instance
     */
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $datagrid = $this->parser->getExpressionParser()->parseExpression();
        $resources = array();
        do {
            $resources[] = $this->parser->getExpressionParser()->parseExpression();
        } while (!$stream->test(\Twig_Token::BLOCK_END_TYPE));

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new DatagridThemeNode($datagrid, new \Twig_Node($resources), $lineno, $this->getTag());
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag()
    {
        return 'datagrid_theme';
    }
}
