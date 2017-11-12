<?php

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

/** @var \WaSnap\Controller $this */

if ( isset( $_GET['delete'] ) )
{
    $resource = new \WaSnap\ProviderResource( $_GET['delete'] );
    $resource->delete();
}

$providers = \WaSnap\Provider::getProviders();
$resources = \WaSnap\ProviderResource::getAllResources();

?>

<div class="wrap">

    <h1>
        Uploaded Resources
    </h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td>Date</td>
                <td>Provider</td>
                <td>Resource</td>
                <td>Delete</td>
            </tr>
        </thead>
        <?php foreach ( $resources as $resource ) { ?>
            <tr>
                <td><?php echo $resource->getCreatedAt( 'n/j/Y' ); ?></td>
                <td>
                    <?php if ( isset( $providers[ $resource->getProviderId() ] ) ) { ?>
                        <?php $providers[ $resource->getProviderId() ]->getAgency(); ?>
                    <?php } else { ?>
                        Unknown
                    <?php } ?>
                </td>
                <td>
                    <a target="_blank" href="admin.php?wasnap_resource_id=<?php echo $resource->getId(); ?>"><?php echo $resource->getTitle(); ?></a>
                </td>
                <td>
                    <a href="#" class="btn btn-danger delete-wasnap-resource" data-id="<?php echo $resource->getId(); ?>">
                        Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>