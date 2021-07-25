<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.linkedin.com/in/kasperi-keski-loppi-637935142
 * @since      1.0.0
 *
 * @package    Critical_Styles
 * @subpackage Critical_Styles/admin/partials
 */

//Get the active tab from the $_GET param
$default_tab = 'settings';
$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
?>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<nav class="nav-tab-wrapper">
		<a href="?page=critical-styles&tab=settings" class="nav-tab <?php if($tab==='settings'):?>nav-tab-active<?php endif; ?>">Settings</a>
		<a href="?page=critical-styles&tab=setup" class="nav-tab <?php if($tab==='setup'):?>nav-tab-active<?php endif; ?>">Setup</a>
	</nav>

	<div class="tab-content">
		<?php switch($tab) :
			case 'setup':
				include_once 'critical-styles-setup-display.php';
				break;
			case 'settings':
			default:
				echo 'Settings';
				break;
		endswitch; ?>
	</div>
</div>
