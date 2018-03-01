<?php

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

/**
 * @var \WaSnap\Controller $this
 * @var $action
 */

?>

<?php if ( $action == 'updated' ) { ?>

    <div class="alert alert-success" style="color:#76bf28;">
        Your information has been updated!
    </div>

    <p>
        <a href="<?php echo $this->getDashboardUrl(); ?>" class="btn btn-default">
            Return to Dashboard
        </a>
    </p>

    <div id="wasnap-entry-title">Success!</div>

<?php } else { ?>

    <?php if ( isset( $_GET['password'] ) && $_GET['password'] == 'reset' ) { ?>

        <p>Enter your current password and new password twice below:</p>

        <form method="post">

            <?php wp_nonce_field( 'wasnap_password', 'wasnap_nonce' ); ?>
            <input type="hidden" name="wasnap_action" value="password">

            <div class="form-group">
                <label for="password" style="color:#76bf28;">Current Password</label>
                <input class="form-control" id="password" name="password" type="password">
            </div>

            <div class="form-group">
                <label for="password1" style="color:#76bf28;">New Password</label>
                <input class="form-control" id="password1" name="password1" type="password">
            </div>

            <div class="form-group">
                <label for="password2" style="color:#76bf28;">Re-Enter New Password</label>
                <input class="form-control" id="password2" name="password2" type="password">
            </div>

            <p>
                <button class="btn btn-default" style="background-color:#147891; color:#fff;text-align: center;">
                    Change Password
                </button>  <a href="<?php echo $this->getDashboardUrl(); ?>" class="btn btn-danger">
                    Cancel
                </a>
            </p>

        </form>

        <div id="wasnap-entry-title">Change Password</div>

    <?php } else { ?>

        <p>
			Update your account information below. If you wish to update your password, please <a href="<?php echo $this->add_to_querystring( array( 'password' => 'reset' ) ); ?>"><strong><em>click here</em></strong></a>.
        </p>

        <form method="post" class="form-horizontal">

            <?php wp_nonce_field( 'wasnap_edit', 'wasnap_nonce' ); ?>
            <input type="hidden" name="wasnap_action" value="edit">

            <div class="form-group required" >
                <label for="email" class="col-sm-2 control-label" style="color:#76bf28;">
                    Email *</label>
                <div class="col-sm-10">
                    <input class="form-control" type="email" id="email" name="email" value="<?php echo ( isset( $_POST['email'] ) ) ? esc_html( $_POST['email'] ) : esc_html( $this->getProvider()->getEmail() ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="agency" class="col-sm-2 control-label" style="color:#76bf28;">
                    Agency*</label>
                
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="agency" name="agency" value="<?php echo ( isset( $_POST['agency'] ) ) ? esc_html( $_POST['agency'] ) : esc_html( $this->getProvider()->getAgency() ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="fname" class="col-sm-2 control-label" style="color:#76bf28;">First Name *</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="fname" name="fname" value="<?php echo ( isset( $_POST['fname'] ) ) ? esc_html( $_POST['fname'] ) : esc_html( $this->getProvider()->getFirstName() ); ?>">
                </div>
				
				<label for="lname" class="col-sm-2 control-label" style="color:#76bf28;">Last Name *</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="lname" name="lname" value="<?php echo ( isset( $_POST['lname'] ) ) ? esc_html( $_POST['lname'] ) : esc_html( $this->getProvider()->getLastName() ); ?>">
                </div>
            </div>

            
			
			
			<div class="form-group">
                <label for="address" class="col-sm-2 control-label" style="color:#76bf28;">
                    Address
                </label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="address" name="address" value="<?php echo ( isset( $_POST['address'] ) ) ? esc_html( $_POST['address'] ) : esc_html( $this->getProvider()->getAddress() ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="address2" class="col-sm-2 control-label" style="color:#76bf28;">
                    Address 2
                </label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="address2" name="address2" value="<?php echo ( isset( $_POST['address2'] ) ) ? esc_html( $_POST['address2'] ) : esc_html( $this->getProvider()->getAddress2() ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="city" class="col-sm-2 control-label" style="color:#76bf28;">
                    City
                </label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="city" name="city" value="<?php echo ( isset( $_POST['city'] ) ) ? esc_html( $_POST['city'] ) : esc_html( $this->getProvider()->getCity() ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="state" class="col-sm-2 control-label" style="color:#76bf28;">
                    State
                </label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="state" name="state" value="<?php echo ( isset( $_POST['state'] ) ) ? esc_html( $_POST['state'] ) : esc_html( $this->getProvider()->getState() ); ?>">
                </div>
                <label for="zip" class="col-sm-2 control-label" style="color:#76bf28;">
                    Zip Code
                </label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="zip" name="zip" value="<?php echo ( isset( $_POST['zip'] ) ) ? esc_html( $_POST['zip'] ) : esc_html( $this->getProvider()->getZip() ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="phone" class="col-sm-2 control-label" style="color:#76bf28;">
                    Phone
                </label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="phone" name="phone" value="<?php echo ( isset( $_POST['phone'] ) ) ? esc_html( $_POST['phone'] ) : esc_html( $this->getProvider()->getPhone() ); ?>">
                </div>
                <label for="url" class="col-sm-2 control-label" style="color:#76bf28;">
                    Website
                </label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="url" name="url" value="<?php echo ( isset( $_POST['url'] ) ) ? esc_html( $_POST['url'] ) : esc_html( $this->getProvider()->getUrl() ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="region" class="col-sm-2 control-label" style="color:#76bf28;">
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
            </div>
<hr>
            <div class="form-group">
                <label for="snap_ed_role" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <label style="color:#76bf28;">Please check your primary role with SNAP-Ed</label>
                    <?php $temp = ( isset( $_POST['snap_ed_role'] ) ) ? $_POST['snap_ed_role'] : $this->getProvider()->getSnapEdRole(); ?>
                    <?php foreach ( $this->getRoles() as $role ) { ?>
                        <p class="row">
                            <div class="col-sm-1">
                                <input type="radio" name="snap_ed_role" value="<?php echo $role['role']; ?>"<?php if ( $temp == $role['role'] ) { ?> checked<?php } ?>>
                            </div>
                            <div class="col-sm-11">
                                <?php echo $role['role']; ?>
                                <?php if ( isset( $role['mouseover'] ) ) { ?>
                                    <br>
                                    <small><?php echo $role['mouseover']; ?></small>
                                <?php } ?>
                            </div>
                        </p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label for="program_focus" class="col-sm-2 control-label" style="color:#76bf28;">
                    Program Focus
                </label><div class="col-sm-10">
                    <input class="form-control" type="text" id="program_focus" name="program_focus" value="<?php echo ( isset( $_POST['program_focus'] ) ) ? esc_html( $_POST['program_focus'] ) : esc_html( $this->getProvider()->getProgramFocus() ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="audiences" class="col-sm-10 control-label" style="color:#76bf28; text-align: left;">
                    SNAP-eligible Audience Receiving Services
                </label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" id="audiences" name="audiences" value="<?php echo ( isset( $_POST['audiences'] ) ) ? esc_html( $_POST['audiences'] ) : esc_html( $this->getProvider()->getAudiences() ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="sites" class="col-sm-10 control-label" style="color:#76bf28; text-align: left;">
                    Sites Receiving Delivery of SNAP-Ed
                </label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" id="sites" name="sites" value="<?php echo ( isset( $_POST['sites'] ) ) ? esc_html( $_POST['sites'] ) : esc_html( $this->getProvider()->getSites() ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="is_profile_private" class="col-sm-2 control-label" style="color:#76bf28;">
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
                <label for="is_in_provider_directory" class="col-sm-2 control-label" style="color:#76bf28;">In Directory</label>
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
                <div class="col-sm-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input value="1" type="checkbox" name="receives_notifications"<?php if ( $checked ) { ?> checked<?php } ?>>Receive occasional website-related notifications
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 col-sm-10">
                    <p>
                        <button class="btn btn-default" style="background-color:#147891; color:#fff;text-align: center;">
                            Save My Info
                        </button>   <a href="<?php echo $this->getDashboardUrl(); ?>" class="btn btn-danger">
                            Cancel
                        </a>
                    </p>
                </div>
            </div>

        </form>

        <div id="wasnap-entry-title">Edit My Information</div>

    <?php } ?>

<?php } ?>