<?php
/**
 * Manage lite options.
 *
 * @package WordPress
 * @subpackage Shop Isle Lite
 */

/**
 * Big Title Section / Slider Switcher
 */
function shop_isle_big_title_to_slider() {

	return get_template_directory() . '/inc/sections/shop_isle_slider_section.php';

}
add_filter( 'shop-isle-subheader', 'shop_isle_big_title_to_slider', 100 );

/**
 * Hook the messages and upsells to Customizer.
 */
function shop_isle_messages_lite_customize_register( $wp_customize ) {
	/* Edit theme info section links */
	$upsell_section = $wp_customize->get_section( 'shopisle-upsell' );
	if ( ! empty( $upsell_section ) ) {
		$upsell_section->label_url = esc_url( 'http://docs.themeisle.com/article/184-shopisle-documentation' );
	}
}
add_action( 'customize_register', 'shop_isle_messages_lite_customize_register' );

/**
 * Replace the big title section with the slider
 *
 * @return string Path to slider section.
 */
function shop_isle_replace_bigtitle() {
	return 'inc/sections/shop_isle_slider_section';
}

add_filter( 'shop_isle_big_title_filter', 'shop_isle_replace_bigtitle' );
