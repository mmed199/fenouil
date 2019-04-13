<?php
/**
 * Front page Services Section
 *
 * @package WordPress
 * @subpackage Shop Isle
 */

$shop_isle_services_hide = get_theme_mod( 'shop_isle_services_hide', true );
$section_style           = '';
if ( ! empty( $shop_isle_services_hide ) && (bool) $shop_isle_services_hide === true ) {
	if ( is_customize_preview() ) {
		$section_style = 'style="display: none"';
	} else {
		return;
	}
}

$shop_isle_services_title     = get_theme_mod( 'shop_isle_services_title', esc_html__( 'Our Services', 'shop-isle' ) );
$shop_isle_services_title     = ! empty( $shop_isle_services_title ) ? $shop_isle_services_title : '';
$shop_isle_services_subtitle  = get_theme_mod( 'shop_isle_services_subtitle' );
$shop_isle_services_subtitle  = ! empty( $shop_isle_services_subtitle ) ? $shop_isle_services_subtitle : '';
$shop_isle_pro_services_boxes = get_theme_mod(
	'shop_isle_service_box',
	json_encode(
		array(
			array(
				'icon_value' => 'icon_gift',
				'text'       => esc_html__( 'Social icons', 'shop-isle' ),
				'subtext'    => esc_html__( 'Ideas and concepts', 'shop-isle' ),
				'link'       => esc_url( '#' ),
			),
			array(
				'icon_value' => 'icon_pin',
				'text'       => esc_html__( 'WooCommerce', 'shop-isle' ),
				'subtext'    => esc_html__( 'Top Rated Products', 'shop-isle' ),
				'link'       => esc_url( '#' ),
			),
			array(
				'icon_value' => 'icon_star',
				'text'       => esc_html__( 'Highly customizable', 'shop-isle' ),
				'subtext'    => esc_html__( 'Easy to use', 'shop-isle' ),
				'link'       => esc_url( '#' ),
			),
		)
	)
);

?>
<section class="module-small services" id="services" role="region" aria-label="<?php esc_html_e( 'Our Services', 'shop-isle' ); ?>" <?php echo $section_style; ?>>
	<?php shop_isle_display_customizer_shortcut( 'shop_isle_services_section' ); ?>
	<div class="section-overlay-layer">
		<div class="container">
			<?php
			echo '<div class="row">';
			echo '<div class="col-sm-6 col-sm-offset-3">';
			if ( ! empty( $shop_isle_services_title ) || is_customize_preview() ) {
				echo '<h2 class="module-title font-alt home-prod-title">' . $shop_isle_services_title . '</h2>';
			}

			if ( ! empty( $shop_isle_services_subtitle ) || is_customize_preview() ) {
				echo '<div class="module-subtitle font-serif home-prod-subtitle">' . $shop_isle_services_subtitle . '</div>';
			}

			echo '</div>';
			echo '</div><!-- .row -->';

			if ( ! empty( $shop_isle_pro_services_boxes ) ) {
				$shop_isle_pro_services_boxes_decoded = json_decode( $shop_isle_pro_services_boxes );
				if ( ! empty( $shop_isle_pro_services_boxes_decoded ) ) {
					echo '<div id="our_services_wrap" class="sip-services-wrap">';
					foreach ( $shop_isle_pro_services_boxes_decoded as $shop_isle_pro_service_box ) {

						$icon_value = ! empty( $shop_isle_pro_service_box->icon_value ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_pro_service_box->icon_value, 'Features section' ) : '';
						$title      = ! empty( $shop_isle_pro_service_box->title ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_pro_service_box->title, 'Features section' ) : '';
						$text       = ! empty( $shop_isle_pro_service_box->text ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_pro_service_box->text, 'Features section' ) : '';
						$link       = ! empty( $shop_isle_pro_service_box->link ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_pro_service_box->link, 'Features section' ) : '';
						$subtext    = ! empty( $shop_isle_pro_service_box->subtext ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_pro_service_box->subtext, 'Features section' ) : '';

						if ( ( ! empty( $icon_value ) && $icon_value != 'No Icon' ) || ! empty( $title ) || ! empty( $text ) ) {

							echo '<div class="col-xs-12 col-sm-4 sip-service-box"><div class="sip-single-service">';

							if ( ! empty( $link ) ) {
								echo '<a href="' . esc_url( $link ) . '" class="sip-single-service-a">';
							}

							if ( ! empty( $icon_value ) ) {
								echo '<span class="' . esc_attr( $icon_value ) . ' sip-single-icon"></span>';
							}

							if ( ! empty( $text ) || ! empty( $subtext ) ) {

								echo '<div class="sip-single-service-text">';

								if ( ! empty( $text ) ) {
									echo '<h3>' . wp_kses_post( $text ) . '</h3>';
								}

								if ( ! empty( $subtext ) ) {
									echo '<p>' . wp_kses_post( $subtext ) . '</p>';
								}

								echo '</div>';
							}

							if ( ! empty( $link ) ) {
								echo '</a>';
							}

							echo '</div></div>';
						}// End if().
					}// End foreach().
					echo '</div>';
				}// End if().
			}// End if().
			?>
		</div>
	</div>
</section>
