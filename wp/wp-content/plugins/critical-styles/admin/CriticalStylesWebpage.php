<?php

class Critical_Styles_Webpage {
	use Critical_Styles_Owner_Trait;

	public ?string $id = null;
	public ?string $page_id = null;
	public ?string $critical_css_filename = null;
	public ?string $critical_css_url = null;
	public string $path;
	public string $job_status;

	public function __construct() {
		$this->job_status = 'created';
	}

	public static function build( $data ): self {
		$attributes = $data['attributes'];

		$webpage          = new self();
		$webpage->page_id = $attributes['page_id'];
		$webpage->path    = $attributes['path'];
		$webpage->set_owner( $attributes['owner'] );

		return $webpage;
	}

	public function is_new(): bool {
		return ! $this->id;
	}

	public function criticalCss(): string {
		$filename = $this->critical_css_filename;
		$file     = Critical_Styles_Config::get()->cacheDir() . '/' . $filename;

		if ( ! file_exists( $file ) ) {
			file_put_contents(
				$file,
				file_get_contents( $this->critical_css_url ),
			);

			$key = 'critical_styles_webpage_' . $this->page_id;
			update_option( $key, $filename );
		}

		return file_get_contents( $file );
	}
}
