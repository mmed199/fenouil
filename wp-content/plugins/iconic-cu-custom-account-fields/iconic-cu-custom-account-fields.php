<?php
/*
Plugin Name: WooCommerce Custom Account Fields
Plugin URI: https://iconicwp.com/blog/the-ultimate-guide-to-adding-custom-woocommerce-user-account-fields/
Description: Add custom WooCommerce user account fields.
Author: Iconic
Version: 1.0.0
Author URI: https://iconicwp.com/products/
*/

/**
 * Get additional account fields.
 *
 * @return array
 */
function iconic_get_account_fields() {
	$departements = 
    json_decode(
    file_get_contents(get_theme_file_path('departments.json')),
    true);
    $departementsformatted = array();
	$departementsformatted[''] = __( 'Select an option...', 'iconic' );

    foreach($departements  as $key => $value) {
        $departementsformatted[$value['name']] = __( $value['name'], 'iconic' );
    }
	
	$categories = 
    json_decode(
    file_get_contents(get_theme_file_path('categories.json')),
    true);
    $categoriesformatted = array();
	$categoriesformatted[''] = __( 'Select an option...', 'iconic' );

    foreach($categories  as $key => $value) {
        $categoriesformatted[$value['name']] = __( $value['name'], 'iconic' );
    }
	
	return apply_filters( 'iconic_account_fields', array(
		'first_name'                 => array(
			'type'                 => 'text',
			'label'                => __( 'First Name', 'iconic' ),
			'hide_in_checkout'     => true,
			'required'             => true,
		),
		'last_name'                  => array(
			'type'                 => 'text',
			'label'                => __( 'Last Name', 'iconic' ),
			'hide_in_checkout'     => true,
			'hide_in_registration' => false,
			'required'             => true,
		),
		'Birthday'       => array(
			'type'        => 'date',
			'label'       => __( 'Birthday', 'iconic' ),
			'required'    => true,
		),
		'State_Departement'     => array(
			'type'    => 'select',
			'label'   => __( 'State', 'iconic' ),
			'options' => $departementsformatted,
			'required'    => true,
		),
		'category'     => array(
			'type'    => 'select',
			'label'   => __( 'socio-professional categoriy', 'iconic' ),
			'options' => $categoriesformatted,
			'required'    => true,
		),
	) );
}

/**
 * Add post values to account fields if set.
 *
 * @param array $fields
 *
 * @return array
 */
function iconic_add_post_data_to_account_fields( $fields ) {
	if ( empty( $_POST ) ) {
		return $fields;
	}

	foreach ( $fields as $key => $field_args ) {
		if ( empty( $_POST[ $key ] ) ) {
			$fields[ $key ]['value'] = '';
			continue;
		}

		$fields[ $key ]['value'] = $_POST[ $key ];
	}

	return $fields;
}

add_filter( 'iconic_account_fields', 'iconic_add_post_data_to_account_fields', 10, 1 );

/**
 * Add fields to registration form and account area.
 */
function iconic_print_user_frontend_fields() {
	$fields            = iconic_get_account_fields();
	$is_user_logged_in = is_user_logged_in();

	foreach ( $fields as $key => $field_args ) {
		$value = null;

		if ( ! iconic_is_field_visible( $field_args ) ) {
			continue;
		}

		if ( $is_user_logged_in ) {
			$user_id = iconic_get_edit_user_id();
			$value   = iconic_get_userdata( $user_id, $key );
		}

		$value = isset( $field_args['value'] ) ? $field_args['value'] : $value;

		woocommerce_form_field( $key, $field_args, $value );
	}
}

add_action( 'woocommerce_register_form', 'iconic_print_user_frontend_fields', 10 ); // register form
add_action( 'woocommerce_edit_account_form', 'iconic_print_user_frontend_fields', 10 ); // my account

/**
 * Get user data.
 *
 * @param $user_id
 * @param $key
 *
 * @return mixed|string
 */
function iconic_get_userdata( $user_id, $key ) {
	if ( ! iconic_is_userdata( $key ) ) {
		return get_user_meta( $user_id, $key, true );
	}

	$userdata = get_userdata( $user_id );

	if ( ! $userdata || ! isset( $userdata->{$key} ) ) {
		return '';
	}

	return $userdata->{$key};
}

