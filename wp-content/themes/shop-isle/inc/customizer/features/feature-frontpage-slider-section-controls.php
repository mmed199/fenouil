<?php
/**
 * Customizer functionality for the Slider Section.
 *
 * @package WordPress
 * @subpackage Shop Isle
 */

/* Remove the big title section from the wp.org version */
remove_action( 'customize_register', 'shop_isle_big_title_controls_customize_register', 10 );

/**
 * Hook controls for Slider Section to Customizer.
 */
function shop_isle_slider_controls_customize_register( $wp_customize ) {

	/* Slider section */

	$wp_customize->add_section(
		'shop_isle_slider_section',
		array(
			'title'    => __( 'Slider section', 'shop-isle' ),
			'priority' => 10,
		)
	);

	/* Hide slider */
	$wp_customize->add_setting(
		'shop_isle_slider_hide',
		array(
			'default'           => false,
			'sanitize_callback' => 'shop_isle_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'shop_isle_slider_hide',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Hide slider section?', 'shop-isle' ),
			'section'  => 'shop_isle_slider_section',
			'priority' => 1,
		)
	);

	/* Slider */
	$wp_customize->add_setting(
		'shop_isle_slider',
		array(
			'sanitize_callback' => 'shop_isle_sanitize_repeater',
			'default'           => json_encode(
				array(
					array(
						'image_url' => get_template_directory_uri() . '/assets/images/slide1.jpg',
						'link'      => '#',
						'text'      => __( 'Shop Isle', 'shop-isle' ),
						'subtext'   => __( 'WooCommerce Theme', 'shop-isle' ),
						'label'     => __( 'Read more', 'shop-isle' ),
					),
					array(
						'image_url' => get_template_directory_uri() . '/assets/images/slide2.jpg',
						'link'      => '#',
						'text'      => __( 'Shop Isle', 'shop-isle' ),
						'subtext'   => __( 'WooCommerce Theme', 'shop-isle' ),
						'label'     => __( 'Read more', 'shop-isle' ),
					),
					array(
						'image_url' => get_template_directory_uri() . '/assets/images/slide3.jpg',
						'link'      => '#',
						'text'      => __( 'Shop Isle', 'shop-isle' ),
						'subtext'   => __( 'WooCommerce Theme', 'shop-isle' ),
						'label'     => __( 'Read more', 'shop-isle' ),
					),
				)
			),
		)
	);

	$wp_customize->add_control(
		new Shop_Isle_Repeater_Controler(
			$wp_customize,
			'shop_isle_slider',
			array(
				'label'                     => __( 'Add new slide', 'shop-isle' ),
				'section'                   => 'shop_isle_slider_section',
				'active_callback'           => 'is_front_page',
				'priority'                  => 2,
				'shop_isle_image_control'   => true,
				'shop_isle_text_control'    => true,
				'shop_isle_link_control'    => true,
				'shop_isle_subtext_control' => true,
				'shop_isle_label_control'   => true,
				'shop_isle_icon_control'    => false,
				'shop_isle_box_label'       => __( 'Slide', 'shop-isle' ),
				'shop_isle_box_add_label'   => __( 'Add new slide', 'shop-isle' ),
			)
		)
	);

	$wp_customize->get_section( 'shop_isle_slider_section' )->panel = 'shop_isle_front_page_sections';

}
add_action( 'customize_register', 'shop_isle_slider_controls_customize_register' );
