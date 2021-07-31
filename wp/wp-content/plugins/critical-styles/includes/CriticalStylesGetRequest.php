<?php

class Critical_Styles_GET_Request implements Critical_Styles_Http_Request {
	private ?string $api_token;
	private ?string $url;

	public function set_api_token( ?string $api_token ) {
		$this->api_token = $api_token;
	}

	public function set_url( string $url ) {
		$this->url = $url;
	}

	public function get_headers(): array {
		return array(
			'Accept'        => 'application/json',
			'Authorization' => 'Token token=' . $this->api_token
		);
	}

	public function get_url(): string {
		return $this->url;
	}
}
