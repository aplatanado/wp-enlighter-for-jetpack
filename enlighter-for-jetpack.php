<?php
/**
 * Plugin Name: Enlighter for Jetpack
 * Depends: Enlighter
 * Description: This is a simple plugin to improve the integration of Enlighter with Jetpack.
 * Version: 0.1
 * Author: Jesús Torres
 * Author URI: http://jmtorres.webs.ull.es/
 * License: Apache 2.0
 */

define('ENLIGHTER_FOR_JETPACK_PLUGIN_PATH', dirname(__FILE__));
 
if ( class_exists( 'Enlighter' ) )  {
	// load classes
	require_once( ENLIGHTER_FOR_JETPACK_PLUGIN_PATH . '/class/SyntaxHighlighter.php' );
	
	// run syntax highlighter
	SyntaxHighlighter::run();
}