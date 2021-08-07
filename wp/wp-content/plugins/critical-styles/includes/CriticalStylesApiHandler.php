<?php

class Critical_Styles_Api_Handler {
	public static function exec( Critical_Styles_Http_Request $req ) {
		return self::handle_response( $req->exec() );
	}

	private static function handle_response( $res ) {
		$code = wp_remote_retrieve_response_code( $res );
		$body = wp_remote_retrieve_body( $res );

		if ( $code == 200 ) {
			return json_decode( $body, true );
		}

		// TODO: Handle errors
		return null;
	}
}
