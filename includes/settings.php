<?php

/** @var \WaSnap\Controller $this */

?>

<div class="wrap">

	<h1>
		Washington State SNAP Education Settings
	</h1>

	<form method="post" action="options.php" autocomplete="off">

		<?php

		settings_fields( 'wasnap_settings' );
		do_settings_sections( 'wasnap_settings' );

		?>

		<table class="form-table">
			<tr>
				<th></th>
				<th>Current Value</th>
				<th>Change To</th>
			</tr>
		</table>

		<?php submit_button(); ?>

	</form>

	<h1>Shortcode</h1>
	<p>
		<strong>
			Add this shortcode to your page:
		</strong>
	</p>

	[wasnap]

</div>