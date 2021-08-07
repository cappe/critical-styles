<?php

class Critical_Styles_User {
	use Critical_Styles_Index_Trait;

	public string $api_token;
	public string $email;
	public string $id;

	private ?array $domains = null;

	public function __construct( ) {}

	/**
	 * Loads user's domains on-demand.
	 *
	 * @return array
	 */
	public function get_domains(): array {
		if ( ! isset($this->domains) ) {
			$this->domains = array();

			$req = new Critical_Styles_GET_Request();
			$req->set_api_token( $this->api_token );
			$req->set_path( $this->get_index_path() );

			$res = Critical_Styles_Api_Handler::exec( $req );

			foreach ( $res['data'] as $data ) {
				$domain = Critical_Styles_Domain::build( $data );
				$domain->set_owner( $this );
				$domain->set_website_collection( $data );

				array_push(
					$this->domains,
					$domain,
				);
			}
		}

		return $this->domains;
	}

	public static function load_user( $api_token ): self {
		$req = new Critical_Styles_GET_Request();
		$req->set_api_token( $api_token );
		$req->set_path( '/api/v1/user' );

		$res = Critical_Styles_Api_Handler::exec( $req );

		$attributes = $res['data']['attributes'];
		$relationships = $res['data']['relationships'];

		$user = new self();

		$user->api_token = $attributes['api_token'];
		$user->email = $attributes['email'];
		$user->id = $attributes['id'];

		$user->set_index_path( $relationships['domains']['links']['index'] );

		return $user;
	}
}
