<?php
/**
 * Front page Short Codes Section
 *
 * @package WordPress
 * @subpackage Shop Isle
 */

$shop_isle_shortcodes_hide = get_theme_mod( 'shop_isle_shortcodes_hide', true );
$section_style             = '';
if ( ! empty( $shop_isle_shortcodes_hide ) && (bool) $shop_isle_shortcodes_hide === true ) {
	if ( is_customize_preview() ) {
		$section_style = 'style="display: none"';
	} else {
		return;
	}
}

$shop_isle_shortcodes_section         = get_theme_mod( 'shop_isle_shortcodes_settings' );
$shop_isle_shortcodes_section_decoded = json_decode( $shop_isle_shortcodes_section );
if ( ! empty( $shop_isle_shortcodes_section ) && ( ! empty( $shop_isle_shortcodes_section_decoded[0]->text ) || ! empty( $shop_isle_shortcodes_section_decoded[0]->subtitle ) || ! empty( $shop_isle_shortcodes_section_decoded[0]->shortcode ) ) ) {
	foreach ( $shop_isle_shortcodes_section_decoded as $section ) {

		$text      = ! empty( $section->text ) ? apply_filters( 'shop_isle_translate_single_string', $section->text, 'Shortcodes section' ) : '';
		$subtext   = ! empty( $section->subtext ) ? apply_filters( 'shop_isle_translate_single_string', $section->subtext, 'Shortcodes section' ) : '';
		$shortcode = ! empty( $section->shortcode ) ? apply_filters( 'shop_isle_translate_single_string', $section->shortcode, 'Shortcodes section' ) : '';

		$pos = strlen( strstr( $shortcode, 'pirate_forms' ) ); ?>
		<?php
		if ( function_exists( 'shop_isle_shortcode_top' ) ) {
			shop_isle_shortcode_top();
		}

		echo '<section class="shortcodes" id="';
		if ( $pos > 0 ) {
			echo 'contact';
		} else {
			if ( ! empty( $text ) ) {
				echo preg_replace( '/[^a-zA-Z0-9]/', '', strtolower( $text ) );
			}
		}
		echo '" role="region" aria-label="' . esc_html__( 'Shortcode', 'shop-isle' ) . '" ' . $section_style . '>';
		shop_isle_display_customizer_shortcut( 'shop_isle_shortcodes_section' );
		if ( function_exists( 'shop_isle_shortcode_before' ) ) {
			shop_isle_shortcode_before();
		}
		?>
		<div class="container">
			<div class="row">

				<div class="col-sm-6 col-sm-offset-3">
					<?php
					if ( ! empty( $text ) ) {
						echo '<h2 class="module-title font-alt home-prod-title">' . wp_kses_post( $text ) . '</h2>';
					}

					if ( ! empty( $subtext ) ) {
						echo '<div class="module-subtitle font-serif home-prod-subtitle">' . wp_kses_post( $subtext ) . '</div>';
					}
					?>
				</div>

			</div><!-- .row -->
			<div class="row">

				<?php
				if ( ! empty( $shortcode ) ) {
					$scd = html_entity_decode( $shortcode );
					echo do_shortcode( $scd );
				}
				?>

			</div>

		</div>
		<?php
		if ( function_exists( 'shop_isle_shortcode_after' ) ) {
			shop_isle_shortcode_after();
		}
		?>
		</section>
		<?php
		if ( function_exists( 'shop_isle_shortcode_bottom' ) ) {
			shop_isle_shortcode_bottom();
		}
		?>
		<?php
	}// End foreach().
}// End if().

?>
