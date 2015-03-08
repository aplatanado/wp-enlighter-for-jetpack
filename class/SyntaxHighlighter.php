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
	
	// enlighter shortcode handler instance
	private $_enlighterShortcodeHandler;

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
			add_shortcode( 'acode', array( $this, 'genericShortcodeHandler' ) );
		}
	}
	
	public function genericShortcodeHandler( $attributes, $content = '', $tagname='' ) {
		if ( isset( $attributes['lang'] ) ) {
			if ( isset( $this->_supportedLanguagesMap[$attributes['lang']] ) ) {
				$attributes['lang'] = $this->_supportedLanguagesMap[$atts['lang']];
			}
		}
		$this->getEnlighterShortcodeHandler()->genericShortcodeHandler( $attributes, $content );
	}
	
	private function getEnlighterShortcodeHandler() {
		if ( $this->_enlighterShortcodeHandler == null ){
			$enlighter_class = new ReflectionClass( 'Enlighter' );
			$enlighter = $enlighter_class->getMethod( 'getInstance' )->invoke( null );
			$_shortcodeHandler_property = $enlighter_class->getProperty( '_shortcodeHandler' );
			$_shortcodeHandler_property->setAccessible( true );
			$this->_enlighterShortcodeHandler = $_shortcodeHandler_property->getValue( $enlighter );
		}
		return $this->_enlighterShortcodeHandler;
	}
}