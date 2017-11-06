<?php

/** @var \WaSnap\Controller $this */

$action = ( isset( $_GET['action'] ) ) ? $_GET['action'] : '';

?>

<?php if ( count( $this->getErrors() ) > 0 ) { ?>

    <div class="alert alert-danger">
        <p>
            <strong>
                The following error<?php if ( count( $this->getErrors() ) > 1 ) { ?>s<?php } ?> occurred:
            </strong>
        </p>
        <ul style="margin:0; padding-left:30px;">
            <?php foreach ( $this->getErrors() as $error ) { ?>
                <li>
                    <?php echo $error; ?>
                </li>
            <?php } ?>
        </ul>
    </div>

<?php } ?>

<?php if ( ! is_user_logged_in() ) { ?>

    <?php if ( $action == 'register' ) { ?>

        <?php include( 'shortcode_register.php' ); ?>

    <?php } else { ?>

        <?php include( 'shortcode_login.php' ); ?>

    <?php } ?>

<?php } ?>
