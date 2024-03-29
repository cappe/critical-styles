<?php

class Critical_Styles_Webpage_Collection {
	use Critical_Styles_Owner_Trait;
	use Critical_Styles_Index_Trait;
	use Critical_Styles_Create_Trait;

	private ?array $webpages = null;
	private Critical_Styles_Domain $domain;

	public function __construct() {
	}

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
		$this->webpages = array_merge( $this->webpages, $webpages );
	}

	public function remove() {
		// TODO: Implement this
	}

	private function cache_webpages() {
		$webpages = $this->build_webpages();
		$webpages = $this->hydrate_with_api_data( $webpages );

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
					'owner'   => $this->get_owner(),
					'page_id' => get_the_ID(),
					'path'    => '/' . get_page_uri(),
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
	 *
	 * @return array
	 */
	private function hydrate_with_api_data( array $webpages ): array {
		$webpage_paths = [];

		foreach ( $webpages as $webpage ) {
			array_push( $webpage_paths, $webpage->path );
		}

		$req = new Critical_Styles_POST_Request();
		$req->set_api_token( $this->get_owner()->api_token );
		$req->set_path( $this->get_create_path() );
		$req->set_body( array( 'webpage_paths' => array_values( $webpage_paths ) ) );

		$res = Critical_Styles_Api_Handler::exec( $req );

		foreach ( $webpages as $webpage ) {
			$webpage_data = null;

			/**
			 * Finds corresponding webpage data
			 */
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
				array_splice( $res['data'], $index, 1 );

				break;
			}

			if ( isset( $webpage_data ) ) {
				/**
				 * Hydrate the webpage with the API data
				 */
				$webpage->id                    = $webpage_data['attributes']['id'];
				$webpage->critical_css_filename = $webpage_data['attributes']['critical_css_filename'];
				$webpage->critical_css_url      = $webpage_data['attributes']['critical_css_url'];
				$webpage->job_status            = $webpage_data['attributes']['job_status'];
			}
//			else {
			// TODO: Should we handle a case where data was not found
//			}
		}

		return $webpages;
	}
}