/**
 * Modify checkboxes/radio fields.
 *
 * @param $field
 * @param $key
 * @param $args
 * @param $value
 *
 * @return string
 */
function iconic_form_field_modify( $field, $key, $args, $value ) {
	ob_start();
	iconic_print_list_field( $key, $args, $value );
	$field = ob_get_clean();

	if ( $args['return'] ) {
		return $field;
	} else {
		echo $field;
	}
}

add_filter( 'woocommerce_form_field_checkboxes', 'iconic_form_field_modify', 10, 4 );
add_filter( 'woocommerce_form_field_radio', 'iconic_form_field_modify', 10, 4 );

/**
 * Get currently editing user ID (frontend account/edit profile/edit other user).
 *
 * @return int
 */
function iconic_get_edit_user_id() {
	return isset( $_GET['user_id'] ) ? (int) $_GET['user_id'] : get_current_user_id();
}

/**
 * Print a list field (checkboxes|radio).
 *
 * @param string $key
 * @param array  $field_args
 * @param mixed  $value
 */
function iconic_print_list_field( $key, $field_args, $value = null ) {
	$value = empty( $value ) && $field_args['type'] === 'checkboxes' ? array() : $value;
	?>
	<div class="form-row">
		<?php if ( ! empty( $field_args['label'] ) ) { ?>
			<label>
				<?php echo $field_args['label']; ?>
				<?php if ( ! empty( $field_args['required'] ) ) { ?>
					<abbr class="required" title="<?php echo esc_attr__( 'required', 'woocommerce' ); ?>">*</abbr>
				<?php } ?>
			</label>
		<?php } ?>
		<ul>
			<?php foreach ( $field_args['options'] as $option_value => $option_label ) {
				$id         = sprintf( '%s_%s', $key, sanitize_title_with_dashes( $option_label ) );
				$option_key = $field_args['type'] === 'checkboxes' ? sprintf( '%s[%s]', $key, $option_value ) : $key;
				$type       = $field_args['type'] === 'checkboxes' ? 'checkbox' : $field_args['type'];
				$checked    = $field_args['type'] === 'checkboxes' ? in_array( $option_value, $value ) : $option_value == $value;
				?>
				<li>
					<label for="<?php echo esc_attr( $id ); ?>">
						<input type="<?php echo esc_attr( $type ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $option_key ); ?>" value="<?php echo esc_attr( $option_value ); ?>" <?php checked( $checked ); ?>>
						<?php echo $option_label; ?>
					</label>
				</li>
			<?php } ?>
		</ul>
	</div>
	<?php
}

/**
 * Save registration fields.
 *
 * @param int $customer_id
 */
function iconic_save_account_fields( $customer_id ) {
	$fields         = iconic_get_account_fields();
	$sanitized_data = array();

	foreach ( $fields as $key => $field_args ) {
		if ( ! iconic_is_field_visible( $field_args ) ) {
			continue;
		}

		$sanitize = isset( $field_args['sanitize'] ) ? $field_args['sanitize'] : 'wc_clean';
		$value    = isset( $_POST[ $key ] ) ? call_user_func( $sanitize, $_POST[ $key ] ) : '';

		if ( iconic_is_userdata( $key ) ) {
			$sanitized_data[ $key ] = $value;
			continue;
		}

		update_user_meta( $customer_id, $key, $value );
	}

	if ( ! empty( $sanitized_data ) ) {
		$sanitized_data['ID'] = $customer_id;
		wp_update_user( $sanitized_data );
	}
}

add_action( 'woocommerce_created_customer', 'iconic_save_account_fields' ); // register/checkout
add_action( 'personal_options_update', 'iconic_save_account_fields' ); // edit own account admin
add_action( 'edit_user_profile_update', 'iconic_save_account_fields' ); // edit other account
add_action( 'woocommerce_save_account_details', 'iconic_save_account_fields' ); // edit WC account

/**
 * Is this field core user data.
 *
 * @param $key
 *
 * @return bool
 */
