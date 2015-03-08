<?php
/**
 * SyntaxHighlighter class
 * Version: 0.1
 * Author: Jesús Torres
 * Author URI: http://jmtorres.webs.ull.es/
 * License: Apache 2.0
 */

class SyntaxHighlighter {
	// singleton instance
	private static $__instance;
	
	// supported languages mapping
	private $_supportedLanguagesMap = array(
		'sh' => 'shell'
	);
	
	// get singelton instance
	public static function getInstance() {
		if ( self::$__instance == null ){
			self::$__instance = new self();
		}
		return self::$__instance;
	}
	
	// initialize singleton instance
	public static function run() {
		SyntaxHighlighter::getInstance();
	}
	
	public function __construct() {
		if (! is_admin() ) {
			remove_shortcode( 'code' );
			add_shortcode( 'code', array( $this, 'genericShortcodeHandler' ) );
		}
	}
	
	public function genericShortcodeHandler( $attributes = null, $content = '', $tagname='' ) {
		// map specified language code to one supported by Enlighter
		if ( isset( $attributes['lang'] ) ) {
			if ( isset( $this->_supportedLanguagesMap[$attributes['lang']] ) ) {
				$attributes['lang'] = $this->_supportedLanguagesMap[$attributes['lang']];
			}
		}
		
		// wrap the content with the Enlighter generic shortcode
		$enlighterAttributes = '';
		array_walk( $attributes, function( $value, $key ) use (&$enlighterAttributes) {
			$enlighterAttributes .= ' ' . $key . '="' . $value . '"';
		});
		$content = '[enlighter' . $enlighterAttributes . ']' . $content . '[/enlighter]';
		
		// apply Enlighter shortcode handler
		return do_shortcode( $content );
	}
}