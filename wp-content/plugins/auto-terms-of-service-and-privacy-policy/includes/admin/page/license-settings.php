<?php

namespace wpautoterms\admin\page;

use wpautoterms\admin\action\Recheck_License;
use wpautoterms\api\License;
use wpautoterms\option\License_Status_Option;
use wpautoterms\option\Text_Option;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class License_Settings extends Settings_Base {

	/**
	 * @var License
	 */
	protected $_license;

	public function set_license( License $license ) {
		$this->_license = $license;
	}

	public function define_options() {
		parent::define_options();
		new Text_Option( License::OPTION_KEY, __( 'License key', WPAUTOTERMS_SLUG ), '',
			$this->id(), static::SECTION_ID, Text_Option::TYPE_GENERIC, array(
				'class' => 'wpautoterms-license-key'
			) );
		$a = new License_Status_Option( 'license_status', __( 'License type', WPAUTOTERMS_SLUG ), '', $this->id(), static::SECTION_ID );
		$a->set_license( $this->_license );
	}

	public function defaults() {
		return array(
			License::OPTION_KEY => '',
		);
	}

	public function enqueue_scripts() {
		wp_enqueue_script( WPAUTOTERMS_SLUG . '_license_settings', WPAUTOTERMS_PLUGIN_URL . 'js/license-settings.js',
			false, false, true );
		wp_localize_script( WPAUTOTERMS_SLUG . '_license_settings', 'wpautotermsLicenseSettings', array(
			'nonce' => wp_create_nonce( Recheck_License::NAME ),
			'lastCheck' => $this->_license->timestamp(),
			'never' => _x( 'never', 'license_settings_page', WPAUTOTERMS_SLUG ),
			'keyId' => WPAUTOTERMS_OPTION_PREFIX . License::OPTION_KEY
		) );
	}
}
