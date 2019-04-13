<?php
/**
 * Customizer functionality for the About Us Page controls.
 *
 * @package WordPress
 * @subpackage Shop Isle
 */

/**
 * Hook controls for the About Us Page to Customizer.
 */
function shop_isle_about_us_page_customize_register( $wp_customize ) {

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	require_once( trailingslashit( get_template_directory() ) . 'inc/customizer/class/class-shopisle-aboutus-page-instructions.php' );

	/*  About us page  */

	if ( class_exists( 'WP_Customize_Panel' ) ) :

		$wp_customize->add_panel(
			'panel_team',
			array(
				'priority'       => 98,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'About us page', 'shop-isle' ),
			)
		);

		$wp_customize->add_section(
			'shop_isle_about_page_section',
			array(
				'title'    => __( 'Our team', 'shop-isle' ),
				'priority' => 1,
				'panel'    => 'panel_team',
			)
		);

	else :

		$wp_customize->add_section(
			'shop_isle_about_page_section',
			array(
				'title'    => __( 'About us page - our team', 'shop-isle' ),
				'priority' => 98,
			)
		);

	endif;

	/* Our team title */
	$wp_customize->add_setting(
		'shop_isle_our_team_title',
		array(
			'sanitize_callback' => 'shop_isle_sanitize_text',
			'default'           => __( 'Meet our team', 'shop-isle' ),
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'shop_isle_our_team_title',
		array(
			'label'           => __( 'Title', 'shop-isle' ),
			'section'         => 'shop_isle_about_page_section',
			'active_callback' => 'shop_isle_is_aboutus_page',
			'priority'        => 1,
		)
	);

	/* Our team subtitle */
	$wp_customize->add_setting(
		'shop_isle_our_team_subtitle',
		array(
			'sanitize_callback' => 'shop_isle_sanitize_text',
			'default'           => __( 'An awesome way to introduce the members of your team.', 'shop-isle' ),
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'shop_isle_our_team_subtitle',
		array(
			'label'           => __( 'Subtitle', 'shop-isle' ),
			'section'         => 'shop_isle_about_page_section',
			'active_callback' => 'shop_isle_is_aboutus_page',
			'priority'        => 2,
		)
	);

	/* Team members */
	$wp_customize->add_setting(
		'shop_isle_team_members',
		array(
			'transport'         => $selective_refresh,
			'sanitize_callback' => 'shop_isle_sanitize_repeater',
			'default'           => json_encode(
				array(
					array(
						'image_url'   => get_template_directory_uri() . '/assets/images/team1.jpg',
						'text'        => 'Eva Bean',
						'subtext'     => 'Developer',
						'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
					),
					array(
						'image_url'   => get_template_directory_uri() . '/assets/images/team2.jpg',
						'text'        => 'Maria Woods',
						'subtext'     => 'Designer',
						'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
					),
					array(
						'image_url'   => get_template_directory_uri() . '/assets/images/team3.jpg',
						'text'        => 'Booby Stone',
						'subtext'     => 'Director',
						'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
					),
					array(
						'image_url'   => get_template_directory_uri() . '/assets/images/team4.jpg',
						'text'        => 'Anna Neaga',
						'subtext'     => 'Art Director',
						'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
					),
				)
			),
		)
	);
	$wp_customize->add_control(
		new Shop_Isle_Repeater_Controler(
			$wp_customize,
			'shop_isle_team_members',
			array(
				'label'                         => __( 'Add new team member', 'shop-isle' ),
				'section'                       => 'shop_isle_about_page_section',
				'active_callback'               => 'shop_isle_is_aboutus_page',
				'priority'                      => 3,
				'shop_isle_image_control'       => true,
				'shop_isle_link_control'        => false,
				'shop_isle_text_control'        => true,
				'shop_isle_subtext_control'     => true,
				'shop_isle_label_control'       => false,
				'shop_isle_icon_control'        => false,
				'shop_isle_description_control' => true,
				'shop_isle_box_label'           => __( 'Team member', 'shop-isle' ),
				'shop_isle_box_add_label'       => __( 'Add new team member', 'shop-isle' ),
			)
		)
	);

	/* About us page - instructions for users when not on About us page */

	$wp_customize->add_section(
		'shop_isle_aboutus_page_instructions',
		array(
			'title'    => __( 'About us page', 'shop-isle' ),
			'priority' => 98,
		)
	);

	$wp_customize->add_setting(
		'shop_isle_aboutus_page_instructions',
		array(
			'sanitize_callback' => 'shop_isle_sanitize_text',
		)
	);

	$wp_customize->add_control(
		new ShopIsle_Aboutus_Page_Instructions(
			$wp_customize,
			'shop_isle_aboutus_page_instructions',
			array(
				'section'         => 'shop_isle_aboutus_page_instructions',
				'active_callback' => 'shop_isle_is_not_aboutus_page',
			)
		)
	);

	if ( class_exists( 'WP_Customize_Panel' ) ) :

		$wp_customize->add_section(
			'shop_isle_about_page_video_section',
			array(
				'title'    => __( 'Video', 'shop-isle' ),
				'priority' => 2,
				'panel'    => 'panel_team',
			)
		);

	else :

		$wp_customize->add_section(
			'shop_isle_about_page_video_section',
			array(
				'title'    => __( 'About us page - video', 'shop-isle' ),
				'priority' => 53,
			)
		);

	endif;

	/* Video title */
	$wp_customize->add_setting(
		'shop_isle_about_page_video_title',
		array(
			'sanitize_callback' => 'shop_isle_sanitize_text',
			'default'           => __( 'Presentation', 'shop-isle' ),
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'shop_isle_about_page_video_title',
		array(
			'label'           => __( 'Title', 'shop-isle' ),
			'section'         => 'shop_isle_about_page_video_section',
			'active_callback' => 'shop_isle_is_aboutus_page',
			'priority'        => 1,
		)
	);

	/* Video subtitle */
	$wp_customize->add_setting(
		'shop_isle_about_page_video_subtitle',
		array(
			'sanitize_callback' => 'shop_isle_sanitize_text',
			'default'           => __( 'What the video about our new products', 'shop-isle' ),
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'shop_isle_about_page_video_subtitle',
		array(
			'label'           => __( 'Subtitle', 'shop-isle' ),
			'section'         => 'shop_isle_about_page_video_section',
			'active_callback' => 'shop_isle_is_aboutus_page',
			'priority'        => 2,
		)
	);

	/* Video background */
	$wp_customize->add_setting(
		'shop_isle_about_page_video_background',
		array(
			'default'           => get_template_directory_uri() . '/assets/images/background-video.jpg',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'shop_isle_about_page_video_background',
			array(
				'label'           => __( 'Background', 'shop-isle' ),
				'section'         => 'shop_isle_about_page_video_section',
				'active_callback' => 'shop_isle_is_aboutus_page',
				'priority'        => 3,
			)
		)
	);

	/* Video link */
	$wp_customize->add_setting(
		'shop_isle_about_page_video_link',
		array(
			'sanitize_callback' => 'shop_isle_sanitize_text',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'shop_isle_about_page_video_link',
		array(
			'label'           => __( 'Video', 'shop-isle' ),
			'section'         => 'shop_isle_about_page_video_section',
			'active_callback' => 'shop_isle_is_aboutus_page',
			'priority'        => 4,
		)
	);

	if ( class_exists( 'WP_Customize_Panel' ) ) :

		$wp_customize->add_section(
			'shop_isle_about_page_advantages_section',
			array(
				'title'    => __( 'Our advantages', 'shop-isle' ),
				'priority' => 3,
				'panel'    => 'panel_team',
			)
		);

	else :

		$wp_customize->add_section(
			'shop_isle_about_page_advantages_section',
			array(
				'title'    => __( 'About us page - our advantages', 'shop-isle' ),
				'priority' => 54,
			)
		);

	endif;

	/* Our advantages title */
	$wp_customize->add_setting(
		'shop_isle_our_advantages_title',
		array(
			'sanitize_callback' => 'shop_isle_sanitize_text',
			'default'           => __( 'Our advantages', 'shop-isle' ),
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'shop_isle_our_advantages_title',
		array(
			'label'           => __( 'Title', 'shop-isle' ),
			'section'         => 'shop_isle_about_page_advantages_section',
			'active_callback' => 'shop_isle_is_aboutus_page',
			'priority'        => 1,
		)
	);

	/* Advantages */
	$wp_customize->add_setting(
		'shop_isle_advantages',
		array(
			'transport'         => $selective_refresh,
			'sanitize_callback' => 'shop_isle_sanitize_repeater',
			'default'           => json_encode(
				array(
					array(
						'icon_value' => 'icon_lightbulb',
						'text'       => __( 'Ideas and concepts', 'shop-isle' ),
						'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
					),
					array(
						'icon_value' => 'icon_tools',
						'text'       => __( 'Designs & interfaces', 'shop-isle' ),
						'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
					),
					array(
						'icon_value' => 'icon_cogs',
						'text'       => __( 'Highly customizable', 'shop-isle' ),
						'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
					),
					array(
						'icon_value' => 'icon_like',
						'text'       => __( 'Easy to use', 'shop-isle' ),
						'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
					),
				)
			),
		)
	);

	$wp_customize->add_control(
		new Shop_Isle_Repeater_Controler(
			$wp_customize,
			'shop_isle_advantages',
			array(
				'label'                         => __( 'Add new advantage', 'shop-isle' ),
				'section'                       => 'shop_isle_about_page_advantages_section',
				'active_callback'               => 'shop_isle_is_aboutus_page',
				'priority'                      => 2,
				'shop_isle_image_control'       => false,
				'shop_isle_link_control'        => false,
				'shop_isle_text_control'        => true,
				'shop_isle_subtext_control'     => true,
				'shop_isle_label_control'       => false,
				'shop_isle_icon_control'        => true,
				'shop_isle_description_control' => false,
				'shop_isle_box_label'           => __( 'Advantage', 'shop-isle' ),
				'shop_isle_box_add_label'       => __( 'Add new advantage', 'shop-isle' ),
			)
		)
	);
}

add_action( 'customize_register', 'shop_isle_about_us_page_customize_register' );

/**
 * Check if is about us page.
 *
 * @return bool
 */
function shop_isle_is_aboutus_page() {
	return is_page_template( 'template-about.php' );
};

/**
 * Check if is not about us page.
 *
 * @return bool
 */
function shop_isle_is_not_aboutus_page() {
	return ! is_page_template( 'template-about.php' );
};

if ( ! function_exists( 'shop_isle_about_page_register_partials' ) ) :
	/**
	 * Add selective refresh for About page section controls
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function shop_isle_about_page_register_partials( $wp_customize ) {
		// Abort if selective refresh is not available.
		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		/* Our team */
		$wp_customize->selective_refresh->add_partial(
			'shop_isle_our_team_title',
			array(
				'selector'            => '.page-template-template-about .meet-out-team-title',
				'render_callback'     => 'shop_isle_about_page_team_title_callback',
				'container_inclusive' => false,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'shop_isle_our_team_subtitle',
			array(
				'selector'            => '.page-template-template-about .meet-out-team-subtitle',
				'render_callback'     => 'shop_isle_about_page_team_subtitle_callback',
				'container_inclusive' => false,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'shop_isle_team_members',
			array(
				'selector'            => '.page-template-template-about .about-team-member',
				'render_callback'     => 'shop_isle_about_page_display_team_members',
				'container_inclusive' => true,
			)
		);

		/* Video */
		$wp_customize->selective_refresh->add_partial(
			'shop_isle_about_page_video_title',
			array(
				'selector'            => '.page-template-template-about .video-box .video-title',
				'render_callback'     => 'shop_isle_about_page_video_title_callback',
				'container_inclusive' => false,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'shop_isle_about_page_video_subtitle',
			array(
				'selector'            => '.page-template-template-about .video-box .video-subtitle',
				'render_callback'     => 'shop_isle_about_page_video_subtitle_callback',
				'container_inclusive' => false,
			)
		);

		/* Our advantages */
		$wp_customize->selective_refresh->add_partial(
			'shop_isle_our_advantages_title',
			array(
				'selector'            => '.page-template-template-about .module-title.our_advantages',
				'render_callback'     => 'shop_isle_about_page_advantages_title_callback',
				'container_inclusive' => false,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'shop_isle_advantages',
			array(
				'selector'            => '.page-template-template-about .module-advantages .multi-columns-row',
				'render_callback'     => 'shop_isle_about_page_display_advantages',
				'container_inclusive' => true,
			)
		);
	}
endif;

add_action( 'customize_register', 'shop_isle_about_page_register_partials' );

if ( ! function_exists( 'shop_isle_about_page_team_title_callback' ) ) :
	/**
	 * Callback function for the about page, team section title
	 *
	 * @return string - team title value
	 */
	function shop_isle_about_page_team_title_callback() {
		return get_theme_mod( 'shop_isle_our_team_title' );
	}
endif;

if ( ! function_exists( 'shop_isle_about_page_team_subtitle_callback' ) ) :
	/**
	 * Callback function for the about page, team section subtitle
	 *
	 * @return string - team subtitle value
	 */
	function shop_isle_about_page_team_subtitle_callback() {
		return get_theme_mod( 'shop_isle_our_team_subtitle' );
	}
endif;

if ( ! function_exists( 'shop_isle_about_page_display_team_members' ) ) :
	/**
	 * Callback function for team members on about page
	 */
	function shop_isle_about_page_display_team_members() {

		$shop_isle_team_members = get_theme_mod(
			'shop_isle_team_members',
			json_encode(
				array(
					array(
						'image_url'   => get_template_directory_uri() . '/assets/images/team1.jpg',
						'text'        => 'Eva Bean',
						'subtext'     => 'Developer',
						'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
					),
					array(
						'image_url'   => get_template_directory_uri() . '/assets/images/team2.jpg',
						'text'        => 'Maria Woods',
						'subtext'     => 'Designer',
						'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
					),
					array(
						'image_url'   => get_template_directory_uri() . '/assets/images/team3.jpg',
						'text'        => 'Booby Stone',
						'subtext'     => 'Director',
						'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
					),
					array(
						'image_url'   => get_template_directory_uri() . '/assets/images/team4.jpg',
						'text'        => 'Anna Neaga',
						'subtext'     => 'Art Director',
						'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
					),
				)
			)
		);

		if ( ! empty( $shop_isle_team_members ) ) {
			$shop_isle_team_members_decoded = json_decode( $shop_isle_team_members );
			if ( ! empty( $shop_isle_team_members_decoded ) ) {

				echo '<div class="hero-slider about-team-member">';
				echo '<ul class="slides">';
				foreach ( $shop_isle_team_members_decoded as $shop_isle_team_member ) {
					$image_url   = ! empty( $shop_isle_team_member->image_url ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_team_member->image_url, 'Team section' ) : '';
					$text        = ! empty( $shop_isle_team_member->text ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_team_member->text, 'Team section' ) : '';
					$description = ! empty( $shop_isle_team_member->description ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_team_member->description, 'Team section' ) : '';
					$subtext     = ! empty( $shop_isle_team_member->subtext ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_team_member->subtext, 'Team section' ) : '';

					echo '<div class="col-sm-6 col-md-3 mb-sm-20 fadeInUp">';
					echo '<div class="team-item">';

					echo '<div class="team-image">';
					if ( ! empty( $image_url ) ) {
						if ( ! empty( $text ) ) {
							echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_html( $text ) . '">';
						} else {
							echo '<img src="' . esc_url( $image_url ) . '" alt="">';
						}
					}
					if ( ! empty( $description ) ) {
						echo '<div class="team-detail">';
						echo '<p class="font-serif">' . wp_kses_post( $description ) . '</p>';
						echo '</div><!-- .team-detail -->';
					}
					echo '</div><!-- .team-image -->';

					echo '<div class="team-descr font-alt">';
					if ( ! empty( $text ) ) {
						echo '<div class="team-name">' . wp_kses_post( $text ) . '</div>';
					}
					if ( ! empty( $subtext ) ) {
						echo '<div class="team-role">' . wp_kses_post( $subtext ) . '</div>';
					}
					echo '</div><!-- .team-descr -->';

					echo '</div><!-- .team-item -->';
					echo '</div><!-- .col-sm-6 col-md-3 mb-sm-20 fadeInUp -->';
				}
				echo '</ul>';
				echo '</div>';
			}
		} else {
			if ( is_customize_preview() ) {
				echo '<div class="hero-slider about-team-member"></div>';
			}
		}
	}
endif;

if ( ! function_exists( 'shop_isle_about_page_video_title_callback' ) ) :
	/**
	 * Callback function for video title on about page
	 *
	 * @return string - video title value
	 */
	function shop_isle_about_page_video_title_callback() {
		return get_theme_mod( 'shop_isle_about_page_video_title' );
	}
endif;

if ( ! function_exists( 'shop_isle_about_page_video_subtitle_callback' ) ) :
	/**
	 * Callback function for video subtitle on about page
	 *
	 * @return string - video subtitle value
	 */
	function shop_isle_about_page_video_subtitle_callback() {
		return get_theme_mod( 'shop_isle_about_page_video_subtitle' );
	}
endif;

if ( ! function_exists( 'shop_isle_about_page_advantages_title_callback' ) ) :
	/**
	 * Callback function for advantages title
	 *
	 * @return string - advantages title value
	 */
	function shop_isle_about_page_advantages_title_callback() {
		return get_theme_mod( 'shop_isle_our_advantages_title' );
	}
endif;

if ( ! function_exists( 'shop_isle_about_page_display_advantages' ) ) :
	/**
	 * Callback function for advantages boxes on about page
	 */
	function shop_isle_about_page_display_advantages() {

		$shop_isle_advantages = get_theme_mod(
			'shop_isle_advantages',
			json_encode(
				array(
					array(
						'icon_value' => 'icon_lightbulb',
						'text'       => __( 'Ideas and concepts', 'shop-isle' ),
						'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
					),
					array(
						'icon_value' => 'icon_tools',
						'text'       => __( 'Designs & interfaces', 'shop-isle' ),
						'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
					),
					array(
						'icon_value' => 'icon_cogs',
						'text'       => __( 'Highly customizable', 'shop-isle' ),
						'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
					),
					array(
						'icon_value' => 'icon_like',
						'text'       => __( 'Easy to use', 'shop-isle' ),
						'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
					),
				)
			)
		);

		if ( ! empty( $shop_isle_advantages ) ) :

			$shop_isle_advantages_decoded = json_decode( $shop_isle_advantages );

			if ( ! empty( $shop_isle_advantages_decoded ) ) :

				echo '<div class="row multi-columns-row">';

				foreach ( $shop_isle_advantages_decoded as $shop_isle_advantage ) :

					$icon_value = ! empty( $shop_isle_advantage->icon_value ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_advantage->icon_value, 'Advantages section' ) : '';
					$text       = ! empty( $shop_isle_advantage->text ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_advantage->text, 'Advantages section' ) : '';
					$subtext    = ! empty( $shop_isle_advantage->subtext ) ? apply_filters( 'shop_isle_translate_single_string', $shop_isle_advantage->subtext, 'Advantages section' ) : '';

					echo '<div class="col-sm-6 col-md-3 col-lg-3">';
					echo '<div class="features-item">';

					if ( ! empty( $icon_value ) ) :
						echo '<div class="features-icon">';
						echo '<span class="' . esc_attr( $icon_value ) . '"></span>';
						echo '</div>';
					endif;

					if ( ! empty( $text ) ) :
						echo '<h3 class="features-title font-alt">' . wp_kses_post( $text ) . '</h3>';
					endif;

					if ( ! empty( $subtext ) ) :
						echo wp_kses_post( $subtext );
					endif;

					echo '</div>';
					echo '</div>';

				endforeach;

				echo '</div>';
			endif;
		else :
			if ( is_customize_preview() ) {
				echo '<div class="row multi-columns-row"></div>';
			}
		endif;
	}
endif;
