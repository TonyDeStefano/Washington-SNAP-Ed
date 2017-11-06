<?php

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

    <h2>Already Registered?</h2>
    <p>
        If you have a login and password, enter them here.<br>
        Otherwise, <a href="<?php echo $this->add_to_querystring( array( 'action' => 'register' ) ); ?>">click here</a> to register.
    </p>

<?php } ?>

<?php wp_login_form( $args ); ?>

<p>
    <a href="/wp-login.php?action=lostpassword">Lost Password?</a>
</p>