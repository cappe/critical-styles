<?php

class Critical_Styles_Config {
	private Critical_Styles_Ajax_Handler $ajax_handler;
	public Critical_Styles_User $user;

	public function __construct() {
		$this->ajax_handler = new Critical_Styles_Ajax_Handler( self::api_token() );
		$this->set_user();
	}

	public function set_user() {
		$raw_user_data = $this->ajax_handler->get_raw_user_data();
		$user = new Critical_Styles_User( $raw_user_data );

		$raw_user_domains = $this->ajax_handler->get_raw_user_domains($user->domains_resource_path());
		$user->set_domains( $raw_user_domains );

		$this->user = $user;
	}

	public static function api_token(): string {
		return get_option( Critical_Styles_Constants::API_TOKEN_OPTION_NAME() );
	}

//	public function has_valid_api_token(): bool {
//		return $this->user->has_valid_api_token();
//	}
//
//	public function active_domains(): array {
//		return $this->user->active_domains();
//	}
}
