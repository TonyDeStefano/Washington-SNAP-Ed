<?php

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

/** @var $action */

?>

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
            <input type="file" name="file" id="file" style="line-height: 1 !important;">
        </div>

        <button class="btn btn-default">
            Upload
        </button>

    </form>

<?php } ?>