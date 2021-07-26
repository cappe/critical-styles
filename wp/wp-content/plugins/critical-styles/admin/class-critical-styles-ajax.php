<?php

class Critical_Styles_Ajax {
	public function __construct() {
	}

	public static function validate_api_key( $api_key ): bool {
		$args = array(
			'headers' => array(
				'Accept' => 'application/json',
				'Authorization' => 'Token token=' . $api_key
			)
		);

		$res = wp_remote_get( 'http://web:3000/api/v1/user', $args );
		$code = wp_remote_retrieve_response_code( $res );
		$body = wp_remote_retrieve_body( $res );

		return $code == 200;
	}
}
