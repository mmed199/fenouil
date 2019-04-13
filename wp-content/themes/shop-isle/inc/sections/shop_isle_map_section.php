<?php
/**
 * Front page Map Section
 *
 * @package WordPress
 * @subpackage Shop Isle
 */

$shop_isle_map_hide = get_theme_mod( 'shop_isle_map_hide', true );
$section_style      = '';
if ( ! empty( $shop_isle_map_hide ) && (bool) $shop_isle_map_hide === true ) {
	if ( is_customize_preview() ) {
		$section_style = 'style="display: none"';
	} else {
		return;
	}
}

$shop_isle_map_shortcode = get_theme_mod( 'shop_isle_map_shortcode' );
if ( empty( $shop_isle_map_shortcode ) ) {
	return;
}


echo '<section id="map" ' . $section_style . '>';
shop_isle_display_customizer_shortcut( 'shop_isle_map_section' );
echo '<div id="container-fluid">';
echo '<div class="shop_isle_pro_map_overlay"></div>';
echo '<div id="cd-google-map">';
echo do_shortcode( $shop_isle_map_shortcode );
echo '</div>';
echo '</div>';
echo '</section>';



