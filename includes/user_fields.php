<?php

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

/** @var \WaSnap\Controller $wasnap_controller */
global $wasnap_controller;

global $user_id;
$provider = new \WaSnap\Provider( $user_id );

?>

<script>

    (function($){

        $(function(){

            if( $('#role').val() === 'provider' ) {
                $('#provider-information').show();
            }

    });

    })(jQuery);

</script>

<?php if ( isset( $_GET['role'] ) && $_GET['role'] == 'provider' ) { ?>

    <script>

        (function($){

            $(function(){

                $('#role').val('provider');
                $('#add-new-user').text('Add a New Provider');
                $('#provider-information').show();

            });

        })(jQuery);

    </script>

<?php } ?>

<?php

if ( $provider->getId() === NULL )
{
    $provider
        ->setIsProfilePrivate( FALSE )
        ->setReceivesNotifications( TRUE )
        ->setIsInProviderDirectory( TRUE )
        ->setIsDshs( FALSE );
}

?>

<?php

$is_approved = 1;

if ( $_POST )
{
    $provider
        ->setAgency( $_POST['agency'] )
        ->setAddress( $_POST['address'] )
        ->setAddress2( $_POST['address2'] )
        ->setCity( $_POST['city'] )
        ->setState( $_POST['state'] )
        ->setZip( $_POST['zip'] )
        ->setPhone( $_POST['phone'] )
        ->setRegion( $_POST['region'] )
        ->setSnapEdRole( $_POST['snap_ed_role'] )
        ->setProgramFocus( $_POST['program_focus'] )
        ->setIsProfilePrivate( $_POST['is_profile_private'] )
        ->setReceivesNotifications( $_POST['receives_notifications'] )
        ->setIsInProviderDirectory( $_POST['is_in_provider_directory'] )
        ->setIsDshs( $_POST['is_dshs'] );

    $is_approved = $_POST['is_approved'];
}

?>

<div id="provider-information">

    <h3>Provider Information</h3>

    <table class="form-table">

        <tr>
            <th><label for="state">Agency Name</label></th>
            <td><input name="agency" id="agency" value="<?php echo esc_html( $provider->getAgency() ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="state">Address</label></th>
            <td><input name="address" id="address" value="<?php echo esc_html( $provider->getAddress() ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <td></td>
            <td><input name="address2" id="address2" value="<?php echo esc_html( $provider->getAddress2() ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="state">City</label></th>
            <td><input name="city" id="city" value="<?php echo esc_html( $provider->getCity() ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="state">State</label></th>
            <td><input name="state" id="state" value="<?php echo esc_html( $provider->getState() ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="state">Zip Code</label></th>
            <td><input name="zip" id="zip" value="<?php echo esc_html( $provider->getZip() ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="phone">Phone</label></th>
            <td><input name="phone" id="phone" value="<?php echo esc_html( $provider->getPhone() ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="region">Region</label></th>
            <td>
                <select name="region" id="region" class="regular-text">
                    <option value="">N/A</option>
                    <?php foreach ( $wasnap_controller->getRegions() as $region ) { ?>
                        <option value="<?php echo esc_html( $region ); ?>" <?php if ( $region == $provider->getRegion() ) { ?>selected<?php } ?>>
                            <?php echo $region; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="snap_ed_role">Snap-Ed Role</label></th>
            <td>
                <select name="snap_ed_role" id="snap_ed_role" class="regular-text">
                    <option value="">N/A</option>
                    <?php foreach ( $wasnap_controller->getRoles() as $role ) { ?>
                        <option value="<?php echo esc_html( $role['role'] ); ?>" <?php if ( $role['role'] == $provider->getSnapEdRole() ) { ?>selected<?php } ?>>
                            <?php echo $role['role']; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="program_focus">Program Focus</label></th>
            <td><input name="program_focus" id="program_focus" value="<?php echo esc_html( $provider->getProgramFocus() ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="audiences">SNAP-eligible Audience Receiving Services</label></th>
            <td><input name="audiences" id="audiences" value="<?php echo esc_html( $provider->getAudiences() ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="sites">Sites Receiving Delivery of SNAP-Ed</label></th>
            <td><input name="sites" id="sites" value="<?php echo esc_html( $provider->getSites() ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="is_profile_private">Privacy</label></th>
            <td>
                <select name="is_profile_private" id="is_profile_private" class="regular-text">
                    <option value="0">
                        Seen By All
                    </option>
                    <option value="1"<?php if ( $provider->isProfilePrivate() ) { ?> selected <?php } ?>>
                        Private
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="receives_notifications">Receives Notifications</label></th>
            <td>
                <select name="receives_notifications" id="receives_notifications" class="regular-text">
                    <option value="1">
                        Yes
                    </option>
                    <option value="0"<?php if ( ! $provider->receivesNotifications() ) { ?> selected <?php } ?>>
                        No
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="is_in_provider_directory">In Directory</label></th>
            <td>
                <select name="is_in_provider_directory" id="is_in_provider_directory" class="regular-text">
                    <option value="1">
                        Yes
                    </option>
                    <option value="0"<?php if ( ! $provider->isInProviderDirectory() ) { ?> selected <?php } ?>>
                        No
                    </option>
                </select>
            </td>
        </tr>
        <?php if ( isset( $_GET['role'] ) && $_GET['role'] == 'provider' ) { ?>
            <tr>
                <th><label for="is_approved">Approved</label></th>
                <td>
                    <select name="is_approved" id="is_approved" class="regular-text">
                        <option value="1">
                            Yes
                        </option>
                        <option value="0"<?php if ( $is_approved == 0 ) { ?> selected<?php } ?>>
                            No
                        </option>
                    </select>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <th><label for="is_dshs">DSHS</label></th>
            <td>
                <select name="is_dshs" id="is_dshs" class="regular-text">
                    <option value="0">
                        This IS NOT the DSHS account
                    </option>
                    <option value="1"<?php if ( $provider->isDshs() ) { ?> selected<?php } ?>>
                        This IS the DSHS account
                    </option>
                </select>
            </td>
        </tr>

    </table>

</div>