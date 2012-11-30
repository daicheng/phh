<?php

class HtmlAttribute
{
    protected $_name;
    protected $_value;

    public function __construct( $name, $value = null )
    {
        $this->_name = $name;
        $this->_value = $value;
    }

    public function saveHtml()
    {
        $content = $this->_name;

        if ( !is_null( $this->_value ) )
            $content .= "=\"$this->_value\"";

        return $content;
    }

    public function getValue()
    {
        return $this->_value;
    }
}
