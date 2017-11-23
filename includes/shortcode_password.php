<?php

/** @var \WaSnap\Controller $this */

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

?>

<p>
    Type your username or email address below to reset your password.
    After you press "Get New Password" check your inbox for further instructions.
</p>

<form name="lostpasswordform" id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
    <p>
        <label for="user_login">Username or Email Address<br>
        <input type="text" name="user_login" id="user_login" class="form-control" value="" size="20"></label>
    </p>
    <input type="hidden" name="redirect_to" value="<?php echo $this->getDashboardUrl(); ?>">
    <p class="submit">
        <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Get New Password">
    </p>
</form>

<div id="wasnap-entry-title">Reset Password</div>