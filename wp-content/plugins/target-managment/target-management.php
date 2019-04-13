<?php
/**
 * Plugin Name: Targets Management
 * Plugin URI:  https://github.com/mmed199/plugin-gestion-publicites
 * Description: Plugin to generate XML Files for a target group of users
 * Version:     2.0.0
 * Author:      Moussaoui Mohammed
 * Author URI:  https://github.com/mmed199/
 * Text Domain: wporg
 * Domain Path: /languages
 * License:     GPL2
 */

 /*
    Gestion publicites is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    any later version.

    Gestion publicites is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Gestion publicites. If not, see https://github.com/mmed199/plugin-gestion-publicites.
 */

require_once('admin/activation.php');
require_once('admin/admin.php');

function xml_generation_page() {

    if( isset( $_POST['XML'] ) && $_POST['XML'] == 1 ){
		global $wpdb;
        
        $target = $wpdb->get_row( 'SELECT * FROM '. $wpdb->prefix . 'target WHERE id = '.$_POST['id'], ARRAY_A );
        
        $age_min = 0;
        $age = json_decode(file_get_contents(plugin_dir_path(__FILE__).'\admin\age.json'),true);
        foreach($age as $key => $value){
            if($target['target_age'] == $value['name']){
                $age_min = $value['age_min'];
                $age_max = $value['age_max'];
            }
        }

        $query_age = "
        SELECT user_id FROM ". $wpdb->prefix ."usermeta WHERE meta_key = 'Birthday' AND
            ( YEAR(CURDATE()) - EXTRACT( YEAR FROM STR_TO_DATE(meta_value,'%Y-%m-%d')) > 20 )
        ";
        
        $query_state = "
        SELECT user_id FROM ".$wpdb->prefix."usermeta WHERE meta_key = 'State_Departement' 
        AND meta_value = '". $target['target_state']."'";
        
        $query_category = "
        SELECT user_id FROM ".$wpdb->prefix."usermeta WHERE meta_key = 'Category' 
        AND meta_value = '". $target['target_categorie']."'";

        $query = "
        SELECT * FROM ".$wpdb->prefix."users WHERE id IN ( ". $query_age ." ) AND id IN (".$query_state.") 
        AND id IN (".$query_category.")";

        
        $res = $wpdb->get_results($query, ARRAY_A );
        
    
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        $cible = $doc->createElement( "Cible" );
        $cible->setAttribute('id', strval($target['id']) );

        $informations = $doc->createElement("Informations");
      
        $name = $doc->createElement('name');
        $description = $doc->createElement('description');
        $age = $doc->createElement('age');
        $category = $doc->createElement('category');
        $state = $doc->createElement('state');

        $name->appendChild(
            $doc->createTextNode( $target['target_name'])
        );
        $description->appendChild(
            $doc->createTextNode( $target['target_description'])
        );
        $age->appendChild(
            $doc->createTextNode( $target['target_age'])
        );
        $category->appendChild(
            $doc->createTextNode( $target['target_categorie'])
        );
        $state->appendChild(
            $doc->createTextNode( $target['target_state'])
        );

        $informations->appendChild($name);
        $informations->appendChild($description);
        $informations->appendChild($age);
        $informations->appendChild($category);
        $informations->appendChild($state);
        $cible->appendChild($informations);

        $utilisateurs = $doc->createElement('Utilisateurs');
        foreach( $res as $utilisateur ){
            $u = $doc->createElement( "Utilisateur" );
            $u->setAttribute('id',strval($utilisateur['ID']));

            $user_nicename = $doc->createElement( "name" );
            $user_nicename->appendChild(
            $doc->createTextNode( $utilisateur['user_nicename'] )
            );
            $u->appendChild( $user_nicename );

            $user_email = $doc->createElement( "email" );
            $user_email->appendChild(
            $doc->createTextNode( $utilisateur['user_email'] )
            );
            $u->appendChild( $user_email );

            $utilisateurs->appendChild( $u );
        }

        $cible->appendChild($utilisateurs);
        $doc->appendChild($cible);

        $file = get_temp_dir().$target['target_name'].'.xml';



        $doc->save($file);
        
        header("Content-type: application/x-msdownload",true,200);
        header("Content-Disposition: attachment; filename=".$target['target_name'].".xml");
        header("Pragma: no-cache");
        readfile($file);  
        header("Expires: 0");
        
        unlink($file) or die("Couldn't delete file");
        exit;
    }
}

add_action( 'admin_init', 'xml_generation_page');
register_activation_hook(__FILE__,'activate_target_management');
add_action( 'admin_menu', 'am_management_menu' );
wp_register_style('style', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
wp_register_style('fontawesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css');
wp_register_style('main',  plugins_url('/css/main.css',__FILE__ )  );