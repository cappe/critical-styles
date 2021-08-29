<?php

class Critical_Styles_Account_Tab extends Critical_Styles_Base_Tab {
	public function admin_init() {
		$this->account_details_section();
		$this->domains_section();
	}

	public function template_name(): string {
		return 'critical-styles-account-tab.php';
	}

	public function view_variables(): array {
		return array(
			'current_tab' => 'account',
			'plugin_name' => Critical_Styles_Config::get()->plugin_name(),
		);
	}

	/**
	 * Account details section
	 */
	public function account_details_section() {
		$section_id = Critical_Styles_Config::get()->plugin_prefix() . '_account_details';

		add_settings_section(
			$section_id,
			__( 'Account Details', Critical_Styles_Config::get()->plugin_name() ),
			null,
			Critical_Styles_Config::get()->plugin_name()
		);

		add_settings_field(
			Critical_Styles_Config::get()->plugin_prefix() . '_account_details',
			__( 'Email', Critical_Styles_Config::get()->plugin_name() ),
			array( $this, Critical_Styles_Config::get()->plugin_prefix() . '_account_email_cb' ),
			Critical_Styles_Config::get()->plugin_name(),
			$section_id,
		);

		add_settings_field(
			Critical_Styles_Config::get()->plugin_prefix() . '_api_token',
			__( 'Your API key', Critical_Styles_Config::get()->plugin_name() ),
			array( $this, Critical_Styles_Config::get()->plugin_prefix() . '_api_token_cb' ),
			Critical_Styles_Config::get()->plugin_name(),
			$section_id,
			array( 'label_for' => Critical_Styles_Config::get()->plugin_prefix() . '_api_token' )
		);

		register_setting( 'critical-styles', Critical_Styles_Config::get()->plugin_prefix() . '_api_token' );
	}

	public function critical_styles_account_email_cb() {
		echo 'mail@example.com';
	}

	public function critical_styles_api_token_cb() {
		$option_name = Critical_Styles_Config::get()->plugin_prefix() . '_api_token';
		$api_token    = get_option( $option_name );
		?>

		<textarea
			type="text"
			id="<?= $option_name ?>"
			name="<?= $option_name ?>"
			placeholder="<?= __( 'Enter your API key here', Critical_Styles_Config::get()->plugin_name() ) ?>"
			style="width: 80%;"
			rows="3"
		><?= $api_token ?></textarea>

		<?php
	}

	/**
	 * Domains section
	 */
	public function domains_section() {
		$section_id = Critical_Styles_Config::get()->plugin_prefix() . '_domains_section';

		add_settings_section(
			$section_id,
			__( 'Active Domains', Critical_Styles_Config::get()->plugin_name() ),
			array( $this, Critical_Styles_Config::get()->plugin_prefix() . '_domains_header_cb' ),
			Critical_Styles_Config::get()->plugin_name()
		);

		add_settings_field(
			Critical_Styles_Config::get()->plugin_prefix() . '_domains',
			__( 'Domains', Critical_Styles_Config::get()->plugin_name() ),
			array( $this, Critical_Styles_Config::get()->plugin_prefix() . '_domains_cb' ),
			Critical_Styles_Config::get()->plugin_name(),
			$section_id,
		);
	}

	public function critical_styles_domains_header_cb() {
		echo '<p>' . __( 'Your active domains that are billed monthly', Critical_Styles_Config::get()->plugin_name() ) . '</p>';
	}

	public function critical_styles_domains_cb() {
		$domains = array('example.com', 'foo.example.com')
		?>

		<div class="d-flex flex-col">
			<?php foreach ( $domains as $domain ): ?>
				<div style="margin-top: 4px;">
					<?= $domain; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<?php
	}
}
