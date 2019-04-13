<?php
/**
 * Meta Box for Page Description
 *
 * @package ShopIsle
 *
 * @since 1.0.0
 */

/* Meta box for header description on shop page */
add_action( 'admin_menu', 'shop_isle_page_description_box' );
add_action( 'save_post', 'shop_isle_custom_add_save' );

/**
 * Add meta box for page header description
 *
 * @since  1.0.0
 */
function shop_isle_page_description_box() {
	add_meta_box( 'shop_isle_post_info', __( 'Header description', 'shop-isle' ), 'shop_isle_page_description_box_callback', 'page', 'side', 'high' );
}

/**
 * Add meta box for page header description - callback
 *
 * @since  1.0.0
 */
function shop_isle_page_description_box_callback() {
	global $post;
	?>
	<fieldset>
		<div>
			<p>
				<label for="shop_isle_page_description"><?php _e( 'Description', 'shop-isle' ); ?></label><br />
				<?php wp_editor( get_post_meta( $post->ID, 'shop_isle_page_description', true ), 'shop_isle_page_description' ); ?>
			</p>
		</div>
	</fieldset>
	<?php
}
