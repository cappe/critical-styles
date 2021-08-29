<?php

class Critical_Styles_Your_Pages_Tab extends Critical_Styles_Base_Tab {
	public function admin_init() {}

	public function template_name(): string {
		return 'critical-styles-your-pages-tab.php';
	}

	public function view_variables(): array {
		return array(
			'user_id'  => Critical_Styles_Config::get()->get_user()->id,
			'webpages' => Critical_Styles_Config::get()->current_domain()->get_webpages(),
		);
	}
}
