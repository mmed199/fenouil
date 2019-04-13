<?php
function xa_filter_woocommerce_states( $states ) { 
    unset( $states['FR'] );
    //var_dump( $states ) ;
    return $states;
};
add_filter( 'woocommerce_states', 'xa_filter_woocommerce_states', 10, 1 );

function xa_filter_woocommerce_get_country_locale( $locale ) { 
    $locale['FR']['state']['required'] = true;
    return $locale; 
};
add_filter( 'woocommerce_get_country_locale', 'xa_filter_woocommerce_get_country_locale', 10, 1 );
 
 