<?php

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

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
                    </label><br>
                    <small>
                        Separate with ~ character<br>
                        Put mouseovers in brackets<br>
                        ex:<br>
                        Educator [teach clients directly]<br>
                        ~<br>
                        Manager [monitor budgets]
                    </small>
                </th>
                <td>
                    <ul>
                        <?php foreach ( $this->getRoles() as $role ) { ?>
                            <li>
                                <strong><?php echo $role['role']; ?></strong>
                                <?php if ( isset( $role['mouseover'] ) ) { ?>
                                    [<?php echo $role['mouseover']; ?>]
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </td>
                <td>
                    <textarea style="width:100%; height: 150px" id="wasnap_roles" name="wasnap_roles"><?php echo $this->getRoles( TRUE ); ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wasnap_focuses">
                        Program Focus
                    </label><br>
                    <small>
                        Separate with ~ character<br>
                        Put mouseovers in brackets<br>
                        ex:<br>
                        Direct Education [face to face]<br>
                        ~<br>
                        Indirect Education [walk by education]
                    </small>
                </th>
                <td>
                    <ul>
                        <?php foreach ( $this->getFocuses() as $focus ) { ?>
                            <li>
                                <strong><?php echo $focus['focus']; ?></strong>
                                <?php if ( isset( $focus['mouseover'] ) ) { ?>
                                    [<?php echo $focus['mouseover']; ?>]
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </td>
                <td>
                    <textarea style="width:100%; height: 150px" id="wasnap_focuses" name="wasnap_focuses"><?php echo $this->getFocuses( TRUE ); ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wasnap_resource_categories">
                        Resource Categories
                    </label>
                </th>
                <td>
                    <?php echo $this->getResourceCategories( TRUE ); ?>
                </td>
                <td>
                    <textarea style="width:100%;" id="wasnap_resource_categories" name="wasnap_resource_categories"><?php echo $this->getResourceCategories( TRUE ); ?></textarea>
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

    <p>Resource Upload Form:</p>
    <blockquote>

        [wasnap section="resource_upload"]

    </blockquote>

    <p>Provider Messages Section:</p>
    <blockquote>

        [wasnap section="messages"]

    </blockquote>

    <p>Provider Dashboard:</p>
    <blockquote>

        [wasnap page="dashboard"]

    </blockquote>

    <p>Provider Manage Profile:</p>
    <blockquote>

        [wasnap page="edit"]

    </blockquote>

    <p>Provider Forum:</p>
    <blockquote>

        [wasnap page="forum"]

    </blockquote>

    <p>Provider Directory:</p>
    <blockquote>

        [wasnap page="directory"]

    </blockquote>

    <p>A password protected page just for providers:</p>
    <blockquote>

        [wasnap]
        <br><br>
        Type your page content here (it will only show up after the provider has logged in).
        <br><br>
        [/wasnap]

    </blockquote>

    <p>If you wrap content in the [wasnap][/wasnap] tags above, you can use these placeholders for dynamic data from the Provider's profile:</p>

    <blockquote>
        - {first_name}<br>
        - {last_name}<br>
        - {full_name}<br>
        - {agency}<br>
        - {email}<br>
        - {phone}<br>
        - {url}<br>
        - {address}<br>
        - {address2}<br>
        - {city}<br>
        - {state}<br>
        - {zip}<br>
        - {html_address}<br>
    </blockquote>

</div>