<?php

class Critical_Styles_POST_Request implements Critical_Styles_Http_Request {
	private ?string $api_token;
	private ?string $path;
	private array $payload;

	private string $base_url = 'http://web:3000';

	public function set_api_token( ?string $api_token ) {
		$this->api_token = $api_token;
	}

	public function set_path( string $path ) {
		$this->path = $path;
	}

	public function get_headers(): array {
		return array(
			'Accept'        => 'application/json',
			'Authorization' => 'Token token=' . $this->api_token
		);
	}

	public function get_url(): string {
		return $this->base_url . $this->path;
	}

	public function set_body( array $payload ) {
		$this->payload = $payload;
	}

	public function get_body(): array {
		return $this->payload;
	}

	public function exec() {
		return wp_remote_post(
			$this->get_url(),
			array(
				'headers'     => $this->get_headers(),
				'body'        => $this->get_body(),
				'data_format' => 'body',
			),
		);
	}
}
