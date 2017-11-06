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
            <tr valign="top">
                <th scope="row">
                    <label for="wasnap_regions">
                        Regions
                    </label>
                </th>
                <td>
                    <?php echo $this->getRegions( TRUE ); ?>
                </td>
                <td>
                    <textarea style="width:100%;" id="wasnap_regions" name="wasnap_regions"><?php echo $this->getRegions( TRUE ); ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wasnap_roles">
                        Snap-Ed Roles
                    </label>
                </th>
                <td>
                    <?php echo $this->getRoles( TRUE ); ?>
                </td>
                <td>
                    <textarea style="width:100%;" id="wasnap_roles" name="wasnap_roles"><?php echo $this->getRoles( TRUE ); ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wasnap_emails">
                        Notification Emails
                    </label>
                </th>
                <td>
                    <?php echo $this->getEmails( TRUE ); ?>
                </td>
                <td>
                    <textarea style="width:100%;" id="wasnap_emails" name="wasnap_emails"><?php echo $this->getEmails( TRUE ); ?></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><?php submit_button(); ?></td>
            </tr>
		</table>

	</form>

	<h1>Shortcodes</h1>
	<p>
		<strong>
			Add these shortcodes to pages where you want this information available.
		</strong>
	</p>

    <p>Main Provider Login and Registration Page:</p>
    <blockquote>

        [wasnap]

    </blockquote>

    <p>Provider Directory:</p>
    <blockquote>

        [wasnap page="directory"]

    </blockquote>

    <p>Provider Forum:</p>
    <blockquote>

        [wasnap page="forum"]

    </blockquote>

</div>