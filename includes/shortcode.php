<?php

/** @var \WaSnap\Controller $this */

$action = ( isset( $_GET['action'] ) ) ? $_GET['action'] : '';

?>

<?php if ( $this->getAttribute( 'section' ) == 'resource_upload' ) { ?>

    <?php if ( is_user_logged_in() ) { ?>

        <?php if ( $action == 'uploaded' ) { ?>

            <div class="alert alert-success">
                Your file has been uploaded
            </div>

        <?php } ?>

        <form method="post" enctype="multipart/form-data">

            <?php wp_nonce_field( 'wasnap_upload', 'wasnap_nonce' ); ?>
            <input type="hidden" name="wasnap_action" value="upload">

            <div class="form-group">
                <label for="wasnap-category">
                    Category
                </label>
                <select class="form-control" id="wasnap-category" name="category">
                    <option value="">
                        Choose One ...
                    </option>
                    <?php foreach ( $this->getResourceCategories() as $category ) { ?>
                        <option value="<?php echo $category; ?>">
                            <?php echo $category; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="wasnap-file">
                    File
                </label>
                <input type="file" name="file" id="file" class="form-control">
            </div>

            <button class="btn btn-default">
                Upload
            </button>

        </form>

    <?php } ?>

<?php } else { ?>

    <div id="wasnap">

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

                    if ( $this->isEditPage() )
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
                        include( 'shortcode_forum.php' );
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

    </div>

<?php } ?>
