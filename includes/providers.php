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

            ?>



            <p>
                <a href="admin.php?page=wasnap_providers" class="btn btn-default">
                    Back
                </a>
                <a href="/wp-admin/user-edit.php?user_id=<?php echo $provider->getId(); ?>&wp_http_referer=<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" class="btn btn-default">
                    Edit Provider
                </a>
                <?php if ( ! $provider->isApproved() ) { ?>
                    <a id="approve-provider" href="#" class="btn btn-default" data-id="<?php echo $provider->getId(); ?>">
                        Approve Provider
                    </a>
                <?php } ?>
            </p>

            <p>
                <strong><?php echo $provider->getAgency(); ?></strong><br>
                <?php echo $provider->getAddressHtml(); ?>
            </p>
            <p>
                <?php echo $provider->getFullName(); ?><br>
                <a href="mailto:<?php echo $provider->getEmail(); ?>"><?php echo $provider->getEmail(); ?></a><br>
                <?php echo $provider->getPhone(); ?>
                <?php if ( strlen( $provider->getUrl() ) > 0 ) { ?>
                    <br>
                    <?php echo $provider->getUrl( TRUE ); ?>
                <?php } ?>
            </p>
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

        <?php } ?>

    <?php } elseif ( $action == 'edit' ) { ?>

    <?php } else { ?>

        <h1>
            Providers
        </h1>

        <?php

        $table = new \WaSnap\ProviderTable;
        $table->prepare_items();
        $table->display();

        ?>

    <?php } ?>

</div>