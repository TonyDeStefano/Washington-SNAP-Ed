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
<hr>
    <h5 id="upload-resource">Upload New Resource</h5>

    <form method="post" enctype="multipart/form-data" style="border: 1px #76bf28 dotted; width: 90%;">

        <?php wp_nonce_field( 'wasnap_upload', 'wasnap_nonce' ); ?>
        <input type="hidden" name="wasnap_action" value="upload">

        <div class="form-group">
            <label for="wasnap-category" style="color:#76bf28; padding: 5px;">
                Category
            </label>
            <select class="form-control" id="wasnap-category" name="category" style="width: 80%; padding-left: 10px;">
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
            <label for="wasnap-file" style="color:#76bf28;padding: 5px;">
                File
            </label><input type="file" name="file" id="file" style="line-height: 1 !important; " class="btn btn default">
        </div>

        <button class="btn btn-default" style="float: left;color:#76bf28;margin-top: 10px; margin-left: 0px;">
            Upload
        </button>

    </form>

<?php } ?>