<?php

require 'HtmlAttribute.php';

class HtmlNode
{
    /*
     *@string
     */
    protected $_tagName;
    /*
     *@bool
     */
    protected $_pair = false;
    /*
     *@array
     */
    protected $_attrs = array();
    /*
     *@array
     */
    protected $_children = array();

    protected $_content;

    public function __construct( $tagName, $id = null, $content = null )
    {
        $this->_tagName = $tagName;

        if ( !is_null( $id ) ) {
            $this->attr( 'id', $id );
            $this->attr( 'name', $id );
        }

        if ( !is_null( $content) ) $this->_content = $content;
    }

    protected function _buildNode( $params )
    {
        if ( !is_array( $params ) )
            $params = (array) $params;

        if ( count( $params ) < 3 )
            $params = array_pad( $params, 3, null );

        return new HtmlNode( $params[0], $params[1], $params[2] );
    }

    public function addNode()
    {
        if ( func_num_args() > 0 ) {
            $params = func_get_arg(0);
            if ( is_array( $params ) ) {
                foreach ( $params as $param ) {
                    if ( $param instanceof HtmlNode ) {
                        $this->_children[] = $param; 
                    } else {
                        $node = _buildNode( $param );
                        $this->_children[] = $node;
                    }
                }
            } elseif ( $params instanceof HtmlNode ) {
                $this->_children[] = $params;
            } else {
                $node = $this->_buildNode( func_get_args() );
                $this->_children[] = $node;
            }
        }

        return $this;
    }

    public function appendNode()
    {
        $param = func_get_arg(0);
        if ( $param instanceof HtmlNode ) {
            $node = $param;
        } else {
            $node = $this->_buildNode( func_get_args() );
        }

        $this->_children[] = $node;

        return $node;
    }

    public function attr()
    {
        $numOfArgs = func_num_args();
        if ( $numOfArgs == 2 ) {
            $name  = func_get_arg(0);
            $value = func_get_arg(1);

            if ( strlen( $name ) ) 
                $this->_attrs[$name] = new HtmlAttribute( $name, $value );

            return $this;
        } elseif ( $numOfArgs = 1 ) {
            $name  = func_get_arg(0);

            if ( strlen( $name ) && isset( $this->_attrs[$name] ) )
                return $this->_attrs[$name]->getValue();
        }

        return false;
    }

    public function saveHtml( $endSlash = '/' )
    {
        $content = "<{$this->_tagName}";

        if ( $this->_attrs ) {
            foreach ( $this->_attrs as $attr ) 
                $content .= ' ' . $attr->saveHtml();
        }
            
        if ( $this->_children || !is_null( $this->_content ) ) {
            $this->_pair = true;

            $content .= ">\n{$this->_content}";
            
            foreach ( $this->_children as $child ) 
                $content .= $child->saveHtml();

            $content .= "<{$endSlash}{$this->_tagName}>\n";
        } else {
            $content .= "{$endSlash}>\n";
        }

        return $content;
    }
}
