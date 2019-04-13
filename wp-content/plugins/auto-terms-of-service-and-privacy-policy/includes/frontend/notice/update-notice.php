<?php

namespace wpautoterms\frontend\notice;

use wpautoterms\cpt\CPT;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Update_Notice extends Base_Notice {
	const BLOCK_CLASS = 'wpautoterms-update-notice';
	const CLOSE_CLASS = 'wpautoterms-notice-close';

	protected $_duration;
	protected $_posts;
	public $message_multiple;

	public static function create() {
		$a = new Update_Notice( 'update_notice', 'wpautoterms-update-notice-container', static::BLOCK_CLASS );
		$a->message_multiple = get_option( WPAUTOTERMS_OPTION_PREFIX . $a->id() . '_message_multiple' );

		return $a;
	}

	protected function get_posts() {
		$args = array(
			'post_type' => CPT::type(),
			'post_status' => 'publish',
			'orderby' => 'post_modified',
			'date_query' => array(
				'column' => 'post_modified',
				'after' => '-' . $this->_duration . ' days',
			),
		);

		$posts = get_posts( $args );
		$this->_posts = array();
		if ( count( $posts ) ) {
			foreach ( $posts as $post ) {
				if ( $post->post_modified == $post->post_date ) {
					continue;
				}
				$t = get_post_modified_time( get_option( 'date_format' ), false, $post, true );
				if ( ! isset( $this->_posts[ $t ] ) ) {
					$this->_posts[ $t ] = array();
				}
				$this->_posts[ $t ][] = $post;
			}
		}
	}

	protected function print_box() {
		if ( empty( $this->_posts ) ) {
			return;
		}
		global $wpautoterms_post;
		global $wpautoterms_posts;
		foreach ( $this->_posts as $date => $posts ) {
			if ( count( $posts ) > 1 ) {
				$wpautoterms_posts = array();
				$wpautoterms_post = $posts[0];
				$cookie = array();
				$values = array();
				foreach ( $posts as $post ) {
					$modified = strtotime( $post->post_modified );
					$tmp_cookie = 'wpautoterms-update-notice-' . $post->ID;
					if ( ! isset( $_COOKIE[ $tmp_cookie ] ) || ( $_COOKIE[ $tmp_cookie ] != $modified ) ) {
						$cookie[] = $tmp_cookie;
						$values[] = $modified;
						$wpautoterms_posts[] = $post;
					}
				}
				if ( ! empty( $wpautoterms_posts ) ) {
					\wpautoterms\print_template( 'update-notice', array(
						'cookie_name' => join( ',', $cookie ),
						'cookie_value' => join( ',', $values ),
						'message' => do_shortcode( $this->message_multiple ),
						'close' => $this->_close_message,
					) );
				}
			} else if ( count( $posts ) ) {
				$post = $posts[0];
				$modified = strtotime( $post->post_modified );
				$cookie = 'wpautoterms-update-notice-' . $post->ID;
				if ( ! isset( $_COOKIE[ $cookie ] ) || ( $_COOKIE[ $cookie ] != $modified ) ) {
					$wpautoterms_post = $post;
					\wpautoterms\print_template( 'update-notice', array(
						'cookie_name' => $cookie,
						'cookie_value' => $modified,
						'message' => do_shortcode( $this->_message ),
						'close' => $this->_close_message,
					) );
				}
			}
		}
	}

	protected function get_data() {
		$this->_duration = intval( get_option( WPAUTOTERMS_OPTION_PREFIX . 'update_notice_duration' ) );
		$this->get_posts();
		if ( empty( $this->_posts ) ) {
			return false;
		}

		return true;
	}
}
