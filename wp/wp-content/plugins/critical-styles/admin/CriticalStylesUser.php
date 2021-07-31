<?php

class Critical_Styles_User {
	public $api_token;
	public $email;
	public $id;
//	public $relationships;
//	private array $domains;

	public function __construct( ) {}

	public static function load_user( $api_token ): self {
		/**
		 * 1. Do API request
		 * 2. Create user from the response
		 */

		$req = new Critical_Styles_GET_Request();
		$req->set_api_token( $api_token );
		$req->set_url( 'http://web:3000/api/v1/user' );

		$res = Critical_Styles_Api_Handler::exec( $req );

		$attributes = $res['data']['attributes'];
		$user = new self();

		$user->api_token = $attributes['api_token'];
		$user->email = $attributes['email'];
		$user->id = $attributes['id'];

		return $user;
	}

//	public function set_domains( $raw_domains_data ) {
//		foreach($raw_domains_data['data'] as $raw_domain_data) {
////			$domain = Critical_Styles_Domain::build( $raw_domain_data );
//			array_push($this->domains, $raw_domain_data);
//		}
//	}
//
//	public function domains_resource_path(): string {
//		return $this->relationships['domains']['links']['related'];
//	}
//
//	public function has_valid_api_token(): bool {
//		return true;
//	}
//
//	public function active_domains(): array {
//		return $this->domains;
//	}
}
