<!--<pre>-->
<!--	--><?php
//
////	print_r($webpages);
//
//	?>
<!--</pre>-->

<table>
	<thead>
		<th
			class="text-left"
		>
			Status
		</th>

		<th
			class="text-left"
		>
			ID
		</th>

		<th
			class="text-left"
		>
			Page ID
		</th>

		<th
			class="text-left"
		>
			Path
		</th>

		<th
			class="text-left"
		>
			CSS
		</th>

		<th
			class="text-left"
		>
			Actions
		</th>
	</thead>

	<tbody>
		<?php foreach ($webpages as $webpage): ?>
			<tr>
				<th
					class="text-left"
				>
					<?= $webpage->job_status ?>
				</th>

				<th
					class="text-left"
				>
					<?= $webpage->id ?>
				</th>

				<th
					class="text-left"
				>
					<? $webpage->criticalCss() ?>
					<?= $webpage->page_id ?>
				</th>

				<th
					class="text-left"
				>
					<?= $webpage->path ?>
				</th>

				<th
					class="text-left"
				>
					<a
						href="<?= $webpage->critical_css_url ?>"
						target="_blank"
						style="
							width: 200px;
							display: block;
							text-overflow: ellipsis;
							overflow: hidden;
							white-space: nowrap;
						"
					>
						<?= $webpage->critical_css_filename ?>
					</a>
				</th>

				<th>
					<button>refresh</button>
					<button>remove</button>
				</th>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>