<?php

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

/** @var \WaSnap\Controller $this */

?>

<p>Enter your information below to apply for an account:</p>

<form method="post" class="form-horizontal">

    <?php wp_nonce_field( 'wasnap_register', 'wasnap_nonce' ); ?>
    <input type="hidden" name="wasnap_action" value="register">

    <div class="form-group">
        <label for="username" class="col-sm-2 control-label">
            Username
            <strong>*</strong>
        </label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="username" name="username" value="<?php echo ( isset( $_POST['username'] ) ) ? esc_html( $_POST['username'] ) : ''; ?>">
        </div>
        <label for="username" class="col-sm-2 control-label">
            Password
            <strong>*</strong>
        </label>
        <div class="col-sm-4">
            <input class="form-control" type="password" id="password" name="password" value="<?php echo ( isset( $_POST['password'] ) ) ? esc_html( $_POST['password'] ) : ''; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">
            Email
            <strong>*</strong>
        </label>
        <div class="col-sm-10">
            <input class="form-control" type="email" id="email" name="email" value="<?php echo ( isset( $_POST['email'] ) ) ? esc_html( $_POST['email'] ) : ''; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="agency" class="col-sm-2 control-label">
            Agency
            <strong>*</strong>
        </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" id="agency" name="agency" value="<?php echo ( isset( $_POST['agency'] ) ) ? esc_html( $_POST['agency'] ) : ''; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="fname" class="col-sm-2 control-label">
            First Name
            <strong>*</strong>
        </label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="fname" name="fname" value="<?php echo ( isset( $_POST['fname'] ) ) ? esc_html( $_POST['fname'] ) : ''; ?>">
        </div>
        <label for="lname" class="col-sm-2 control-label">
            Last Name
            <strong>*</strong>
        </label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="lname" name="lname" value="<?php echo ( isset( $_POST['lname'] ) ) ? esc_html( $_POST['lname'] ) : ''; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="address" class="col-sm-2 control-label">
            Address
        </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" id="address" name="address" value="<?php echo ( isset( $_POST['address'] ) ) ? esc_html( $_POST['address'] ) : ''; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="address2" class="col-sm-2 control-label">
            Address 2
        </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" id="address2" name="address2" value="<?php echo ( isset( $_POST['address2'] ) ) ? esc_html( $_POST['address2'] ) : ''; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="city" class="col-sm-2 control-label">
            City
        </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" id="city" name="city" value="<?php echo ( isset( $_POST['city'] ) ) ? esc_html( $_POST['city'] ) : ''; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="state" class="col-sm-2 control-label">
            State
        </label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="state" name="state" value="<?php echo ( isset( $_POST['state'] ) ) ? esc_html( $_POST['state'] ) : ''; ?>">
        </div>
        <label for="zip" class="col-sm-2 control-label">
            Zip Code
        </label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="zip" name="zip" value="<?php echo ( isset( $_POST['zip'] ) ) ? esc_html( $_POST['zip'] ) : ''; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="phone" class="col-sm-2 control-label">
            Phone
        </label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="phone" name="phone" value="<?php echo ( isset( $_POST['phone'] ) ) ? esc_html( $_POST['phone'] ) : ''; ?>">
        </div>
        <label for="url" class="col-sm-2 control-label">
            Website
        </label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="url" name="url" value="<?php echo ( isset( $_POST['url'] ) ) ? esc_html( $_POST['url'] ) : ''; ?>">
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
                <?php $temp = ( isset( $_POST['region'] ) ) ? $_POST['region'] : ''; ?>
                <?php foreach ( $this->getRegions() as $region ) { ?>
                    <option value="<?php echo $region; ?>"<?php if ( $region == $temp) { ?> selected<?php } ?>>
                        <?php echo $region; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="snap_ed_role" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <label>Please check your primary role with SNAP-Ed</label>
            <?php $temp = ( isset( $_POST['snap_ed_role'] ) ) ? $_POST['snap_ed_role'] : $this->getRoles()[0]['role']; ?>
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
        <label for="program_focus" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <label>SNAP-Ed Activities You Deliver (check all that apply)</label>
            <?php

            $focuses = array();
            if ( isset( $_POST['program_focus'] ) )
            {
                $focuses = $_POST['program_focus'];
            }

            ?>
            <?php foreach ( $this->getFocuses() as $focus ) { ?>
                <p class="row">
                    <div class="col-sm-1">
                        <input type="checkbox" name="program_focus[]" value="<?php echo $focus['focus']; ?>"<?php if ( in_array( $focus['focus'], $focuses ) ) { ?> checked<?php } ?>>
                    </div>
                    <div class="col-sm-11">
                        <?php echo $focus['focus']; ?>
                        <?php if ( isset( $focus['mouseover'] ) ) { ?>
                            <br>
                            <small><?php echo $focus['mouseover']; ?></small>
                        <?php } ?>
                    </div>
                </p>
            <?php } ?>
        </div>
    </div>

    <div class="form-group">
        <label for="is_profile_private" class="col-sm-2 control-label">
            Privacy
        </label>
        <div class="col-sm-4">
            <select name="is_profile_private" id="is_profile_private" class="form-control">
                <?php $temp = ( isset( $_POST['is_profile_private'] ) ) ? $_POST['is_profile_private'] : 0; ?>
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
                <?php $temp = ( isset( $_POST['is_in_provider_directory'] ) ) ? $_POST['is_in_provider_directory'] : 1; ?>
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

    $checked = TRUE;
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
            <div class="alert alert-warning">
                All registrations will be subject to approval before access is granted.
            </div>
            <p>
                <button class="btn btn-default">
                    Submit
                </button>
            </p>
        </div>
    </div>

</form>

<div id="wasnap-entry-title">Register</div>