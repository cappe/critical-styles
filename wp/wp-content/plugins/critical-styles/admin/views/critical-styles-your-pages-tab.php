<table>
	<thead>
		<th>
			Path
		</th>

		<th>
			Actions
		</th>
	</thead>

	<tbody>
		<?php foreach ($webpages as $webpage): ?>
			<tr>
				<th
					class="text-left"
				>
					<?= $webpage->path ?>
				</th>

				<th>
					<button>refresh</button>
					<button>remove</button>
				</th>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>