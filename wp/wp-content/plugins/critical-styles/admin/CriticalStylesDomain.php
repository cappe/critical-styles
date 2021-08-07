<?php

class Critical_Styles_Domain {
	use Critical_Styles_Owner_Trait;

	public string $id;
	public string $url;

	private Critical_Styles_Webpage_Collection $webpages;

	public function __construct() {}

	public static function build( array $data ): self {
		$attributes    = $data['attributes'];

		$domain      = new self();
		$domain->id  = $attributes['id'];
		$domain->url = $attributes['url'];

		return $domain;
	}

	public function set_website_collection( array $data ) {
		$this->webpages = new Critical_Styles_Webpage_Collection();
		$this->webpages->set_owner( $this->get_owner() );
		$this->webpages->set_index_path( $data['relationships']['webpages']['links']['index'] );
		$this->webpages->set_create_path( $data['relationships']['webpages']['links']['create'] );
	}

	/**
	 * Loads domain's webpages on-demand.
	 *
	 * @return array
	 */
	public function get_webpages(): array {
		return $this->webpages->get();
	}
}
