<?php

namespace wpautoterms\admin;

class Notices {
	const CLASS_ERROR = 'error';
	const CLASS_UPDATED = 'updated';

	const TRANSIENT_EXPIRE = 90;

	protected static $_transient_name;
	protected static $_transient_expire;

	public static function init( $transient_name, $transient_expire = false ) {
		static::$_transient_name = $transient_name;
		if ( $transient_expire === false ) {
			static::$_transient_expire = static::TRANSIENT_EXPIRE;
		}
		add_action( 'admin_notices', array( __CLASS__, 'show' ) );
	}

	public static function add( $message, $class = false ) {
		if ( $class === false ) {
			$class = static::CLASS_UPDATED;
		}
		$notices = maybe_unserialize( get_transient( static::$_transient_name ) );
		if ( $notices === false ) {
			$notices = array();
		}
		if ( ! isset( $notices[ $class ] ) ) {
			$notices[ $class ] = array();
		}
		$notices[ $class ][] = $message;
		set_transient( static::$_transient_name, $notices, static::$_transient_expire );
	}

	public static function show() {
		$notices = maybe_unserialize( get_transient( static::$_transient_name ) );
		if ( is_array( $notices ) ) {
			foreach ( $notices as $class => $messages ) {
				foreach ( $messages as $message ) {
					// TODO: with template
					?>
                <div class="<?php echo esc_attr( $class ); ?>"><p><?php echo $message; ?></p></div><?php
				}
			}
		}
		delete_transient( static::$_transient_name );
	}
}
