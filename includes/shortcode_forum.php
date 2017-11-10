<?php

/** @var \WaSnap\Controller $this */

$forum_url = $this->getForumPageUrl();
$actions = array( 'ask', 'answer', 'view' );
$action = ( isset( $_GET['action'] ) && in_array( $_GET['action'], $actions ) ) ? $_GET['action'] : '';
$providers = \WaSnap\Provider::getProviders();

if ( isset( $_GET['delete'] ) && $this->getProvider()->isAdmin() )
{
    $forum_post = new \WaSnap\ForumPost( $_GET['delete'] );
    if ( $forum_post->getId() !== NULL )
    {
        $forum_post->delete();
    }
}

?>

<?php if ( $action == 'ask' ) { ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Ask a Question or Start a Topic
            </h3>
        </div>
        <div class="panel-body">

            <form method="post" class="form">

                <?php wp_nonce_field( 'wasnap_ask', 'wasnap_nonce' ); ?>
                <input type="hidden" name="wasnap_action" value="ask">

                <div class="form-group">
                    <label for="wasnap-title">Question or Topic</label>
                    <input class="form-control" id="wasnap-title" name="title" value="<?php echo $this->param( 'title' ); ?>">
                </div>

                <div class="form-group">
                    <label for="wasnap-content">Additional Information</label>
                    <textarea class="form-control" id="wasnap-content" name="content" style="height: 150px;"><?php echo $this->param( 'content' ); ?></textarea>
                </div>

                <?php if ( $this->getProvider()->isAdmin() ) { ?>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_sticky">
                            Sticky (Stays at the Top)
                        </label>
                    </div>

                <?php } ?>

                <p>
                    <button class="btn btn-default">Submit</button>
                    <a class="btn btn-danger" href="<?php echo $forum_url; ?>">Cancel</a>
                </p>

            </form>

        </div>
    </div>

<?php } elseif ( $action == 'view' && isset( $_GET['id'] ) ) { ?>

    <?php $question = new \WaSnap\Question( $_GET['id'], TRUE ); ?>

    <?php if ( $question->getId() === NULL || $question->getParentId() !== NULL ) { ?>

        <div class="alert alert-danger">
            <p>The question or topic you are looking for is not currently available.</p>
            <p><a href="<?php echo $forum_url; ?>" class="btn btn-default">Back to Forum</a></p>
        </div>

    <?php } else { ?>

        <?php

        if ( count( $question->getAnswers() ) != $question->getChildCount() )
        {
            $question->setChildCount( count( $question->getAnswers() ) )->update();
        }

        ?>

        <p>
            <a class="btn btn-default" href="<?php echo $forum_url; ?>">
                Back to Forum
            </a>
        </p>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo $question->getTitle(); ?>
                </h3>
                <small>
                    Asked by
                    <?php

                    if ( isset( $providers[ $question->getProviderId() ] ) )
                    {
                        $provider = $providers[ $question->getProviderId() ];
                        if ( ! $provider->isProfilePrivate() )
                        {
                            echo '<em>' . $provider->getFullName() . '</em> with ';
                        }

                        echo '<strong>' . $provider->getAgency() . '</strong>';
                    }
                    else
                    {
                        echo 'Admin';
                    }

                    ?>
                    on
                    <?php echo $question->getCreatedAt( 'l, F j, Y' ); ?>
                </small>
            </div>
            <?php if ( strlen( $question->getContent() ) > 0 ) { ?>
                <div class="panel-body">
                    <?php echo $question->getContent(); ?>
                    <?php if ( $this->getProvider()->isAdmin() ) { ?>
                        <div class="text-right" style="margin: 5px 0 0;">
                            <a href="#" class="btn btn-danger btn-xs wasnap-delete-post" data-id="<?php echo $question->getId(); ?>">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <?php if ( count ( $question->getAnswers() ) > 0 ) { ?>

            <table class="table table-bordered" style="margin-top:20px;">

                <?php foreach ( $question->getAnswers() as $answer )  { ?>

                    <tr>
                        <td>
                            <p>
                                <img src="<?php echo get_avatar_url( $answer->getProviderId() ); ?>" class="img-responsive">
                            </p>
                        </td>
                        <td style="width:80%">
                            <p style="margin-bottom:5px;"><?php echo $answer->getContent(); ?></p>
                            <em style="font-size:60%;">
                                <?php

                                if ( isset( $providers[ $answer->getProviderId() ] ) )
                                {
                                    $provider = $providers[ $answer->getProviderId() ];
                                    if ( ! $provider->isProfilePrivate() )
                                    {
                                        echo $provider->getFullName() . ' with ';
                                    }

                                    echo '<strong>' . $provider->getAgency() . '</strong>';
                                }
                                else
                                {
                                    echo 'Admin';
                                }

                                ?>
                                on
                                <?php echo $question->getCreatedAt( 'l, F j, Y' ); ?>
                            </em>
                            <?php if ( $this->getProvider()->isAdmin() ) { ?>
                                <div class="text-right" style="margin: 5px 0 0;">
                                    <a
                                            href="<?php echo $this->add_to_querystring( array( 'action' => 'view', 'id' => $question->getId(), 'delete' => $answer->getId() ), TRUE, $forum_url ); ?>"
                                            class="btn btn-danger btn-xs wasnap-delete-post"
                                            data-id="<?php echo $question->getId(); ?>"
                                    ><i class="fa fa-times"></i></a>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>

                <?php } ?>

            </table>

        <?php } ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Submit a Response
                </h3>
            </div>
            <div class="panel-body">

                <form method="post" class="form">

                    <?php wp_nonce_field( 'wasnap_answer', 'wasnap_nonce' ); ?>
                    <input type="hidden" name="wasnap_action" value="answer">
                    <input type="hidden" name="id" value="<?php echo $question->getId(); ?>">

                    <div class="form-group">
                        <textarea class="form-control" id="wasnap-content" name="content" style="height: 150px;"><?php echo $this->param( 'content' ); ?></textarea>
                    </div>

                    <p>
                        <button class="btn btn-default">Submit</button>
                    </p>

                </form>

            </div>
        </div>


    <?php } ?>

<?php } else { ?>

    <?php

    $page_count = \WaSnap\Question::getPageCount();
    $page = ( isset( $_GET['cur_page'] ) && is_numeric( $_GET['cur_page'] ) ) ? abs( round ( $_GET['cur_page'] ) ) : 1;

    if ( $page == 0 || $page > $page_count )
    {
        $page = 1;
    }

    $questions = \WaSnap\Question::getForumQuestions( $page );
    ?>

    <h3>Provider Forum</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            <p>
                <a href="<?php echo $this->add_to_querystring( [ 'action' => 'ask' ], FALSE, $forum_url ); ?>" class="btn btn-default btn-sm">
                    Ask a Question
                </a>
            </p>
        </div>
        <div class="panel-body">

            <?php if ( count( $questions ) == 0 ) { ?>

                <p>
                    No one has asked a question yet.
                    <a href="<?php echo $this->add_to_querystring( [ 'action' => 'ask' ], FALSE, $forum_url ); ?>">Click here</a> to be the first!
                </p>

            <?php } else { ?>

                <table class="table table-bordered table-striped wasnap-topics">
                    <thead>
                        <tr>
                            <th style="width:70%">Question/Topic</th>
                            <th style="width:20%">Posted By</th>
                            <th class="text-center">Replies</th>
                        </tr>
                    </thead>
                    <?php foreach ( $questions as $question ) { ?>
                        <tr<?php if ( $question->isSticky() ) { ?> class="wasnap-sticky"<?php } ?>>
                            <td class="title">
                                <a href="<?php echo $this->add_to_querystring( [ 'action' => 'view', 'id' => $question->getId() ], FALSE, $forum_url ); ?>"><?php echo $question->getTitle(); ?></a><br>
                                <small>
                                    <?php echo $question->getCreatedAt( 'l, F j, Y' ); ?>
                                </small>
                            </td>
                            <td>
                                <?php

                                if ( isset( $providers[ $question->getProviderId() ] ) )
                                {
                                    $provider = $providers[ $question->getProviderId() ];
                                    if ( ! $provider->isProfilePrivate() )
                                    {
                                        echo '<em>' . $provider->getFullName() . '</em><br>';
                                    }

                                    echo $provider->getAgency();
                                }
                                else
                                {
                                    echo 'Admin';
                                }

                                ?>
                            </td>
                            <td class="text-center">
                                <?php echo $question->getChildCount(); ?>
                                <?php if ( $question->getChildCount() > 0 ) { ?>
                                    <br>
                                    <small>
                                        <?php echo $question->getCreatedAt( 'n/j/Y' ); ?>
                                    </small>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

                <div class="row">
                    <div class="col-sm-3">
                        Page
                        <?php echo $page; ?>
                        of
                        <?php echo $page_count; ?>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div class="btn-group">
                            <?php if ( $page_count > 0 ) { ?>
                                <?php if ( $page > 1 ) { ?>
                                    <a href="<?php echo $this->add_to_querystring( array( 'cur_page' => $page - 1 ), TRUE, $forum_url ); ?>" class="btn btn-default btn-sm">
                                        &laquo;
                                    </a>
                                    <a href="<?php echo $this->add_to_querystring( array( 'cur_page' => 1 ), TRUE, $forum_url ); ?>" class="btn btn-default btn-sm">
                                        1
                                    </a>
                                <?php } ?>
                                <?php if ( $page - 3 > 1 ) { ?>
                                    ...
                                <?php } ?>
                                <?php if ( $page - 2 > 1 ) { ?>
                                    <a href="<?php echo $this->add_to_querystring( array( 'cur_page' => $page - 2 ), TRUE, $forum_url ); ?>" class="btn btn-default btn-sm">
                                        <?php echo $page - 2; ?>
                                    </a>
                                <?php } ?>
                                <?php if ( $page - 1 > 1 ) { ?>
                                    <a href="<?php echo $this->add_to_querystring( array( 'cur_page' => $page - 1 ), TRUE, $forum_url ); ?>" class="btn btn-default btn-sm">
                                        <?php echo $page - 1; ?>
                                    </a>
                                <?php } ?>
                                <a href="<?php echo $this->add_to_querystring( array( 'cur_page' => $page ), TRUE, $forum_url ); ?>" class="btn btn-primary btn-sm">
                                    <?php echo $page; ?>
                                </a>
                                <?php if ( $page + 1 < $page_count ) { ?>
                                    <a href="<?php echo $this->add_to_querystring( array( 'cur_page' => $page + 1 ), TRUE, $forum_url ); ?>" class="btn btn-default btn-sm">
                                        <?php echo $page + 1; ?>
                                    </a>
                                <?php } ?>
                                <?php if ( $page + 2 < $page_count ) { ?>
                                    <a href="<?php echo $this->add_to_querystring( array( 'cur_page' => $page + 2 ), TRUE, $forum_url ); ?>" class="btn btn-default btn-sm">
                                        <?php echo $page + 2; ?>
                                    </a>
                                <?php } ?>
                                <?php if ( $page + 3 < $page_count ) { ?>
                                    ...
                                <?php } ?>
                                <?php if ( $page < $page_count ) { ?>
                                    <a href="<?php echo $this->add_to_querystring( array( 'cur_page' => $page_count ), TRUE, $forum_url ); ?>" class="btn btn-default btn-sm">
                                        <?php echo $page_count; ?>
                                    </a>
                                    <a href="<?php echo $this->add_to_querystring( array( 'cur_page' => $page + 1 ), TRUE, $forum_url ); ?>" class="btn btn-default btn-sm">
                                        &raquo;
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
    </div>

<?php } ?>
