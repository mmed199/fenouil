<?php

use wpautoterms\frontend\notice\Update_Notice;

?>
<div class="<?php echo esc_attr( Update_Notice::BLOCK_CLASS ); ?>"><?php echo $message; ?>
    <a href="javascript:void(0);" class="<?php echo esc_attr( Update_Notice::CLOSE_CLASS ) ?>"
       value="<?php echo esc_attr( $cookie_value ); ?>"
       cookie="<?php echo esc_attr( $cookie_name ); ?>"><?php echo $close; ?></a></div>