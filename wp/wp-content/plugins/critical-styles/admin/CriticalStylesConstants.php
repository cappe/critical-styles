<?php

class Critical_Styles_Constants {
	/**
	 * The options prefix to be used in this plugin.
	 *
	 * @return string
	 */
	public static function PLUGIN_PREFIX(): string {
		return 'critical_styles';
	}

	/**
	 * The namespace for this plugin.
	 *
	 * @return string
	 */
	public static function NAMESPACE(): string {
		return 'critical-styles';
	}

	/**
	 * Option name for API token.
	 *
	 * @return string
	 */
	public static function API_TOKEN_OPTION_NAME(): string {
		return self::PLUGIN_PREFIX() . '_api_token';
	}

	public static function BASE_URL(): string {
		return 'http://web:3000';
	}
}
