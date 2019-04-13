<?php
/**
 * Front page Product Categories Section
 *
 * @package WordPress
 * @subpackage Shop Isle
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$shop_isle_fp_categories_hide = get_theme_mod( 'shop_isle_fp_categories_hide', true );
$section_style                = '';
if ( ! empty( $shop_isle_fp_categories_hide ) && (bool) $shop_isle_fp_categories_hide === true ) {
	if ( is_customize_preview() ) {
		$section_style = 'style="display: none"';
	} else {
		return;
	}
}

$shop_isle_fp_categories_title = get_theme_mod( 'shop_isle_fp_categories_title', esc_html__( 'Popular categories', 'shop-isle' ) );
$shop_isle_fp_categories_title = ! empty( $shop_isle_fp_categories_title ) ? $shop_isle_fp_categories_title : '';

$shop_isle_fp_categories_subtitle = get_theme_mod( 'shop_isle_fp_categories_subtitle' );
$shop_isle_fp_categories_subtitle = ! empty( $shop_isle_fp_categories_subtitle ) ? $shop_isle_fp_categories_subtitle : '';

$shop_isle_fp_categories_list = get_theme_mod( 'shop_isle_fp_categories_list' );


echo '<section class="categories" id="categories" ' . $section_style . '>';
shop_isle_display_customizer_shortcut( 'shop_isle_fp_categories_section' );
echo '<div class="section-overlay-layer">';
echo '<div class="container">';

echo '<div class="row section-header">';
echo '<div class="col-sm-6 col-sm-offset-3">';

/* title */
if ( ! empty( $shop_isle_fp_categories_title ) || is_customize_preview() ) {
	echo '<h2 class="module-title font-alt home-prod-title">' . $shop_isle_fp_categories_title . '</h2>';
}

/* subtitle */
if ( ! empty( $shop_isle_fp_categories_subtitle ) || is_customize_preview() ) {
	echo '<div class="module-subtitle font-serif home-prod-subtitle">' . $shop_isle_fp_categories_subtitle . '</div>';
}

echo '</div><!-- .col-sm-6 col-sm-offset-3 -->';
echo '</div><!-- .row -->';

if ( ! empty( $shop_isle_fp_categories_list ) ) {

	echo '</div><!-- .container -->';
	echo '<div id="popular_categories_wrap" class="popular-categories-wrap">';
	foreach ( $shop_isle_fp_categories_list as $shop_isle_fp_category ) {

		$thumbnail_id = get_term_meta( $shop_isle_fp_category, 'thumbnail_id', true );


		if ( ! empty( $thumbnail_id ) ) {

			$categ_name = '';

			$categ_name = get_term_by( 'id', intval( $shop_isle_fp_category ), 'product_cat' );

			$categ_image = wp_get_attachment_image(
				$thumbnail_id,
				'shop_isle_category_thumbnail',
				array(
					'alt' => $categ_name,
				)
			);


			if ( ! empty( $categ_image ) ) {

				$categ_link = get_term_link( (int) $shop_isle_fp_category );

				echo '<div class="col-xs-12 col-sm-6 col-lg-3 popular-category">';

				echo '<div class="category-image-wrap">';


				echo '<a href="' . esc_url( $categ_link ) . '">';

				echo '<div class="popular-category-image">';

				echo $categ_image;

				if ( ! empty( $categ_name->name ) ) {
					echo '<div class="popular-category-caption">';
					echo '<h3 class="popular-category-title">' . $categ_name->name . '</h3>';
					echo '</div>';
				}

				echo '</div><!-- .popular-category-image -->';

				echo '</a>';

				echo '</div><!-- .category-image-wrap -->';

				echo '</div><!-- .popular-category -->';

			}
		}// End if().
	}// End foreach().
	echo '</div><!-- .popular-categories-wrap -->';
	echo '<div class="container">';
}// End if().

?>
</div><!-- .container -->
</div><!-- .section-overlay-layer -->
</section>
