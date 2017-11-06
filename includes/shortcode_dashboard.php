<?php

/** @var \WaSnap\Controller $this */

echo $this->content;

$dshs_messages = array();

$query = new \WP_Query( array(
    'post_type' => 'wasnap_dshs_message',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => array( 'title' => 'ASC' )
) );

if( $query->have_posts() )
{
    while ( $query->have_posts() ) : $query->the_post();
        $dshs_messages[ get_the_ID() ] = array(
            'id' => get_the_ID(),
            'content' => get_the_content(),
            'date' => get_the_date()
        );
    endwhile;
}

$snap_messages = array();

$query = new \WP_Query( array(
    'post_type' => 'wasnap_message',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => array( 'title' => 'ASC' )
) );

if( $query->have_posts() )
{
    while ( $query->have_posts() ) : $query->the_post();
        $snap_messages[ get_the_ID() ] = array(
            'id' => get_the_ID(),
            'content' => get_the_content(),
            'date' => get_the_date()
        );
    endwhile;
}

?>

<?php if ( count( $dshs_messages ) > 0 ) { ?>

    <h3>Messages from DSHS</h3>
    <div class="well">
        <?php foreach ( $dshs_messages as $message ) { ?>
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-sm-3">
                    <?php echo $message['date']; ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $message['content']; ?>
                </div>
            </div>
        <?php } ?>
    </div>

<?php } ?>

<?php if ( count( $snap_messages ) > 0 ) { ?>

    <h3>Messages from SNAP-Ed Web Team</h3>
    <div class="well">
        <?php foreach ( $snap_messages as $message ) { ?>
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-sm-3">
                    <?php echo $message['date']; ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $message['content']; ?>
                </div>
            </div>
        <?php } ?>
    </div>

<?php } ?>

