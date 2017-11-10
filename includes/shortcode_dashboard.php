<?php

/** @var \WaSnap\Controller $this */

echo $this->content;
include( 'shortcode_forum.php' );

?>

<?php if ( ! isset( $_GET['page'] ) || $_GET['page'] != 'forum' ) { ?>

    <?php

    $dshs_messages = array();

    $query = new \WP_Query( array(
        'post_type' => 'wasnap_dshs_message',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => array( 'ID' => 'DESC' )
    ) );

    if( $query->have_posts() )
    {
        while ( $query->have_posts() ) : $query->the_post();
            $dshs_messages[ get_the_ID() ] = array(
                'id' => get_the_ID(),
                'content' => get_the_content(),
                'date' => get_the_date( 'n/j/Y' )
            );
        endwhile;
    }

    $snap_messages = array();

    $query = new \WP_Query( array(
        'post_type' => 'wasnap_message',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => array( 'ID' => 'DESC' )
    ) );

    if( $query->have_posts() )
    {
        while ( $query->have_posts() ) : $query->the_post();
            $snap_messages[ get_the_ID() ] = array(
                'id' => get_the_ID(),
                'content' => get_the_content(),
                'date' => get_the_date( 'n/j/Y' )
            );
        endwhile;
    }

    ?>

    <h3<?php if ( ! $this->getProvider()->canAdminDshsMessages() ) { ?> style="display:none;"<?php } ?> class="dshs-messages">Messages from DSHS</h3>

    <?php if ( $this->getProvider()->canAdminDshsMessages() ) { ?>

        <p>
            <a href="#" id="add-dshs-message" class="btn btn-default">
                Add a Message
            </a>
        </p>

        <script>

            (function($){

                $(function(){

                    $('#add-dshs-message').click(function(e){
                        e.preventDefault();
                        if ( ! $('#dshs-message-new').length ){
                            $('#dshs-messages').prepend('' +
                                '<div class="well dshs-message" id="dshs-message-new" data-id="new">' +
                                '<textarea class="form-control"></textarea><br>' +
                                '<a href="#" class="btn btn-success dshs-button-save">Save</a> ' +
                                '<a href="#" class="btn btn-danger dshs-button-delete">Delete</a>' +
                                '</div>');
                        }
                    });

                    var body_el = $('body');

                    body_el.on('click', '.dshs-button-delete', function(e){
                        e.preventDefault();
                        var id = $(this).closest('.dshs-message').data('id');
                        if ( id === 'new' ){
                            $('#dshs-message-new').remove();
                        } else {
                            var b = confirm('Are you sure you want to delete this message?');
                            if ( b ) {
                                $.ajax({
                                    url: wasnap.ajaxurl,
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data: {
                                        action: 'wasnap_dshs_message_delete',
                                        id: id
                                    },
                                    error: function(){
                                        alert('There was an error. Please try again.');
                                    },
                                    success: function(json){
                                        $('#dshs-message-'+json.id).remove();
                                    }
                                });
                            }
                        }
                    });

                    body_el.on('click', '.dshs-button-edit', function(e){
                        e.preventDefault();
                        $(this).hide();
                        var message = $(this).closest('.dshs-message').find('.content').text().trim();
                        $(this).closest('.dshs-message').find('.content').html('' +
                            '<textarea class="form-control">' + message + '</textarea><br>' +
                            '<a href="#" class="btn btn-success dshs-button-save">Save</a> ' +
                            '<a href="#" class="btn btn-danger dshs-button-delete">Delete</a>')
                    });

                    body_el.on('click', '.dshs-button-save', function(e){
                        e.preventDefault();
                        var id = $(this).closest('.dshs-message').data('id');
                        var message = $(this).closest('.dshs-message').find('textarea').val().trim();
                        if ( message.length === 0 ) {
                            alert('Please enter a message.')
                        } else {
                            $.ajax({
                                url: wasnap.ajaxurl,
                                type: 'POST',
                                dataType: 'JSON',
                                data: {
                                    action: 'wasnap_dshs_message_save',
                                    id: id,
                                    message: message
                                },
                                error: function(){
                                    alert('There was an error. Please try again.');
                                },
                                success: function(json){
                                    var messages_el = $('#dshs-messages');
                                    if ( json.id_out === 0 ){
                                        alert('There was an error. Please try again.');
                                    } else if (json.id_in === 'new' ) {
                                        $('#dshs-message-new').remove();
                                        messages_el.prepend('' +
                                            '<div class="well dshs-message" id="dshs-message-'+json.id_out+'" data-id="'+json.id_out+'">' +
                                                '<div class="row">' +
                                                    '<div class="col-sm-2">' + json.date + '</div>' +
                                                    '<div class="col-sm-8">' + json.message + '</div>' +
                                                    '<div class="col-sm-2"><a href="#" class="btn btn-default dshs-button-edit">Edit</a></div>' +
                                                '</div>' +
                                            '</div>');
                                    } else {
                                        var el = $('#dshs-message-'+json.id_out);
                                        el.find('.content').text(json.message);
                                        el.find('.dshs-button-edit').show();
                                    }
                                }
                            });
                        }
                    });
                });

            })(jQuery);

        </script>

    <?php } ?>

    <?php if ( count( $dshs_messages ) > 0 ) { ?>

        <script>

            var dshs_message_count = <?php echo count( $dshs_messages ); ?>;

            (function($){

                $(function(){

                    if ( dshs_message_count > 0 ) {
                        $('h3.dshs-messages').show();
                    }

                });

            })(jQuery);

        </script>

        <div id="dshs-messages">

            <?php foreach ( $dshs_messages as $message ) { ?>
                <div class="well dshs-message" id="dshs-message-<?php echo $message['id']; ?>" data-id="<?php echo $message['id']; ?>">
                    <div class="row">
                        <div class="col-sm-2">
                            <?php echo $message['date']; ?>
                        </div>
                        <div class="content col-sm-<?php if ( $this->getProvider()->canAdminDshsMessages() ) { ?>8<?php } else { ?>10<?php } ?>">
                            <?php echo $message['content']; ?>
                        </div>
                        <?php if ( $this->getProvider()->canAdminDshsMessages() ) { ?>
                            <div class="col-sm-2">
                                <a href="#" class="btn btn-default dshs-button-edit">
                                    Edit
                                </a>
                            </div>
                        <?php } ?>
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
                    <div class="col-sm-2">
                        <?php echo $message['date']; ?>
                    </div>
                    <div class="col-sm-10">
                        <?php echo $message['content']; ?>
                    </div>
                </div>
            <?php } ?>
        </div>

    <?php } ?>

<?php } ?>