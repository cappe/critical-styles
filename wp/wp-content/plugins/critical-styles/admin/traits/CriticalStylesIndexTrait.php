<?php

trait Critical_Styles_Index_Trait {
	private string $index_path;

	public function set_index_path( string $path ) {
		$this->index_path = $path;
	}

	public function get_index_path(): string {
		return $this->index_path;
	}
}
