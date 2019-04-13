<?php

namespace wpautoterms\api;

class License {
	const OPTION_KEY = 'license';
	const OPTION_INFO = 'license_info';

	const _RECHECK_TIME = WPAUTOTERMS_LICENSE_RECHECK_TIME;

	const STATUS_FREE = 'free';
	const STATUS_PAID = 'paid';

	const _EP_STATUS = 'license/v1/status/';

	const _RESP_STATUS = 'status';

	protected $_query;
	protected $_info;

	public function __construct( Query $query ) {
		$this->_query = $query;

		$this->_info = get_option( WPAUTOTERMS_OPTION_PREFIX . static::OPTION_INFO, array(
			'status' => static::STATUS_FREE,
			'timestamp' => 0,
			'error' => ''
		) );
		add_action( 'update_option_' . WPAUTOTERMS_OPTION_PREFIX . static::OPTION_KEY, array(
			$this,
			'on_update_key'
		), 10, 2 );
	}

	public function on_update_key( $old_value, $value ) {
		if ( $old_value == $value ) {
			return;
		}
		if ( empty( $value ) ) {
			$this->_set_status( static::STATUS_FREE );
			$this->_save_status();

			return;
		}
		$this->check( true );
	}

	protected function _set_status( $v ) {
		$this->_info['status'] = $v;
	}

	protected function _save_status() {
		$this->_info['timestamp'] = time();
		update_option( WPAUTOTERMS_OPTION_PREFIX . static::OPTION_INFO, $this->_info );
	}

	public function check( $force = false ) {
		$last_check = $this->timestamp();
		if ( ! $force && ( time() - $last_check ) < static::_RECHECK_TIME ) {
			return;
		}
		$key = $this->api_key();
		if ( empty( $key ) ) {
			return;
		}
		$headers = array( WPAUTOTERMS_API_KEY_HEADER => $key );
		$resp = $this->_query->get( static::_EP_STATUS, array(), $headers );
		$json = $resp->json();
		$this->_info['error'] = $resp->format_error( WP_DEBUG );
		if ( ! $resp->has_error() && isset( $json[ static::_RESP_STATUS ] ) &&
		     $json[ static::_RESP_STATUS ] === static::STATUS_PAID ) {
			$this->_set_status( static::STATUS_PAID );
		} else {
			$this->_set_status( static::STATUS_FREE );
			if ( empty( $this->_info['error'] ) && isset( $json['message'] ) ) {
				$this->_info['error'] = $json['message'];
			}
		}
		$this->_save_status();
	}

	public function api_key() {
		return get_option( WPAUTOTERMS_OPTION_PREFIX . static::OPTION_KEY, '' );
	}

	public function status() {
		return $this->_info['status'];
	}

	public function timestamp() {
		return $this->_info['timestamp'];
	}

	public function error_message() {
		return $this->_info['error'];
	}
}
