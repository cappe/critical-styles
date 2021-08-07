<?php

trait Critical_Styles_Create_Trait {
	private string $create_path;

	public function set_create_path( string $path ) {
		$this->create_path = $path;
	}

	public function get_create_path(): string {
		return $this->create_path;
	}
}
