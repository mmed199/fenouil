<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// WARNING: #poststuff style block should reside here
?>
<style>
    #poststuff {
        display: none;
    }
</style>

<input type="hidden" name="legal_page" value="<?php echo esc_attr( $page->id() ); ?>"/>
<div id="legal-page-container" class="postbox">
	<?php
	echo $page->wizard();
	?>
</div>