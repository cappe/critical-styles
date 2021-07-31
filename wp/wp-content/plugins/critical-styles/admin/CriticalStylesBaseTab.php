<?php

abstract class Critical_Styles_Base_Tab implements Critical_Styles_Viewable {
	public Critical_Styles_Config $config;

	public function __construct( Critical_Styles_Config $config ) {
		$this->config = $config;
	}

	public static function build( Critical_Styles_Config $config ): self {
		$klass = get_called_class();

		return new $klass( $config );
	}

	abstract function admin_init();
}
