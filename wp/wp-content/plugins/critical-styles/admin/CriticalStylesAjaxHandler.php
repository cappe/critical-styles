<?php

class Critical_Styles_Ajax_Handler {
	private array $default_headers;

	public function __construct( $api_token ) {
		$this->default_headers = array(
			'Accept' => 'application/json',
			'Authorization' => 'Token token=' . $api_token
		);
	}

	public function get_raw_user_data() {
		$res = wp_remote_get(
			'http://web:3000/api/v1/user',
			array('headers' => $this->default_headers)
		);

		return $this->handle_response( $res );
	}

	public function get_raw_user_domains( $path ) {
		$res = wp_remote_get(
			Critical_Styles_Constants::BASE_URL() . $path,
			array('headers' => $this->default_headers)
		);

		return $this->handle_response( $res );
	}

	private function handle_response( $res ) {
		$code = wp_remote_retrieve_response_code( $res );
		$body = wp_remote_retrieve_body( $res );

		if ($code == 200) {
			return json_decode($body, true);
		}

		// TODO: Handle errors
		return null;
	}
}
