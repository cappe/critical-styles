<?php

class Critical_Styles_Webpage_Collection {
	use Critical_Styles_Owner_Trait;
	use Critical_Styles_Index_Trait;
	use Critical_Styles_Create_Trait;

	private ?array $webpages = null;
	private Critical_Styles_Domain $domain;

	public function __construct() {}

	public function set_domain( Critical_Styles_Domain $domain ) {
		$this->domain = $domain;
	}

	public function get_domain(): Critical_Styles_Domain {
		return $this->domain;
	}

	public function get(): array {
		if ( ! isset( $this->webpages ) ) {
			$this->webpages = array();
			$this->cache_webpages();
		}

		return $this->webpages;
	}

	public function add( Critical_Styles_Webpage $webpage ) {
		array_push( $this->webpages, $webpage );
	}

	public function add_batch( array $webpages ) {
		$this->webpages = array_merge($this->webpages, $webpages);
	}

	public function remove() {
		// TODO: Implement this
	}

	private function cache_webpages() {
		$webpages = $this->build_webpages();
		$webpages = $this->hydrate_with_api_data( $webpages );
		$webpages = $this->process_new_webpages( $webpages );

		$this->add_batch( $webpages );
	}

	/**
	 * Returns an array of Webpages from this domain's published webpages.
	 */
	private function build_webpages(): array {
		$webpages = array();

		$query = new WP_Query( array(
			'post_type'   => 'any',
			'post_status' => array( 'publish' ),
		) );

		while ( $query->have_posts() ) {
			$query->the_post();

			$data = array(
				'attributes' => array(
					'owner' => $this->get_owner(),
					'path' => '/' . get_page_uri(),
				),
			);

			$webpage = Critical_Styles_Webpage::build( $data );

			array_push(
				$webpages,
				$webpage,
			);
		}

		return $webpages;
	}

	/**
	 * Sets data for each Webpage in the collection.
	 *
	 * @param array $webpages
	 */
	private function hydrate_with_api_data( array $webpages ): array {
		$req = new Critical_Styles_GET_Request();
		$req->set_api_token( $this->get_owner()->api_token );
		$req->set_path( $this->get_index_path() );

		$res = Critical_Styles_Api_Handler::exec( $req );

		foreach ( $webpages as $webpage ) {
			$webpage_data = null;

			foreach ( $res['data'] as $index => $data ) {

				/**
				 * Not a match, continue...
				 */
				if ( $webpage->path != $data['attributes']['path'] ) {
					continue;
				}

				$webpage_data = $data;

				/**
				 * We don't need this data anymore here so we might as well delete
				 * it. It's a minor optimization in case there's a lot of raw data.
				 */
				array_splice($res['data'], $index, 1);

				break;
			}

			if ( isset( $webpage_data ) ) {
				/**
				 * Website data from API can be set here.
				 */
				$webpage->id = $webpage_data['attributes']['id'];
			} else {
				/**
				 * Data not found for the given webpage so we
				 * need to tell the API to start processing it.
				 */
			}
		}

		return $webpages;
	}

	/**
	 * Sends new webpages in a single POST to the API.
	 *
	 * @param array $webpages
	 *
	 * @return array
	 */
	private function process_new_webpages( array $webpages ): array {
		$new_webpages = array_filter( $webpages, array( $this, 'is_new_webpage' ) );
		$new_paths = [];

		foreach ( $new_webpages as $webpage ) {
			array_push( $new_paths, $webpage->path );
		}

		if (count($new_paths) <= 0) {
			return $webpages;
		}

		$req = new Critical_Styles_POST_Request();
		$req->set_api_token( $this->get_owner()->api_token );
		$req->set_path( $this->get_create_path() );
		$req->set_body( array( 'paths' => array_values( $new_paths ) ) );

		$res = Critical_Styles_Api_Handler::exec( $req );

		// TODO: Hydrate the new pages

		return $webpages;
	}

	private function is_new_webpage( Critical_Styles_Webpage $webpage ): bool {
		return $webpage->is_new();
	}
}
