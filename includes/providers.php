<?php

/** @var \WaSnap\Controller $this */

$action = 'list';
if ( isset( $_GET[ 'action' ] ) )
{
    switch( $_GET[ 'action' ] )
    {
        case 'view':
        case 'edit':
            $action = $_GET[ 'action' ];
    }
}

?>

<div class="wrap">

    <?php if ( $action == 'view' ) { ?>

        <?php

        $id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ? intval( $_GET['id'] ) : 0;
        $provider = new \WaSnap\Provider( $id );

        ?>

        <h1>
            Provider Info
        </h1>

        <?php if ( $provider->getId() === NULL ) { ?>

            <p>
                <a href="admin.php?page=wasnap_providers" class="btn btn-default">
                    Back
                </a>
            </p>

            <div class="alert alert-danger">
                The provider you are trying to view is currently unavailable.
            </div>

        <?php } else { ?>

            <?php

            if ( ! $provider->isApproved() && isset( $_GET['approve'] ) && $_GET['approve'] == 'true' )
            {
                $provider->approve();
            }

            if ( ! $provider->hasApprovalBeenSent() && isset( $_GET['send'] ) && $_GET['send'] == 'true' )
            {
                $provider->sendApproval();
            }

            ?>

            <p>
                <a href="admin.php?page=wasnap_providers" class="btn btn-default">
                    Back
                </a>
                <a href="user-edit.php?user_id=<?php echo $provider->getId(); ?>&wp_http_referer=<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" class="btn btn-default">
                    Edit Provider
                </a>
                <?php if ( ! $provider->isApproved() ) { ?>
                    <a id="approve-provider" href="#" class="btn btn-default" data-id="<?php echo $provider->getId(); ?>">
                        Approve Provider
                    </a>
                <?php } ?>
                <?php if ( $provider->isApproved() && ! $provider->hasApprovalBeenSent() ) { ?>
                    <a id="send-approval-email" href="#" class="btn btn-default" data-id="<?php echo $provider->getId(); ?>">
                        Send Approval Email
                    </a>
                <?php } ?>
            </p>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo $provider->getAgency(); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p>
                                <strong><?php echo $provider->getAgency(); ?></strong><br>
                                <?php echo $provider->getAddressHtml(); ?>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p>
                                <?php echo $provider->getFullName(); ?><br>
                                <a href="mailto:<?php echo $provider->getEmail(); ?>"><?php echo $provider->getEmail(); ?></a><br>
                                <?php echo $provider->getPhone(); ?>
                                <?php if ( strlen( $provider->getUrl() ) > 0 ) { ?>
                                    <br>
                                    <?php echo $provider->getUrl( TRUE ); ?>
                                <?php } ?>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <ul>
                                <li>
                                    <strong>Region:</strong>
                                    <?php echo $provider->getRegion(); ?>
                                </li>
                                <li>
                                    <strong>SNAP-Ed Role:</strong>
                                    <?php echo $provider->getSnapEdRole(); ?>
                                </li>
                                <li>
                                    <strong>Program Focus:</strong>
                                    <?php echo $provider->getProgramFocus(); ?>
                                </li><li>
                                    <strong>DSHS Account:</strong>
                                    <?php if ( $provider->isDshs() ) { ?>
                                        <span class="label label-success">Yes</span>
                                    <?php } else { ?>
                                        <span class="label label-danger">No</span>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <ul>
                                <li>
                                    <strong>Approved:</strong>
                                    <?php if ( $provider->isApproved() ) { ?>
                                        <span class="label label-success">Yes (on <?php echo $provider->getApprovedAt( 'n/j/Y' ); ?>)</span>
                                    <?php } else { ?>
                                        <span class="label label-danger">No</span>
                                    <?php } ?>
                                </li>
                                <li>
                                    <strong>Approval Sent:</strong>
                                    <?php if ( $provider->hasApprovalBeenSent() ) { ?>
                                        <span class="label label-success">Yes (on <?php echo $provider->getApprovalSentAt( 'n/j/Y' ); ?>)</span>
                                    <?php } else { ?>
                                        <span class="label label-danger">No</span>
                                    <?php } ?>
                                </li>
                                <li>
                                    <strong>Profile Privacy:</strong>
                                    <?php if ( $provider->isProfilePrivate() ) { ?>
                                        <span class="label label-danger">Private</span>
                                    <?php } else { ?>
                                        <span class="label label-success">Seen By All</span>
                                    <?php } ?>
                                </li>
                                <li>
                                    <strong>Receives Notifications:</strong>
                                    <?php if ( $provider->receivesNotifications() ) { ?>
                                        <span class="label label-success">Yes</span>
                                    <?php } else { ?>
                                        <span class="label label-danger">No</span>
                                    <?php } ?>
                                </li>
                                <li>
                                    <strong>In Provider Directory:</strong>
                                    <?php if ( $provider->isInProviderDirectory() ) { ?>
                                        <span class="label label-success">Yes</span>
                                    <?php } else { ?>
                                        <span class="label label-danger">No</span>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

    <?php } elseif ( $action == 'edit' ) { ?>

    <?php } else { ?>

        <h1>
            Providers
        </h1>

        <p>
            <a href="user-new.php?role=provider" class="btn btn-default">
                Add a Provider
            </a>
        </p>

        <?php

        $table = new \WaSnap\ProviderTable;
        $table->prepare_items();
        $table->display();

        ?>

    <?php } ?>

</div>