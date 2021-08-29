<?php

abstract class Critical_Styles_Base_Tab implements Critical_Styles_Viewable {
	public function __construct() {}

	public static function build(): self {
		$klass = get_called_class();
		return new $klass();
	}

	abstract function admin_init();
}
