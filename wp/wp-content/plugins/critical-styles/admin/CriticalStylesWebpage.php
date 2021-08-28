<?php

class Critical_Styles_Webpage {
	use Critical_Styles_Owner_Trait;

	public ?string $id = null;
	public string $path;
	public string $status;
	public string $critical_css_url;

	public function __construct() {
		$this->status = 'created';
	}

	public static function build( $data ): self {
		$attributes = $data['attributes'];

		$webpage       = new self();
		$webpage->path = $attributes['path'];
		$webpage->set_owner( $attributes['owner'] );

		return $webpage;
	}

	public function is_new(): bool {
		return !$this->id;
	}
}
