<?php

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

/** @var \WaSnap\Controller $this */

$json = NULL;

?>

<?php if ( is_user_logged_in() ) { ?>

    <?php

    $tour = get_post( $this->getAttribute( 'tour_id' ) );
    if ( $tour->post_type == 'wasnap_hopscotch' && $tour->post_status == 'publish' )
    {
        $json = $tour->post_content;
    }

    ?>

<?php } ?>

<?php if ( $json !== NULL ) { ?>

    <script>

        jQuery(function(){

            var tour<?php echo $this->getAttribute( 'tour_id' ); ?> = <?php echo $json; ?>;

            <?php if ( ! $this->getProvider()->isAdmin() && ! $this->getProvider()->hasSeenTour( $this->getAttribute( 'tour_id' ) ) ) { ?>

                //startHopscotch<?php echo $this->getAttribute( 'tour_id' ); ?>();

            <?php } ?>

            jQuery('#hopscotch-preview-<?php echo $this->getAttribute( 'tour_id' ); ?>').click(function(e){
                console.log('ggg');
                e.preventDefault();
                startHopscotch<?php echo $this->getAttribute( 'tour_id' ); ?>();
            });

            function startHopscotch<?php echo $this->getAttribute( 'tour_id' ); ?>()
            {
                hopscotch.startTour(tour<?php echo $this->getAttribute( 'tour_id' ); ?>);
            }
        });

    </script>

    <?php if ( $this->getProvider()->isAdmin() ) { ?>

        <p>
            <a href="#" class="btn btn-default" id="hopscotch-preview-<?php echo $this->getAttribute( 'tour_id' ); ?>">
                Preview Tour (Admin Only)
            </a>
        </p>

    <?php } ?>

    <?php $this->getProvider()->addToursSeen( $this->getAttribute( 'tour_id' ) ); ?>

<?php } ?>
