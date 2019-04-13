<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
$option_name = 'wporg_option';
 
delete_option($option_name);
 
// for site options in Multisite
delete_site_option($option_name);
 
// drop a custom database table
global $wpdb;
$table_name = $wpdb->prefix . 'publicites ';
$sql = "DROP TABLE IF EXISTS $table_name";
$wpdb->query($sql);


// drop menu
function wporg_remove_options_page() {
    remove_menu_page( 'tools.php' );
}
add_action( 'admin_menu', 'wporg_remove_options_page', 99 );