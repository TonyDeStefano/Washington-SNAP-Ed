<?php

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

/** @var string $action */

$args = array (
    'echo'           => TRUE,
    'redirect'       => $_SERVER['REQUEST_URI'],
    'form_id'        => 'loginform',
    'label_username' => __( 'Username' ),
    'label_password' => __( 'Password' ),
    'label_remember' => __( 'Remember Me' ),
    'label_log_in'   => __( 'Log In' ),
    'id_username'    => 'user_login',
    'id_password'    => 'user_pass',
    'id_remember'    => 'rememberme',
    'id_submit'      => 'wp-submit',
    'remember'       => TRUE,
    'value_username' => '',
    'value_remember' => FALSE
);

?>

<?php if ( $action == 'registered' ) { ?>

    <div class="alert alert-success">
        Thank you for registering! We will notify you as soon as your account is approved.
    </div>

<?php } else { ?>

    <h2>Provider Login</h2>
    <p>
		Enter your login info to access Provider section and <strong><em>SNAP-Ed March Forum Registration</em></strong>. You must be registered on wasnap-ed.org to gain access. To register on wasnap-ed.org,<a href="<?php echo $this->add_to_querystring( array( 'action' => 'register' ) ); ?>"> <strong>click here</strong></a>.
    </p>

<?php } ?>

<?php wp_login_form( $args ); ?>

<p>
    <a href="<?php echo $this->add_to_querystring( array( 'action' => 'password' ) ); ?>">Lost Password?</a>
</p>

<div id="wasnap-entry-title">Log In or Register</div>