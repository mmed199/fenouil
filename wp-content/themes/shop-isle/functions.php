<?php
/**
 * Main functions file
 *
 * @package WordPress
 * @subpackage Shop Isle
 */
 
function xa_filter_woocommerce_states( $states ) { 
    unset( $states['FR'] );

    $departements = 
    json_decode(
    file_get_contents(get_theme_file_path('departments.json')),
    true);
    $departementsformatted = array();

    
    foreach($departements  as $key => $value) {
        $departementsformatted[$value['slug']] = $value['name'];
    }
    $states['FR'] = $departementsformatted;
    return $states;
};
add_filter( 'woocommerce_states', 'xa_filter_woocommerce_states', 10, 1 );

function xa_filter_woocommerce_get_country_locale( $locale ) { 
    $locale['FR']['state']['required'] = true;
    return $locale; 
};
add_filter( 'woocommerce_get_country_locale', 'xa_filter_woocommerce_get_country_locale', 10, 1 );
 
 

$vendor_file = trailingslashit( get_template_directory() ) . 'vendor/autoload.php';
if ( is_readable( $vendor_file ) ) {
	require_once $vendor_file;
}

if ( ! defined( 'WPFORMS_SHAREASALE_ID' ) ) {
	define( 'WPFORMS_SHAREASALE_ID', '848264' );
}

add_filter( 'themeisle_sdk_products', 'shopisle_load_sdk' );
/**
 * Loads products array.
 *
 * @param array $products All products.
 *
 * @return array Products array.
 */

/**
 * Initialize all the things.
 */
require get_template_directory() . '/inc/init.php';

/**
 * Note: Do not add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */
 
