<?php

class Critical_Styles_Your_Pages_Tab extends Critical_Styles_Base_Tab {
	public function admin_init() {}

	public function template_name(): string {
		return 'critical-styles-your-pages-tab.php';
	}

	public function view_variables(): array {
		return array(
			'user_id'  => $this->config->get_user()->id,
			'webpages' => $this->config->current_domain()->get_webpages(),
		);
	}
}
