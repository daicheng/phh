<?php

require 'HtmlNode.php';
require 'HtmlDoctype.php';

class HtmlPage extends HtmlNode
{
    protected $_docType;
    protected $_head;
    protected $_body;

    public function __construct( $docType = HtmlDoctype::HTML5 )
    {
        $this->_tagName = 'html';
        $this->_pair = true;
        $this->_docType = $docType;
        
        $this->addNode( new HtmlNode( 'head' ) )
             ->appendNode( new HtmlNode( 'body' ) )
             ->addNode( new HtmlNode( 'div', 'contentWrapper', 'Hello world from PHH!' ) )
        ;
    }

    public function saveHtml( $endSlash = '/' )
    {
        
        $docTypeNode = new HtmlDoctype( $this->_docType );
        $content = $docTypeNode->saveHtml();
        $content .= parent::saveHtml();

        return $content;
    }
}
