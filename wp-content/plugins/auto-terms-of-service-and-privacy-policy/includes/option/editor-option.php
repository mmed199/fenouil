<?php

namespace wpautoterms\option;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Editor_Option extends Option {

	protected $_settings;

	public function set_settings($settings){
		$this->_settings = $settings;
	}

	function sanitize( $input ) {
		return trim( strval( $input ) );
	}

	function render() {
		if ( isset( $this->_settings['filters'] ) ) {
			foreach ( $this->_settings['filters'] as $k => $v ) {
				add_filter( $k, $v );
			}
		}
		do_action( "wpautoterms_pre_editor", $this );
		wp_editor( $this->get_value(), $this->_name, $this->_settings );
		do_action( "wpautoterms_post_editor", $this );
		if ( isset( $this->_settings['filters'] ) ) {
			foreach ( $this->_settings['filters'] as $k => $v ) {
				remove_filter( $k, $v );
			}
		}
	}
}
