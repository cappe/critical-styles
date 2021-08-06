<?php

class Critical_Styles_Webpage {
	public string $id;
	public string $path;

	private Critical_Styles_Domain $domain;

	public function __construct( ) {}

	public static function build( $data ): self {
		$attributes = $data['attributes'];

		$domain = new self();
		$domain->id = $attributes['id'];
		$domain->path = $attributes['path'];

		return $domain;
	}

	/**
	 * Sets the belongs_to association.
	 *
	 * @param Critical_Styles_Domain $domain
	 */
	public function set_domain( Critical_Styles_Domain $domain ) {
		$this->domain = $domain;
	}

	public function get_domain(): Critical_Styles_Domain {
		return $this->domain;
	}
}
