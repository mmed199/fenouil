<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap">
    <h2><?php echo esc_html($page->title()); ?></h2>
	<?php settings_errors(); ?>

    <form method="post" action="options.php"><?php
		settings_fields( $page->id() );
		do_settings_sections( $page->id() );
		submit_button();
		?>
    </form>
</div>