function iconic_is_userdata( $key ) {
	$userdata = array(
		'user_pass',
		'user_login',
		'user_nicename',
		'user_url',
		'user_email',
		'display_name',
		'nickname',
		'first_name',
		'last_name',
		'description',
		'rich_editing',
		'user_registered',
		'role',
		'jabber',
		'aim',
		'yim',
		'show_admin_bar_front',
	);

	return in_array( $key, $userdata );
}

/**
 * Is field visible.
 *
 * @param $field_args
 *
 * @return bool
 */
function iconic_is_field_visible( $field_args ) {
	$visible = true;
	$action  = filter_input( INPUT_POST, 'action' );

	if ( is_admin() && ! empty( $field_args['hide_in_admin'] ) ) {
		$visible = false;
	} elseif ( ( is_account_page() || $action === 'save_account_details' ) && is_user_logged_in() && ! empty( $field_args['hide_in_account'] ) ) {
		$visible = false;
	} elseif ( ( is_account_page() || $action === 'save_account_details' ) && ! is_user_logged_in() && ! empty( $field_args['hide_in_registration'] ) ) {
		$visible = false;
	} elseif ( is_checkout() && ! empty( $field_args['hide_in_checkout'] ) ) {
		$visible = false;
	}

	return $visible;
}

/**
 * Add fields to admin area.
 */
function iconic_print_user_admin_fields() {
	$fields = iconic_get_account_fields();
	?>
	<h2><?php _e( 'Additional Information', 'iconic' ); ?></h2>
	<table class="form-table" id="iconic-additional-information">
		<tbody>
		<?php foreach ( $fields as $key => $field_args ) { ?>
			<?php
			if ( ! iconic_is_field_visible( $field_args ) ) {
				continue;
			}

			$user_id = iconic_get_edit_user_id();
			$value   = iconic_get_userdata( $user_id, $key );
			?>
			<tr>
				<th>
					<label for="<?php echo $key; ?>"><?php echo $field_args['label']; ?></label>
				</th>
				<td>
					<?php $field_args['label'] = false; ?>
					<?php woocommerce_form_field( $key, $field_args, $value ); ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php
}

add_action( 'show_user_profile', 'iconic_print_user_admin_fields', 30 ); // admin: edit profile
add_action( 'edit_user_profile', 'iconic_print_user_admin_fields', 30 ); // admin: edit other users

/**
 * Validate fields on frontend.
 *
 * @param WP_Error $errors
 *
 * @return WP_Error
 */
function iconic_validate_user_frontend_fields( $errors ) {
	$fields = iconic_get_account_fields();

	foreach ( $fields as $key => $field_args ) {
		if ( empty( $field_args['required'] ) ) {
			continue;
		}

		if ( ! isset( $_POST['register'] ) && ! empty( $field_args['hide_in_account'] ) ) {
			continue;
		}

		if ( isset( $_POST['register'] ) && ! empty( $field_args['hide_in_registration'] ) ) {
			continue;
		}

		if ( empty( $_POST[ $key ] ) ) {
			$message = sprintf( __( '%s is a required field.', 'iconic' ), '<strong>' . $field_args['label'] . '</strong>' );
			$errors->add( $key, $message );
		}
	}

	return $errors;
}

add_filter( 'woocommerce_registration_errors', 'iconic_validate_user_frontend_fields', 10 );
add_filter( 'woocommerce_save_account_details_errors', 'iconic_validate_user_frontend_fields', 10 );

/**
 * Show fields at checkout.
 */
function iconic_checkout_fields( $checkout_fields ) {
	$fields = iconic_get_account_fields();

	foreach ( $fields as $key => $field_args ) {
		if ( ! iconic_is_field_visible( $field_args ) ) {
			continue;
		}

		// Make sure our fields have a default priority so
		// no error is thrown when sorting them.
		$field_args['priority'] = isset( $field_args['priority'] ) ? $field_args['priority'] : 0;

		$checkout_fields['account'][ $key ] = $field_args;
	}

	// Default password field has no priority which throws an
	// error when it tries to order the fields by priority.
	if ( ! empty( $checkout_fields['account']['account_password'] ) && ! isset( $checkout_fields['account']['account_password']['priority'] ) ) {
		$checkout_fields['account']['account_password']['priority'] = 0;
	}

	return $checkout_fields;
}

add_filter( 'woocommerce_checkout_fields', 'iconic_checkout_fields', 10, 1 );