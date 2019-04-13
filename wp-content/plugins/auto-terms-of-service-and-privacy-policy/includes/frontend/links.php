<?php

namespace wpautoterms\frontend;

use wpautoterms\cpt\CPT;
use wpautoterms\gen_css\Attr;
use wpautoterms\gen_css\Document;
use wpautoterms\gen_css\Record;

class Links {
	const MODULE_ID = 'links';
	const FOOTER_CLASS = 'wpautoterms-footer';
	const SEPARATOR_CLASS = 'separator';

	public function __construct() {
		add_action( 'wp_print_styles', array( $this, 'print_styles' ) );
	}

	protected static function _option_prefix() {
		return WPAUTOTERMS_OPTION_PREFIX . static::MODULE_ID;
	}

	public function links_box() {
		if ( ! get_option( WPAUTOTERMS_OPTION_PREFIX . static::MODULE_ID ) ) {
			return;
		}
		$args = array(
			'post_type' => CPT::type(),
			'post_status' => 'publish',
			'orderby' => 'post_modified',
			'numberposts' => - 1
		);

		$posts = get_posts( $args );
		$new_page = $custom = get_option( static::_option_prefix() . '_target_blank' );
		\wpautoterms\print_template( static::MODULE_ID, compact( 'posts', 'new_page' ) );
	}

	public function print_styles() {
		$option_prefix = static::_option_prefix();
		if ( ! get_option( $option_prefix ) ) {
			return;
		}

		$d = new Document( array(
			new Record( '.' . static::FOOTER_CLASS, array(
				new Attr( $option_prefix, Attr::TYPE_BG_COLOR ),
				new Attr( $option_prefix, Attr::TYPE_TEXT_ALIGN ),
			) ),
			new Record( '.' . static::FOOTER_CLASS . ' a', array(
				new Attr( $option_prefix, Attr::TYPE_LINKS_COLOR ),
				new Attr( $option_prefix, Attr::TYPE_FONT ),
				new Attr( $option_prefix, Attr::TYPE_FONT_SIZE ),
			) ),
			new Record( '.' . static::FOOTER_CLASS . ' .' . static::SEPARATOR_CLASS, array(
				new Attr( $option_prefix, Attr::TYPE_TEXT_COLOR ),
				new Attr( $option_prefix, Attr::TYPE_FONT ),
				new Attr( $option_prefix, Attr::TYPE_FONT_SIZE ),
			) ),
		) );
		$text = $d->text();
		$custom = get_option( $option_prefix . '_custom_css' );
		if ( ! empty( $custom ) ) {
			$text .= "\n" . strip_tags( $custom );
		}
		echo Document::style( $text ) . "\n";
	}

}