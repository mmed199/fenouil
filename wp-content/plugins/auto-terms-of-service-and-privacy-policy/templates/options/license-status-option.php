<?php

use wpautoterms\admin\action\Recheck_License;

?>
<div>
	<span id="wpautoterms_license_status">
        <?php echo $status;
        if ( ! empty( $error_message ) ) {
	        echo ' (' . $error_message . ')';
        }
        ?>
    </span>
    <div>
		<?php _e( 'Last check:', WPAUTOTERMS_SLUG ); ?>
        <span id="wpautoterms_license_last_check"><?php _ex( 'unknown', 'license_settings_page', WPAUTOTERMS_SLUG ); ?></span>
        <div class="wpautoterms-recheck-license-button">
            <a class="button" href="javascript:void(0);" id="wpautoterms_recheck" data-action="<?php
			echo esc_attr( Recheck_License::NAME );
			?>"><?php _e( 'Recheck' ); ?></a>
        </div>
    </div>
</div>
