<?php

/** @var \WaSnap\Controller $this */

echo $this->content;

$providers = \WaSnap\Provider::getDirectoryProviders();

?>

<?php if ( count( $providers ) == 0 ) { ?>

    <div class="alert alert-danger">
        There are no providers listed at this time.
        Please check back later.
    </div>

<?php } else { ?>

    <form class="form-horizontal">
        <div class="form-group">
            <label for="wasnap-search" class="col-sm-2 control-label">Search</label>
            <div class="col-sm-8">
                <input class="form-control" id="wasnap-search">
            </div>
            <div class="col-sm-2">
                <a href="#" class="btn btn-default" id="wasnap-search-clear">
                    Clear
                </a>
            </div>
        </div>
    </form>

<?php } ?>

<?php foreach ( $providers as $provider ) { ?>

    <div class="well wasnap-provider">
        <div class="row">
            <div class="col-md-6">
                <p class="wasnap-search">
                    <strong><?php echo $provider->getAgency(); ?></strong><br>
                    <?php echo $provider->getAddressHtml(); ?><br>
                    <?php echo $provider->getPhone(); ?>
                </p>
            </div>
            <div class="col-md-6">
                <p class="wasnap-search">
                    <?php if ( ! $provider->isProfilePrivate() ) { ?>
                        <?php echo $provider->getFullName(); ?><br>
                        <a href="mailto:<?php echo $provider->getEmail(); ?>"><?php echo $provider->getEmail(); ?></a>
                    <?php } ?>
                    <?php if ( strlen( $provider->getUrl() ) > 0 ) { ?>
                        <br>
                        <?php echo $provider->getUrl( TRUE ); ?>
                    <?php } ?>
                    <br>
                    <strong>Region:</strong>
                    <?php echo $provider->getRegion(); ?>
                    <br>
                    <strong>SNAP-Ed Role:</strong>
                    <?php echo $provider->getSnapEdRole(); ?>
                </p>
            </div>
        </div>
        <?php if ( strlen ( $provider->getProgramFocus() ) > 0 ) { ?>
        <div class="row">
            <div class="col-md-12">
                <p>
                    <strong>Program Focus:</strong>
                    <span class="wasnap-search"><?php echo $provider->getProgramFocus(); ?></span>
                </p>
            </div>
        </div>
        <?php } ?>
    </div>

<?php } ?>
