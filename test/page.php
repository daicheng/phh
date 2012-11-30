<?php

error_reporting( E_ALL | E_STRICT );
ini_set( 'display_errors', true );
ini_set( 'log_errors', false );
ini_set( 'html_errors', true );
date_default_timezone_set( 'Australia/Melbourne' );

require '../src/phh.php';

$page = new HtmlPage();

echo $page->saveHtml();
