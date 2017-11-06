<?php

/**
 * @var \WaSnap\Controller $this
 * @var $action
 */

?>

<?php if ( $action == 'updated' ) { ?>

    <div class="alert alert-success">
        Your information has been updated!
    </div>

<?php } else { ?>

    <p>
        Update your account information below.<br>
        If you wish to update your password, please
        <a href="<?php echo get_site_url( NULL, 'wp-admin/profile.php' ); ?>">click here</a>.
    </p>

    <form method="post" class="form-horizontal">

        <?php wp_nonce_field( 'wasnap_edit', 'wasnap_nonce' ); ?>
        <input type="hidden" name="wasnap_action" value="edit">

        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">
                Email
                <strong>*</strong>
            </label>
            <div class="col-sm-10">
                <input class="form-control" type="email" id="email" name="email" value="<?php echo ( isset( $_POST['email'] ) ) ? esc_html( $_POST['email'] ) : esc_html( $this->getProvider()->getEmail() ); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="agency" class="col-sm-2 control-label">
                Agency
                <strong>*</strong>
            </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="agency" name="agency" value="<?php echo ( isset( $_POST['agency'] ) ) ? esc_html( $_POST['agency'] ) : esc_html( $this->getProvider()->getAgency() ); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="fname" class="col-sm-2 control-label">
                First Name
                <strong>*</strong>
            </label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="fname" name="fname" value="<?php echo ( isset( $_POST['fname'] ) ) ? esc_html( $_POST['fname'] ) : esc_html( $this->getProvider()->getFirstName() ); ?>">
            </div>
            <label for="lname" class="col-sm-2 control-label">
                Last Name
                <strong>*</strong>
            </label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="lname" name="lname" value="<?php echo ( isset( $_POST['lname'] ) ) ? esc_html( $_POST['lname'] ) : esc_html( $this->getProvider()->getLastName() ); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="col-sm-2 control-label">
                Address
            </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="address" name="address" value="<?php echo ( isset( $_POST['address'] ) ) ? esc_html( $_POST['address'] ) : esc_html( $this->getProvider()->getAddress() ); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="address2" class="col-sm-2 control-label">
                Address 2
            </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="address2" name="address2" value="<?php echo ( isset( $_POST['address2'] ) ) ? esc_html( $_POST['address2'] ) : esc_html( $this->getProvider()->getAddress2() ); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="city" class="col-sm-2 control-label">
                City
            </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="city" name="city" value="<?php echo ( isset( $_POST['city'] ) ) ? esc_html( $_POST['city'] ) : esc_html( $this->getProvider()->getCity() ); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="state" class="col-sm-2 control-label">
                State
            </label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="state" name="state" value="<?php echo ( isset( $_POST['state'] ) ) ? esc_html( $_POST['state'] ) : esc_html( $this->getProvider()->getState() ); ?>">
            </div>
            <label for="zip" class="col-sm-2 control-label">
                Zip Code
            </label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="zip" name="zip" value="<?php echo ( isset( $_POST['zip'] ) ) ? esc_html( $_POST['zip'] ) : esc_html( $this->getProvider()->getZip() ); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">
                Phone
            </label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="phone" name="phone" value="<?php echo ( isset( $_POST['phone'] ) ) ? esc_html( $_POST['phone'] ) : esc_html( $this->getProvider()->getPhone() ); ?>">
            </div>
            <label for="url" class="col-sm-2 control-label">
                Website
            </label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="url" name="url" value="<?php echo ( isset( $_POST['url'] ) ) ? esc_html( $_POST['url'] ) : esc_html( $this->getProvider()->getUrl() ); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="region" class="col-sm-2 control-label">
                Region
            </label>
            <div class="col-sm-4">
                <select name="region" id="region" class="form-control">
                    <option value="">
                        Choose One ...
                    </option>
                    <?php $temp = ( isset( $_POST['region'] ) ) ? $_POST['region'] : $this->getProvider()->getRegion(); ?>
                    <?php foreach ( $this->getRegions() as $region ) { ?>
                        <option value="<?php echo $region; ?>"<?php if ( $region == $temp) { ?> selected<?php } ?>>
                            <?php echo $region; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <label for="snap_ed_role" class="col-sm-2 control-label">
                Role
            </label>
            <div class="col-sm-4">
                <select name="snap_ed_role" id="snap_ed_role" class="form-control">
                    <option value="">
                        Choose One ...
                    </option>
                    <?php $temp = ( isset( $_POST['snap_ed_role'] ) ) ? $_POST['snap_ed_role'] : $this->getProvider()->getSnapEdRole(); ?>
                    <?php foreach ( $this->getRoles() as $role ) { ?>
                        <option value="<?php echo $role; ?>"<?php if ( $role == $temp) { ?> selected<?php } ?>>
                            <?php echo $role; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="program_focus" class="col-sm-2 control-label">
                Program Focus
            </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="program_focus" name="program_focus" value="<?php echo ( isset( $_POST['program_focus'] ) ) ? esc_html( $_POST['program_focus'] ) : esc_html( $this->getProvider()->getProgramFocus() ); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="is_profile_private" class="col-sm-2 control-label">
                Privacy
            </label>
            <div class="col-sm-4">
                <select name="is_profile_private" id="is_profile_private" class="form-control">
                    <?php

                    $seed = ( $this->getProvider()->isProfilePrivate() ) ? 1 : 0;
                    $temp = ( isset( $_POST['is_profile_private'] ) ) ? $_POST['is_profile_private'] : $seed;

                    ?>
                    <option value="0"<?php if ( 0 == $temp) { ?> selected<?php } ?>>
                        Seen By All
                    </option>
                    <option value="1"<?php if ( 1 == $temp) { ?> selected<?php } ?>>
                        Private
                    </option>
                </select>
            </div>
            <label for="is_in_provider_directory" class="col-sm-2 control-label">
                In Directory
            </label>
            <div class="col-sm-4">
                <select name="is_in_provider_directory" id="is_in_provider_directory" class="form-control">
                    <?php

                    $seed = ( $this->getProvider()->isInProviderDirectory() ) ? 1 : 0;
                    $temp = ( isset( $_POST['is_in_provider_directory'] ) ) ? $_POST['is_in_provider_directory'] : $seed;

                    ?>
                    <option value="1"<?php if ( 1 == $temp) { ?> selected<?php } ?>>
                        Yes
                    </option>
                    <option value="0"<?php if ( 0 == $temp) { ?> selected<?php } ?>>
                        No
                    </option>
                </select>
            </div>
        </div>

        <?php

        $checked = $this->getProvider()->receivesNotifications();
        if ( isset( $_POST['email'] ) && ! isset( $_POST['receives_notifications'] ) )
        {
            $checked = FALSE;
        }

        ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input value="1" type="checkbox" name="receives_notifications"<?php if ( $checked ) { ?> checked<?php } ?>>
                        Receive occasional website-related notifications
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <p>
                    <button class="btn btn-default">
                        Update My Profile
                    </button>
                </p>
            </div>
        </div>

    </form>

<?php } ?>

<div id="wasnap-entry-title">Edit My Information</div>