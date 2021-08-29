<?php

class Critical_Styles_Webpage {
	use Critical_Styles_Owner_Trait;

	public ?string $id = null;
	public ?string $critical_css_filename = null;
	public ?string $critical_css_url = null;
	public string $path;
	public string $status;

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
		return ! $this->id;
	}

	public function cachedCss(): string {
		$file = Critical_Styles_Config::get()->cacheDir() . '/' . $this->critical_css_filename;
		$exist = file_exists( $file );

		if ( ! $exist ) {
			file_put_contents(
				$file,
				file_get_contents( $this->critical_css_url ),
			);
		}

		return file_get_contents( $file );
	}
}
