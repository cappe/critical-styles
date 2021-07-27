<?php

class Critical_Styles_User {
	public $api_token;
	public $email;
	public $id;
	public $relationships;

	private array $domains;

	public function __construct( $raw_user_data ) {
		$attributes = $raw_user_data['data']['attributes'];
		$this->api_token = $attributes['api_token'];
		$this->email = $attributes['email'];
		$this->id = $attributes['id'];
		$this->relationships = $raw_user_data['data']['relationships'];
		$this->domains = array();
	}

	public function set_domains( $raw_domains_data ) {
		foreach($raw_domains_data['data'] as $raw_domain_data) {
			$domain = Critical_Styles_Domain::build( $raw_domain_data );
			array_push($this->domains, $domain);
		}
	}

	public function domains_resource_path(): string {
		return $this->relationships['domains']['links']['related'];
	}

	public function has_valid_api_token(): bool {
		return true;
	}

	public function active_domains(): array {
		return $this->domains;
	}
}
