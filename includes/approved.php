<?php

/** @var \WaSnap\Controller $this */

$emails = $this->getApprovedEmails();
sort( $emails );

?>

<div class="wrap">

    <h1>
        Pre-Approved Providers
    </h1>
    <p>Allows you to specify emails that will get automatically approved when they sign up as a provider.</p>

    <form class="well" method="post">

        <?php wp_nonce_field( 'wasnap_add_approved_emails', 'wasnap_nonce' ); ?>
        <input type="hidden" name="wasnap_action" value="add_approved_emails">

        <div class="form-group">
            <label for="emails">Paste Emails to Add:</label>
            <textarea class="form-control" name="emails" id="emails"></textarea>
        </div>

        <button class="btn btn-success">Add Emails</button>

    </form>

    <form method="post">

        <?php wp_nonce_field( 'wasnap_delete_approved_emails', 'wasnap_nonce' ); ?>
        <input type="hidden" name="wasnap_action" value="delete_approved_emails">

        <?php foreach ( $emails as $email ) { ?>
            <input type="checkbox" name="delete[]" value="<?php echo $email; ?>">
            <?php echo $email; ?><br>
        <?php } ?>

        <p>
            <button class="btn btn-danger">Remove Selected Emails</button>
        </p>

    </form>

</div>