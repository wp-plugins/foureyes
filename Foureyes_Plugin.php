<?php
defined( 'ABSPATH' ) or die();

class FourEyes_Plugin {

	const SHORTCODE_SLUG = 'foureyes';
	const DEFAULT_EMBED_VERSION = '0';
	const FOUREYES_SURVEY_URL_PATTERN = '#http(s?)://(www\.)?(getfoureyes\.com|4eyes\.io)/s/([0-9a-zA-Z\-]*)\/?#i';

	/**
	 * @var FourEyes_Plugin
	 */
	static protected $instance;

	/**
	 * @return FourEyes_Plugin
	 */
	static public function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add hook for shortcode
	 */
	protected function __construct() {
		
		add_shortcode( self::SHORTCODE_SLUG, array( $this, 'foureyes_shortcode_handler' ) );
		
		// Enable shortcode support for sidebar widget
		add_filter('widget_text', 'do_shortcode');
	}

	/**
	 * Construct a survey embed from the attributes
	 *
	 * @param $attrs
	 * @return string
	 */
	function foureyes_shortcode_handler( $attrs ) {
		if( !array_key_exists('survey', $attrs) )
			return '';
		
		$html  = '<script src="https://getfoureyes.com/js/embed.js">{"url":"https://getfoureyes.com/s/"}</script>';
		$html .= '<div class="foureyes-embed"';
		foreach( $attrs as $key => $value ) {
			$_key = esc_attr($key);
			$_value = esc_attr($value);
			$html .= " data-$_key=\"$_value\"";
		}
		$html .= '></div>';
		
		return $html;
	}
}