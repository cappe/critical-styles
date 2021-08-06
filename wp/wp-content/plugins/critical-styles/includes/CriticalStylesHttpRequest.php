<?php

interface Critical_Styles_Http_Request {
	public function set_api_token( ?string $api_token );
	public function set_path( string $path );

	public function get_headers(): array;
	public function get_url(): string;
}
