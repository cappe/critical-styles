<?php

class Critical_Styles_Domain {
	public string $id;
	public string $url;

	public function __construct() {}

	public static function build( $raw_data ): self {
		$attributes = $raw_data['attributes'];

		$domain = new self();
		$domain->id = $attributes['id'];
		$domain->url = $attributes['url'];

		return $domain;
	}
}
