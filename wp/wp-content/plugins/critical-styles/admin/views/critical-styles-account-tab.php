<form
	action="options.php?tab=<?= $current_tab ?>"
	method="post"
>
	<?php
	settings_fields( $plugin_name );
	do_settings_sections( $plugin_name );
	submit_button();
	?>
</form>
