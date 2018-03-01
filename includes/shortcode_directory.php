<?php

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

/** @var \WaSnap\Controller $this */

echo $this->content;

$providers = \WaSnap\Provider::getDirectoryProviders();

$agencies = array();
foreach ( $providers as $provider )
{
    if ( ! in_array( $provider->getAgency(), $agencies ) )
    {
        $agencies[] = ucfirst( $provider->getAgency() );
    }
}
natsort( $agencies );

?>

<?php if ( count( $providers ) == 0 ) { ?>

    <div class="alert alert-danger">
        There are no providers listed at this time.
        Please check back later.
    </div>

<?php } else { ?>

    <form class="form-horizontal">
        <div class="form-group">
            <label for="wasnap-search" class="col-sm-2  control-label" style="color:#76bf28;">
                Search
            </label>
            <div class="col-sm-8">
                <input class="form-control" id="wasnap-search">
            </div>
            <div class="col-sm-2">
                <a href="#" class="btn btn-danger" id="wasnap-search-clear">
                    Clear
                </a>
            </div>
        </div>
        <div class="form-group">
            <label for="wasnap-region" class="col-sm-2  control-label" style="color:#76bf28;">
                Region
            </label>
            <div class="col-sm-8">
                <select class="form-control" id="wasnap-region">
                    <option value="">All Regions</option>
                    <?php foreach ( $this->getRegions() as $region ) { ?>
                        <option value="<?php echo $region; ?>">
                            <?php echo $region; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="wasnap-agency" class="col-sm-2  control-label" style="color:#76bf28;">
                Agency
            </label>
            <div class="col-sm-8">
                <select class="form-control" id="wasnap-agency">
                    <option value="">All Agencies</option>
                    <?php foreach ( $agencies as $agency ) { ?>
                        <option value="<?php echo $agency; ?>">
                            <?php echo $agency; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </form>

<?php } ?>

<?php foreach ( $providers as $provider ) { ?>

    <div
        class="well wasnap-provider"
        data-region="<?php echo $provider->getRegion(); ?>"
        data-agency="<?php echo ucfirst( $provider->getAgency() ); ?>"
        style="background-color: #fff;">
        <div class="row wasnap-toggle-more" data-state="closed">
            <div class="col-md-11">
				<h5 style="color:#147891">
                    <i class="fa fa-address-book-o"></i>
                    <?php echo $provider->getLastName(); ?>, <?php echo $provider->getFirstName(); ?>
                </h5>
			</div>
			<div class="col-md-1">
                <i class="fa fa-chevron-down"></i>
            </div>
        </div>
        <div class="wasnap-more">
            <div class="row">
                <div class="col-md-5">
                    <p class="wasnap-search">
                        <?php echo $provider->getAddressHtml(); ?><br>
                        <?php echo $provider->getPhone(); ?>
                    </p>
                </div>
                <div class="col-md-6" style="border: 1px solid #76bf28;">
                    <p class="wasnap-search">
                        <?php if ( ! $provider->isProfilePrivate() ) { ?>
                            <h5 style="color:#147891"><strong><?php echo $provider->getAgency(); ?></strong></h5><br>
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
    </div>

<?php } ?>
