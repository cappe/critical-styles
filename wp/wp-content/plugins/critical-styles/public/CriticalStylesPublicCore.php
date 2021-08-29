<?php

class Critical_Styles_Public_Core {
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
	}

	public function wp_head() {
		$filename = get_option( 'critical_styles_webpage_' . get_the_ID() );
		$file     = Critical_Styles_Config::get()->cacheDir() . '/' . $filename;
		$css      = file_get_contents( $file );
		?>

		<style id="critical-styles">
			<?= $css ?>
		</style>

		<?php
	}

	public function style_loader_tag( $html, $handle, $href, $media ) {
		$html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" id='$handle' href='$href' type='text/css' media='all' />
EOT;

		return $html;
	}
}
