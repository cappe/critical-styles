<h1>
	Admin layout
</h1>

<!-- Our admin page content should all be inside .wrap -->
<div class="wrap">
	<!-- Print the page title -->
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<!-- Here are our tabs -->
	<nav class="nav-tab-wrapper">
		<a
			href="?page=<?= $plugin_name ?>&tab=your-pages"
			class="nav-tab <?php if ( $current_tab === null || $current_tab === 'your-pages' ): ?>nav-tab-active<?php endif; ?>"
		>Your Pages</a>
		<a
			href="?page=<?= $plugin_name ?>&tab=account"
			class="nav-tab <?php if ( $current_tab === 'account' ): ?>nav-tab-active<?php endif; ?>"
		>Account</a>
	</nav>

	<div class="tab-content">
		<?= $html ?>
	</div>
</div>
