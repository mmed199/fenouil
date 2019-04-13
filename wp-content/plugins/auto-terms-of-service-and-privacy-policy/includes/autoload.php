<?php

namespace wpautoterms;

spl_autoload_register( function ( $class ) {
	if ( substr_compare( $class, __NAMESPACE__ . '\\', 0, strlen( __NAMESPACE__ ) + 1 ) === 0 ) {
		$class = substr( $class, strlen( __NAMESPACE__ ) + 1 );
		$class = explode( '\\', str_replace( '_', '-', $class ) );
		$path = __DIR__;
		$c = count( $class );
		if ( $c > 1 ) {
			$path .= DIRECTORY_SEPARATOR . str_replace( '_', '-', join( DIRECTORY_SEPARATOR, array_slice( $class, 0, - 1 ) ) );
		}
		$class_name = str_replace( '_', '-', strtolower( $class[ $c - 1 ] ) );
		$path .= DIRECTORY_SEPARATOR . $class_name . '.php';
		$path = realpath( $path );
		if ( $path !== false ) {
			include_once $path;
		}
	}
} );
