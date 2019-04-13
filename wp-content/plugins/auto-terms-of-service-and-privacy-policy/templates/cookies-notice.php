<?php

use \wpautoterms\frontend\notice\Cookies_Notice;

?>
<div class="<?php echo esc_attr( Cookies_Notice::CLASS_COOKIES_NOTICE ); ?>"><?php echo $message; ?>
    <a href="javascript:void(0);" class="<?php echo esc_attr( Cookies_Notice::CLASS_CLOSE_BUTTON ); ?>"
       data-value="<?php echo esc_attr( $cookie_value ); ?>" data-cookie="<?php echo esc_attr( $cookie_name ); ?>">
		<?php echo $close; ?></a></div>