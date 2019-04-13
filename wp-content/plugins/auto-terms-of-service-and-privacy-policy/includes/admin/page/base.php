<?php

namespace wpautoterms\admin\page;

use wpautoterms\cpt\CPT;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Base {
	private $_id;
	protected $_title;
	protected $_menu_title;
	protected $_options;

	public function __construct( $id, $title, $menu_title = null ) {
		$this->_id = $id;
		$this->_title = $title;
		if ( $menu_title === null ) {
			$menu_title = $title;
		}
		$this->_menu_title = $menu_title;
		$this->_init();
	}

	protected function _init() {
	}

	public function menu_title() {
		return $this->_menu_title;
	}

	public function register_menu() {
		add_submenu_page( 'edit.php?post_type=' . CPT::type(),
			$this->title(),
			$this->menu_title(),
			CPT::edit_cap(),
			$this->id(),
			array( $this, 'render' )
		);
	}

	public function enqueue_scripts() {
	}

	public function render() {
		\wpautoterms\print_template( 'pages/' . $this->_id, array(
			'page' => $this,
		) );
	}

	public function title() {
		return $this->_title;
	}

	public function id() {
		// TODO: move out prefixing
		return WPAUTOTERMS_SLUG . '_' . $this->_id;
	}
}
