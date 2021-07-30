<?php

abstract class Critical_Styles_Base {
	public static function render() {
		$klass = get_called_class();

		$instance = new $klass();
		$instance->run();

		return $instance->view( $instance->template_name() );
	}

	/**
	 * Render a template
	 *
	 * Allows parent/child themes to override the markup by placing the a file named basename( $default_template_path ) in their root folder,
	 * and also allows plugins or themes to override the markup by a filter. Themes might prefer that method if they place their templates
	 * in sub-directories to avoid cluttering the root folder. In both cases, the theme/plugin will have access to the variables so they can
	 * fully customize the output.
	 *
	 * Copied from https://github.com/iandunn/WordPress-Plugin-Skeleton/blob/108aa3ac86494c04be855e660e61f4f693054d0e/classes/wpps-module.php
	 *
	 * @mvc @model
	 *
	 * @param  string $default_template_path The path to the template, relative to the plugin's `admin/views` folder
	 * @param  array  $variables             An array of variables to pass into the template's scope, indexed with the variable name so that it can be extract()-ed
	 * @param  string $require               'once' to use require_once() | 'always' to use require()
	 * @return string
	 */
	protected function view( $default_template_path = false, $variables = array(), $require = 'once' ): string {
		$template_path = locate_template( basename( $default_template_path ) );

		if ( ! $template_path ) {
			$template_path = dirname( __DIR__ ) . '/admin/views/' . $default_template_path;
		}

		if ( ! is_file( $template_path ) ) return '';

		extract( $variables );

		/**
		 * Using buffer gives the caller more control
		 * over what to do with the return value.
		 */
		ob_start();

		if ( 'always' == $require ) {
			require( $template_path );
		} else {
			require_once( $template_path );
		}

		return ob_get_clean();
	}

	abstract public function run();
	abstract public function template_name(): string;
}
