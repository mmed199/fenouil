<?php   
function activate_target_management(){
    global $wpdb;
    global $wp_roles;

    $table_name = $wpdb->prefix . 'target';
    $charset_collate = $wpdb->get_charset_collate();

    // Add Table
    $sql = "CREATE TABLE $table_name (
    id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    target_name VARCHAR(255),
    target_age VARCHAR(255),
    target_categorie VARCHAR(255),
    target_state VARCHAR(255),
    target_description TEXT,
    confirmed BOOLEAN,
    PRIMARY KEY  (id)
    ) $charset_collate ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // Add Cappabilities
    $wp_roles->add_cap('administrator', 'am_confirm_target' );
    $wp_roles->add_cap('administrator', 'am_add_target' );
    $wp_roles->add_cap('administrator', 'am_generate_xml_target' );

}


