<?php

namespace wpautoterms\frontend\notice;

use wpautoterms\api\License;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cookies_Notice extends Base_Notice {
	const CLASS_COOKIES_NOTICE = 'wpautoterms-cookies-notice';
	const CLASS_CLOSE_BUTTON = 'wpautoterms-notice-close';
	/**
	 * @var License
	 */
	protected $_license;

	public static function create( $license ) {
		$a = new Cookies_Notice( 'cookies_notice', 'wpautoterms-cookies-notice-container', self::CLASS_COOKIES_NOTICE );
		$a->set_license( $license );

		return $a;
	}

	public function set_license( $license ) {
		$this->_license = $license;
	}

	protected function _is_enabled() {
		return $this->_license->status() != License::STATUS_FREE && parent::_is_enabled();
	}

	protected function print_box() {
		$cookie = 'wpautoterms-cookies-notice';
		if ( ! isset( $_COOKIE[ $cookie ] ) ) {
			\wpautoterms\print_template( 'cookies-notice', array(
				'cookie_name' => $cookie,
				'cookie_value' => 1,
				'message' => do_shortcode( $this->_message ),
				'close' => $this->_close_message,
			) );
		}
	}

	protected function get_data() {
		return true;
	}
}
