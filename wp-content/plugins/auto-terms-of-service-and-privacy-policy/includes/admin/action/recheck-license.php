<?php

namespace wpautoterms\admin\action;


use wpautoterms\Action_Base;
use wpautoterms\api\License;

class Recheck_License extends Action_Base {
	const NAME = 'wpautoterms_recheck_license';

	/**
	 * @var License
	 */
	protected $_license_query;

	public function set_license_query( License $license_query ) {
		$this->_license_query = $license_query;
	}

	protected function _handle( $admin_post ) {
		if ( $admin_post ) {
			wp_die( 'Not supported.' );
		}
		// NOTE: check before update_option() call to avoid double recheck
		$this->_license_query->check( true );
		update_option( WPAUTOTERMS_OPTION_PREFIX . License::OPTION_KEY, $_REQUEST['apiKey'] );
		wp_send_json( array(
			'status' => $this->_license_query->status(),
			'timestamp' => $this->_license_query->timestamp(),
			'errorMessage' => $this->_license_query->error_message()
		) );
	}
}
