<?php

class Critical_Styles_Domain {
	public string $id;
	public string $url;

	private ?array $webpages = null;
	private string $webpages_relationships_path;
	private Critical_Styles_User $user;

	public function __construct( ) {}

	public static function build( $data ): self {
		$attributes = $data['attributes'];
		$relationships = $data['relationships'];

		$domain = new self();
		$domain->id = $attributes['id'];
		$domain->url = $attributes['url'];

		$domain->webpages_relationships_path = $relationships['webpages']['links']['related'];

		return $domain;
	}

	/**
	 * Sets the belongs_to association.
	 *
	 * @param Critical_Styles_User $user
	 */
	public function set_user( Critical_Styles_User $user ) {
		$this->user = $user;
	}

	public function get_user(): Critical_Styles_User {
		return $this->user;
	}

	/**
	 * Loads domain's webpages on-demand.
	 *
	 * @return array
	 */
	public function get_webpages(): array {
		if ( ! isset($this->webpages) ) {
			$this->webpages = array();

			$req = new Critical_Styles_GET_Request();
			$req->set_api_token( $this->get_user()->api_token );
			$req->set_path( $this->webpages_relationships_path );

			$res = Critical_Styles_Api_Handler::exec( $req );

			foreach ( $res['data'] as $raw ) {
				$webpage = Critical_Styles_Webpage::build( $raw );
				$webpage->set_domain( $this );

				array_push(
					$this->webpages,
					$webpage,
				);
			}
		}

		return $this->webpages;
	}
}
