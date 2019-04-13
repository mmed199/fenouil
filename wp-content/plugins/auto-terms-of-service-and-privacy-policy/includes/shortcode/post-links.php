<?php

namespace wpautoterms\shortcode;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Post_Links extends Sub_Shortcode {

	public function handle( $values, $content ) {
		global $wpautoterms_posts;
		if ( empty( $wpautoterms_posts ) ) {
			return '';
		}

		$links = array();
		foreach ( $wpautoterms_posts as $post ) {
			$links[] = '<a href="' . esc_url( get_post_permalink( $post->ID ) ) . '">' .
			           esc_html( $post->post_title ) . '</a>';
		}

		return join( ', ', $links );
	}

}
