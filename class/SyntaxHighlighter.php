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
			add_shortcode('code', array( $this, 'genericShortcodeHandler' ) );
		}
	}
	
	private function genericShortcodeHandler( $atts ) {
		if ( isset( $atts['lang'] ) ) {
			if ( isset( $_supportedLanguagesMap[$atts['lang']] ) ) {
				$atts['lang'] = $_supportedLanguagesMap[$atts['lang']];
			}
		}
		getEnlighterShortcodeHandle()->genericShortcodeHandler( $atts );
	}
	
	private function getEnlighterShortcodeHandle() {
		if ( $_enlighterShortcodeHandle == null ){
			$enlighter_class = new ReflectionClass( 'Enlighter' );
			$enlighter = $enlighter_class->getMethod( 'getInstance' )->invoke();
			$_enlighterShortcodeHandle = $enlighter_class->getProperty( '_shortcodeHandler' )->getValue( $enlighter );
		}
		return $_enlighterShortcodeHandle;
	}
}