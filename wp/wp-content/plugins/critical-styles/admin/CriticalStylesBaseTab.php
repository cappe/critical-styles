<?php

abstract class Critical_Styles_Base_Tab implements Critical_Styles_Viewable {
	public static function build(): self {
		$klass = get_called_class();

		$instance = new $klass();
		$instance->init();

		return $instance;
	}

	abstract function init();
}
