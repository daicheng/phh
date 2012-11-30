<?php

class HtmlDoctype extends HtmlNode
{
    const HTML5 = 'html5';

    protected $_typeCollection = array(
        'html5',
    );

    public function __construct( $docType )
    {
        $this->_tagName = "!DOCTYPE";
        $this->_pair = false;
        $this->attr( 'HTML', null );
    }

    public function saveHtml( $endSlash = '' )
    {
        return parent::saveHtml( $endSlash );
    }
}
