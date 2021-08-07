<?php

trait Critical_Styles_Owner_Trait {
	private Critical_Styles_User $owner;

	/**
	 * Sets the belongs_to association.
	 *
	 * @param Critical_Styles_User $owner
	 */
	public function set_owner( Critical_Styles_User $owner ) {
		$this->owner = $owner;
	}

	public function get_owner(): Critical_Styles_User {
		return $this->owner;
	}
}
