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
                <td valign="top">
                    <?php echo $this->getRegions( TRUE ); ?>
                </td>
                <td valign="top">
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
                <td valign="top">
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
                <td valign="top">
                    <textarea style="width:100%; height: 200px" id="wasnap_roles" name="wasnap_roles"><?php echo $this->getRoles( TRUE ); ?></textarea>
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
                <td valign="top">
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
                <td valign="top">
                    <textarea style="width:100%; height: 200px" id="wasnap_focuses" name="wasnap_focuses"><?php echo $this->getFocuses( TRUE ); ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wasnap_audiences">
                        Audiences Receiving Services
                    </label><br>
                    <small>
                        Separate with ~ character<br>
                        Put mouseovers in brackets<br>
                        ex:<br>
                        Youth, under 5 years<br>
                        ~<br>
                        Special Populations [ESL, refugee, disabled]
                    </small>
                </th>
                <td valign="top">
                    <ul>
                        <?php foreach ( $this->getAudiences() as $audience ) { ?>
                            <li>
                                <strong><?php echo $audience['audience']; ?></strong>
                                <?php if ( isset( $audience['mouseover'] ) ) { ?>
                                    [<?php echo $audience['mouseover']; ?>]
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </td>
                <td valign="top">
                    <textarea style="width:100%; height: 200px" id="wasnap_audiences" name="wasnap_audiences"><?php echo $this->getAudiences( TRUE ); ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wasnap_sites">
                        Sites Receiving Delivery of SNAP-Ed
                    </label><br>
                    <small>
                        Separate with ~ character<br>
                        Put mouseovers in brackets<br>
                        ex:<br>
                        Child Care<br>
                        ~<br>
                        Schools [Example]
                    </small>
                </th>
                <td valign="top">
                    <ul>
                        <?php foreach ( $this->getSites() as $site ) { ?>
                            <li>
                                <strong><?php echo $site['site']; ?></strong>
                                <?php if ( isset( $site['mouseover'] ) ) { ?>
                                    [<?php echo $site['mouseover']; ?>]
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </td>
                <td valign="top">
                    <textarea style="width:100%; height: 200px" id="wasnap_sites" name="wasnap_sites"><?php echo $this->getSites( TRUE ); ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wasnap_resource_categories">
                        Resource Categories
                    </label>
                </th>
                <td valign="top">
                    <?php echo $this->getResourceCategories( TRUE ); ?>
                </td>
                <td valign="top">
                    <textarea style="width:100%;" id="wasnap_resource_categories" name="wasnap_resource_categories"><?php echo $this->getResourceCategories( TRUE ); ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wasnap_emails">
                        Notification Emails
                    </label>
                </th>
                <td valign="top">
                    <?php echo $this->getEmails( TRUE ); ?>
                </td>
                <td valign="top">
                    <textarea style="width:100%;" id="wasnap_emails" name="wasnap_emails"><?php echo $this->getEmails( TRUE ); ?></textarea>
                </td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"><?php submit_button(); ?></td>
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

    <p>Hide the login box:</p>
    <blockquote>

        [wasnap login="hidden"]
        <br><br>
        Your members only content.
        <br><br>
        [/wasnap]

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