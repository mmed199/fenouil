<?php

namespace wpautoterms\frontend\notice;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use wpautoterms\frontend\Styles;

abstract class Base_Notice {

	protected $_where;
	protected $_type;
	protected $_message;
	protected $_close_message;
	protected $_skip;
	protected $_id;
	protected $_tag;
	protected $_container;
	protected $_element;

	public function __construct( $id, $container_class, $element_class ) {
		$this->_id = $id;
		$this->_tag = str_replace( '_', '-', $this->_id );
		$this->_container = $container_class;
		$this->_element = $element_class;
		$this->_skip = false;
	}

	public function init() {
		if ( ! $this->_is_enabled() ) {
			return;
		}
		add_action( WPAUTOTERMS_SLUG . '_registered_cpt', array( $this, 'action_registered_cpt' ) );
		add_action( 'wp_print_styles', array( $this, 'print_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( WPAUTOTERMS_SLUG . '_container', array( $this, 'container' ), 10, 2 );

		$this->_type = get_option( WPAUTOTERMS_OPTION_PREFIX . $this->_id . '_bar_type' );
		$this->_where = get_option( WPAUTOTERMS_OPTION_PREFIX . $this->_id . '_bar_position' );
		$this->_message = get_option( WPAUTOTERMS_OPTION_PREFIX . $this->_id . '_message' );
		$this->_close_message = get_option( WPAUTOTERMS_OPTION_PREFIX . $this->_id . '_close_message',
			__( 'Close', WPAUTOTERMS_SLUG ) );
	}

	public function id() {
		return $this->_id;
	}

	protected function _is_enabled() {
		return get_option( WPAUTOTERMS_OPTION_PREFIX . $this->_id );
	}

	public function enqueue_scripts() {
		if ( $this->_skip ) {
			return;
		}
		wp_enqueue_script( WPAUTOTERMS_SLUG . '_js',
			WPAUTOTERMS_PLUGIN_URL . 'js/wpautoterms.js',
			false,
			false,
			true );
	}

	abstract protected function get_data();

	public function action_registered_cpt() {
		$disable_logged = get_option( WPAUTOTERMS_OPTION_PREFIX . $this->_id . '_disable_logged' );
		if ( ( ( $disable_logged == 'yes' ) && \is_user_logged_in() ) || ! $this->get_data() ) {
			$this->_skip = true;
		}
	}

	public function print_styles() {
		if ( $this->_skip ) {
			return;
		}
		Styles::print_styles( $this->_id, $this->_element );
	}

	public function container( $where, $type ) {
		if ( $this->_skip ) {
			return;
		}
		if ( ( $this->_where == $where ) && ( $this->_type == $type ) ) {
			$this->print_box();
		}
	}

	abstract protected function print_box();
}
