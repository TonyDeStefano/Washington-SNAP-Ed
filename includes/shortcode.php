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

<?php if ( $this->shortcode_page->isProtected() ) { ?>

    <?php if ( ! is_user_logged_in() ) { ?>

        <?php if ( $action == 'register' ) { ?>

            <?php include( 'shortcode_register.php' ); ?>

        <?php } else { ?>

            <?php include( 'shortcode_login.php' ); ?>

        <?php } ?>

    <?php } else { ?>

        <?php if ( $this->getProvider()->hasAccess() ) { ?>

            <?php

            if ( $action == 'edit' || $action == 'updated' )
            {
                include( 'shortcode_edit.php' );
            }
            elseif ( $this->isDashboardPage() )
            {
                include( 'shortcode_dashboard.php' );
            }
            elseif ( $this->isDirectoryPage() )
            {
                include( 'shortcode_directory.php' );
            }
            elseif ( $this->isForumPage() )
            {

            }
            else
            {
                echo $this->content;
            }

            ?>

        <?php } else { ?>

            <div class="alert alert-warning">
                Your provider account is not yet approved.
                Please check back later or contact us with any questions.
            </div>

        <?php } ?>

    <?php } ?>

<?php } else { ?>

<?php } ?>
