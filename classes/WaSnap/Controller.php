<?php

namespace WaSnap;

class Controller {
	
	const VERSION = '0.0.1';
	const VERSION_JS = '0.0.15';
	const VERSION_CSS = '0.0.8';

	private $errors;
	private $content;
	private $attributes = array();

	/** @var Provider $provider */
	private $provider;

	/** @var Page $shortcode_page */
	private $shortcode_page;

	/** @var Page[] $shortcode_pages */
    private $shortcode_pages;

    /**
     * @return Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param Provider $provider
     *
     * @return Controller
     */
    public function setProvider( $provider )
    {
        $this->provider = $provider;

        return $this;
    }

    public function add_post_types()
    {
        /* SNAP-Ed Messages */

        $labels = array (
            'name' => __( 'SNAP-Ed Messages' ),
            'singular_name' => __( 'SNAP-Ed Message' ),
            'add_new_item' => __( 'Add New SNAP-Ed Message' ),
            'edit_item' => __( 'Edit SNAP-Ed Message' ),
            'new_item' => __( 'New SNAP-Ed Message' ),
            'view_item' => __( 'View SNAP-Ed Message' ),
            'search_items' => __( 'Search SNAP-Ed Messages' ),
            'not_found' => __( 'No SNAP-Ed Messages found.' )
        );

        $args = array (
            'labels' => $labels,
            'hierarchical' => FALSE,
            'description' => 'SNAP-Ed Messages',
            'supports' => array('title', 'editor'),
            'public' => TRUE,
            'show_ui' => TRUE,
            'show_in_menu' => 'wasnap',
            'menu_position' => NULL,
            'show_in_nav_menus' => TRUE,
            'publicly_queryable' => TRUE,
            'exclude_from_search' => FALSE,
            'has_archive' => TRUE,
        );

        register_post_type('wasnap_message', $args);

        /* DSHS Messages */

        $labels = array (
            'name' => __( 'DSHS Messages' ),
            'singular_name' => __( 'DSHS Message' ),
            'add_new_item' => __( 'Add New DSHS Message' ),
            'edit_item' => __( 'Edit DSHS Message' ),
            'new_item' => __( 'New DSHS Message' ),
            'view_item' => __( 'View DSHS Message' ),
            'search_items' => __( 'Search DSHS Messages' ),
            'not_found' => __( 'No DSHS Messages found.' )
        );

        $args = array (
            'labels' => $labels,
            'hierarchical' => FALSE,
            'description' => 'DSHS Messages',
            'supports' => array('title', 'editor'),
            'public' => TRUE,
            'show_ui' => TRUE,
            'show_in_menu' => 'wasnap',
            'menu_position' => NULL,
            'show_in_nav_menus' => TRUE,
            'publicly_queryable' => TRUE,
            'exclude_from_search' => FALSE,
            'has_archive' => TRUE
        );

        register_post_type('wasnap_dshs_message', $args);

        /* Hopscotch Tours */

        $labels = array (
            'name' => __( 'Hopscotch Tours' ),
            'singular_name' => __( 'Hopscotch Tour' ),
            'add_new_item' => __( 'Add New Hopscotch Tour' ),
            'edit_item' => __( 'Edit Hopscotch Tour' ),
            'new_item' => __( 'New Hopscotch Tour' ),
            'view_item' => __( 'View Hopscotch Tour' ),
            'search_items' => __( 'Search Hopscotch Tours' ),
            'not_found' => __( 'No Hopscotch Tours found.' )
        );

        $args = array (
            'labels' => $labels,
            'hierarchical' => FALSE,
            'description' => 'Hopscotch Tours',
            'supports' => array('title', 'editor'),
            'public' => TRUE,
            'show_ui' => TRUE,
            'show_in_menu' => 'wasnap',
            'menu_position' => NULL,
            'show_in_nav_menus' => TRUE,
            'publicly_queryable' => TRUE,
            'exclude_from_search' => FALSE,
            'has_archive' => TRUE
        );

        register_post_type('wasnap_hopscotch', $args);
    }

    /**
	 * @return mixed
	 */
	public function getErrors()
	{
		return ( $this->errors === NULL ) ? array() : $this->errors;
	}

	/**
	 * @param $error
	 *
	 * @return $this
	 */
	public function addError( $error )
	{
		if( $this->errors === NULL )
		{
			$this->errors = array();
		}
		
		$this->errors[] = $error;
		return $this;
	}

	public function activate()
	{
        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

	    /** @var \wpdb $wpdb */
	    global $wpdb;

        $charset_collate = '';
        if ( ! empty( $wpdb->charset ) )
        {
            $charset_collate .= " DEFAULT CHARACTER SET " . $wpdb->charset;
        }
        if ( ! empty( $wpdb->collate ) )
        {
            $charset_collate .= " COLLATE " . $wpdb->collate;
        }

        $table = $wpdb->prefix . ForumPost::TABLE_NAME;
        $sql = "CREATE TABLE " . $table . " (
					id INT(11) NOT NULL AUTO_INCREMENT,
					parent_id INT(11) DEFAULT NULL,
					child_count INT(11) DEFAULT 0,
					provider_id INT(11) DEFAULT NULL,
					title VARCHAR(255) DEFAULT NULL,
					content TEXT DEFAULT NULL,
					is_sticky TINYINT(4) DEFAULT 0,
					is_archived TINYINT(4) DEFAULT 0,
					created_at DATETIME DEFAULT NULL,
					updated_at DATETIME DEFAULT NULL,
					PRIMARY KEY  (id),
					KEY parent_id (parent_id),
					KEY provider_id (provider_id)
				)";
        $sql .= $charset_collate . ";";
        dbDelta( $sql );

        $table = $wpdb->prefix . ProviderResource::TABLE_NAME;
        $sql = "CREATE TABLE " . $table . " (
					id INT(11) NOT NULL AUTO_INCREMENT,
					provider_id INT(11) DEFAULT NULL,
					category VARCHAR(255) DEFAULT NULL,
					location VARCHAR(255) DEFAULT NULL,
					title VARCHAR(255) DEFAULT NULL,
					created_at DATETIME DEFAULT NULL,
					PRIMARY KEY  (id)
				)";
        $sql .= $charset_collate . ";";
        dbDelta( $sql );
	}

	public function init()
	{
		wp_enqueue_media();
		add_thickbox();
		wp_enqueue_style( 'wasnap-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), ( WP_DEBUG ) ? time() : self::VERSION_JS, TRUE );
		wp_enqueue_style( 'wasnap-bootstrap-css', plugin_dir_url( dirname( __DIR__ ) ) . 'css/bootstrap.css', array(), ( WP_DEBUG ) ? time() : self::VERSION_CSS );
		wp_enqueue_style( 'wasnap-css', plugin_dir_url( dirname( __DIR__ ) ) . 'css/wasnap.css', array(), ( WP_DEBUG ) ? time() : self::VERSION_CSS );
        wp_enqueue_style( 'wasnap-hopscotch-css', plugin_dir_url( dirname( __DIR__ ) ) . 'css/hopscotch-0.2.6.min.css', array(), ( WP_DEBUG ) ? time() : self::VERSION_CSS );

        wp_enqueue_script( 'wasnap-js', plugin_dir_url( dirname( __DIR__ )  ) . 'js/wasnap.js', array( 'jquery' ), ( WP_DEBUG ) ? time() : self::VERSION_JS, TRUE );
		wp_localize_script(
		    'wasnap-js',
            'wasnap',
            array(
                'ajaxurl' => admin_url( 'admin-ajax.php' )
            )
        );
        wp_enqueue_script( 'wasnap-hopscotch-js', plugin_dir_url( dirname( __DIR__ )  ) . 'js/hopscotch-0.2.6.min.js', array( 'jquery' ), ( WP_DEBUG ) ? time() : self::VERSION_JS, TRUE );


        if ( $this->provider === NULL )
        {
            $this->provider = Provider::load_from_user();
        }
	}

	public function add_role()
    {
        add_role(
            'provider',
            __( 'Provider' ),
            array(
                'read' => TRUE,
                'edit_posts' => FALSE,
                'delete_posts' => FALSE
            )
        );
    }

    /**
     * @param $key
     * @param string $default
     *
     * @return string
     */
    public function param( $key, $default = '' )
    {
        if ( isset( $_POST[ $key ] ) )
        {
            return htmlspecialchars( $_POST[ $key ] );
        }
        elseif ( isset( $_GET[ $key ] ) )
        {
            return htmlspecialchars( $_GET[ $key ] );
        }

        return htmlspecialchars( $default );
    }

    public function download()
    {
        if ( isset( $_GET['wasnap_resource_id'] ) )
        {
            $resource = new ProviderResource( $_GET['wasnap_resource_id'] );

            if ( $resource->getId() === NULL )
            {
                echo 'Resource could not be downloaded.';
            }
            else
            {
                $resource->download();
            }

            die();
        }
    }
	
	public function form_capture()
	{
	    if ( isset( $_POST['wasnap_action'] ) )
		{
			if ( isset( $_POST['wasnap_nonce'] ) && wp_verify_nonce( $_POST['wasnap_nonce'], 'wasnap_' . $_POST['wasnap_action'] ) )
			{
				switch ( $_POST['wasnap_action'] )
                {
                    case 'password':

                        $user = get_user_by( 'ID', $this->getProvider()->getId() );
                        $password = $_POST['password'];
                        $password1 = $_POST['password1'];
                        $password2 = $_POST['password2'];

                        if ( ! wp_check_password( $password, $user->data->user_pass, $user->ID ) )
                        {
                            $this->addError( 'The current password you entered is not correct.' );
                        }
                        elseif ( $password1 !== $password2 )
                        {
                            $this->addError( 'The new passwords you entered did not match.' );
                        }
                        elseif ( strlen( $password2 ) < 7 )
                        {
                            $this->addError( 'Your new password must be at least 7 characters long.' );
                        }
                        else
                        {
                            //reset_password( $user, $password1 );

                            $data = array();
                            $data['ID'] = $user->ID;
                            $data['user_pass'] = $password1;
                            wp_update_user( $data );

                            header( 'Location:' . $this->add_to_querystring( array( 'action' => 'updated' ), TRUE ) );
                            exit;
                        }

                        break;

                    case 'upload':

                        if ( ! isset( $_FILES['file']['name'] ) || $_FILES['file']['name'] == '' )
                        {
                            $this->addError( 'Please choose a file to upload' );
                        }
                        else
                        {
                            $resource = new ProviderResource;
                            $resource->uploadFromFileArray( 'file', $this->getProvider()->getId(), $_POST['category'] );

                            if ( $resource->getId() !== NULL )
                            {
                                $message = '
                                    <p>Someone has just uploaded a provider resource (' . $_POST['category'] . ').</p>
                                    <p>Please <a href="' . get_admin_url() . '">log in</a> to view the resource.</p>';

                                Email::sendEmail( $this->getEmails(), 'New Provider Resource Upload', $message, TRUE );

                                header( 'Location:' . $this->add_to_querystring( array ( 'action' => 'uploaded' ), TRUE ) );
                                exit;
                            }
                        }

                        break;

                    case 'answer':

                        $content = trim( $_POST['content'] );
                        $id = ( isset( $_POST['id'] ) ) ? $_POST['id'] : 0;
                        $question = new Question( $id );

                        if ( $question->getId() === NULL )
                        {
                            header( 'Location:' . $this->add_to_querystring( array( 'action' => 'view', 'id' => $question->getId() ), TRUE, $this->getForumPageUrl() ) );
                            exit;
                        }

                        if ( strlen( $content ) == 0 )
                        {
                            $this->addError( 'Please enter a response' );
                        }
                        else
                        {
                            $answer = new Answer;
                            $answer
                                ->setParentId( $question->getId() )
                                ->setContent( $content )
                                ->setProviderId( $this->getProvider()->getId() )
                                ->create();

                            header( 'Location:' . $this->add_to_querystring( array( 'action' => 'view', 'id' => $answer->getParentId() ), TRUE, $this->getForumPageUrl() ) );
                            exit;
                        }

                        break;

                    case 'ask':

                        $title = trim( $_POST['title'] );
                        $content = trim( $_POST['content'] );

                        if ( strlen( $title ) == 0 )
                        {
                            $this->addError( 'Please enter a question or topic' );
                        }
                        else
                        {
                            $question = new Question;
                            $question
                                ->setTitle( $title )
                                ->setContent( $content )
                                ->setProviderId( $this->getProvider()->getId() )
                                ->setIsSticky( ( isset( $_POST['is_sticky'] ) ) )
                                ->create();

                            header( 'Location:' . $this->add_to_querystring( array( 'action' => 'view', 'id' => $question->getId() ), TRUE, $this->getForumPageUrl() ) );
                            exit;
                        }

                        break;

                    case 'delete_approved_emails':

                        $approved_emails = $this->getApprovedEmails();

                        if ( isset( $_POST['delete'] ) )
                        {
                            $emails = $_POST['delete'];
                            foreach ( $emails as $email )
                            {
                                $index = array_search( $email, $approved_emails );
                                if ( $index !== FALSE )
                                {
                                    unset( $approved_emails[ $index ] );
                                }
                            }
                        }

                        update_option( 'wasnap_approved', json_encode( $approved_emails ) );
                        header( 'Location: admin.php?page=wasnap_approved' );
                        exit;

                    case 'add_approved_emails':

                        $emails = $_POST['emails'];
                        $emails = str_replace( "\r", ',', $emails );
                        $emails = str_replace( "\n", ',', $emails );
                        $emails = str_replace( " ", ',', $emails );
                        $emails = str_replace( ";", ',', $emails );
                        $emails = explode( ',', $emails );

                        $approved_emails = $this->getApprovedEmails();

                        foreach ( $emails as $email )
                        {
                            $email = trim( strtolower( $email ) );
                            if ( is_email( trim( $email ) ) && ! in_array( $email, $approved_emails ) )
                            {
                                $approved_emails[] = $email;
                            }
                        }

                        update_option( 'wasnap_approved', json_encode( $approved_emails ) );
                        header( 'Location: admin.php?page=wasnap_approved' );
                        exit;

                    case 'edit':

                        if ( empty( $_POST['email'] ) || empty( $_POST['fname'] ) || empty( $_POST['lname'] ) || empty( $_POST['agency'] ) )
                        {
                            $this->addError( 'Please fill out all required fields' );
                        }

                        elseif ( ! is_email( $_POST['email'] ) )
                        {
                            $this->addError( 'Email is not valid' );
                        }

                        elseif ( strtolower( $_POST['email'] ) != strtolower( $this->getProvider()->getEmail() ) && email_exists( $_POST['email'] ) )
                        {
                            $this->addError( 'That email address is already in use' );
                        }

                        elseif ( ! isset( $_POST['snap_ed_role'] ) )
                        {
                            $this->addError( 'Please choose a SNAP-Ed Role' );
                        }

                        if ( count( $this->getErrors() ) == 0 )
                        {
                            $user_data = array (
                                'user_email' => $_POST['email'],
                                'first_name' => $_POST['fname'],
                                'last_name' => $_POST['lname'],
                                'user_url' => $_POST['url']
                            );
                            wp_update_user( $user_data );
                            update_user_meta( $this->getProvider()->getId(), 'address', $_POST['address'] );
                            update_user_meta( $this->getProvider()->getId(), 'address2', $_POST['address2'] );
                            update_user_meta( $this->getProvider()->getId(), 'city', $_POST['city'] );
                            update_user_meta( $this->getProvider()->getId(), 'state', $_POST['state'] );
                            update_user_meta( $this->getProvider()->getId(), 'zip', $_POST['zip'] );
                            update_user_meta( $this->getProvider()->getId(), 'agency', $_POST['agency'] );
                            update_user_meta( $this->getProvider()->getId(), 'phone', $_POST['phone'] );
                            update_user_meta( $this->getProvider()->getId(), 'region', $_POST['region'] );
                            update_user_meta( $this->getProvider()->getId(), 'snap_ed_role', $_POST['snap_ed_role'] );
                            update_user_meta( $this->getProvider()->getId(), 'program_focus', $_POST['program_focus'] );
                            update_user_meta( $this->getProvider()->getId(), 'audiences', $_POST['audiences'] );
                            update_user_meta( $this->getProvider()->getId(), 'sites', $_POST['sites'] );
                            update_user_meta( $this->getProvider()->getId(), 'is_profile_private', $_POST['is_profile_private'] );
                            update_user_meta( $this->getProvider()->getId(), 'is_in_provider_directory', $_POST['is_in_provider_directory'] );
                            update_user_meta( $this->getProvider()->getId(), 'is_dshs', $_POST['is_dshs'] );

                            if ( isset( $_POST['receives_notifications'] ) )
                            {
                                update_user_meta( $this->getProvider()->getId(), 'receives_notifications', 1 );
                            }
                            else
                            {
                                update_user_meta( $this->getProvider()->getId(), 'receives_notifications', 0 );
                            }

                            header( 'Location:' . $this->add_to_querystring( array( 'action' => 'updated' ), TRUE ) );
                            exit;
                        }

                        break;

                    case 'register':

                        if ( empty( $_POST['username'] ) || empty( $_POST['password'] ) || empty( $_POST['email'] ) || empty( $_POST['fname'] ) || empty( $_POST['lname'] ) || empty( $_POST['agency'] ) )
                        {
                            $this->addError( 'Please fill out all required fields' );
                        }

                        elseif ( 4 > strlen( $_POST['username'] ) )
                        {
                            $this->addError( 'Username too short. At least 4 characters is required' );
                        }

                        elseif ( username_exists( $_POST['username'] ) )
                        {
                            $this->addError( 'Sorry, that username already exists' );
                        }

                        elseif ( ! validate_username( $_POST['username'] ) )
                        {
                            $this->addError( 'Sorry, the username you entered is not valid' );
                        }

                        elseif ( 5 > strlen( $_POST['password'] ) )
                        {
                            $this->addError( 'Password length must be greater than 5' );
                        }

                        elseif ( ! is_email( $_POST['email'] ) )
                        {
                            $this->addError( 'Email is not valid' );
                        }

                        elseif ( email_exists( $_POST['email'] ) )
                        {
                            $this->addError( 'That email address is already in use' );
                        }

                        elseif ( ! isset( $_POST['snap_ed_role'] ) )
                        {
                            $this->addError( 'Please choose a SNAP-Ed Role' );
                        }

                        if ( count( $this->getErrors() ) == 0 )
                        {
                            $user_data = array (
                                'user_login' => $_POST['username'],
                                'user_email' => $_POST['email'],
                                'user_pass' => $_POST['password'],
                                'first_name' => $_POST['fname'],
                                'last_name' => $_POST['lname'],
                                'user_url' => $_POST['url'],
                                'role' => 'provider'
                            );
                            $user_id = wp_insert_user( $user_data );
                            update_user_meta( $user_id, 'address', $_POST['address'] );
                            update_user_meta( $user_id, 'address2', $_POST['address2'] );
                            update_user_meta( $user_id, 'city', $_POST['city'] );
                            update_user_meta( $user_id, 'state', $_POST['state'] );
                            update_user_meta( $user_id, 'zip', $_POST['zip'] );
                            update_user_meta( $user_id, 'agency', $_POST['agency'] );
                            update_user_meta( $user_id, 'phone', $_POST['phone'] );
                            update_user_meta( $user_id, 'region', $_POST['region'] );
                            update_user_meta( $user_id, 'snap_ed_role', $_POST['snap_ed_role'] );

                            $focuses = '';
                            if ( isset( $_POST['program_focus'] ) )
                            {
                                $focuses = implode( ', ', $_POST['program_focus'] );
                            }
                            update_user_meta( $user_id, 'program_focus', $focuses );

                            $audiences = '';
                            if ( isset( $_POST['audiences'] ) )
                            {
                                $audiences = implode( ', ', $_POST['audiences'] );
                            }
                            update_user_meta( $user_id, 'audiences', $audiences );

                            $sites = '';
                            if ( isset( $_POST['sites'] ) )
                            {
                                $sites = implode( ', ', $_POST['sites'] );
                            }
                            update_user_meta( $user_id, 'sites', $sites );

                            update_user_meta( $user_id, 'is_profile_private', $_POST['is_profile_private'] );
                            update_user_meta( $user_id, 'is_in_provider_directory', $_POST['is_in_provider_directory'] );

                            if ( isset( $_POST['receives_notifications'] ) )
                            {
                                update_user_meta( $user_id, 'receives_notifications', 1 );
                            }
                            else
                            {
                                update_user_meta( $user_id, 'receives_notifications', 0 );
                            }

                            if ( in_array( strtolower( $_POST['email'] ), $this->getApprovedEmails() ) )
                            {
                                update_user_meta( $user_id, 'approved_at', date( 'Y-m-d H:i:s' ) );
                                $provider = new Provider( $user_id );
                                $provider->sendApproval( $_REQUEST['password'] );
                            }
                            elseif ( count( $this->getEmails() ) > 0 )
                            {
                                $message = '
                                    <p><strong>' . $_POST['agency'] . '</strong> has just registered to be a provider on the website.</p>
                                    <p>Please <a href="' . get_admin_url() . '">log in</a> to view the application.</p>';

                                Email::sendEmail( $this->getEmails(), 'New Provider Registration', $message, TRUE );
                            }

                            header( 'Location:' . $this->add_to_querystring( array( 'action' => 'registered' ), TRUE ) );
                            exit;
                        }

                        break;
                }
			}
			else
			{
				$this->addError( 'It appears you are submitting this form from a different website' );
			}
		}
	}

    /**
     * @param array $args
     * @param bool $remove_old_query_string
     * @param null $url
     *
     * @return string
     */
	public function add_to_querystring( array $args, $remove_old_query_string = FALSE, $url = NULL )
    {
	    $keep_args = array();
	    if ( $url !== NULL )
        {
            $parts = explode( '?', $url );
            if ( count( $parts ) > 1 )
            {
                $keep_args = explode( '&', $parts[1] );
            }
        }

		$url = ( $url === NULL ) ? $_SERVER['REQUEST_URI'] : $url;
		$parts = explode( '?', $url );
		$url = $parts[0];
		$querystring = array();

		if ( count( $parts ) > 1 )
		{
			$parts = explode( '&', $parts[1] );
			foreach ( $parts as $part )
			{
				if ( ! $remove_old_query_string || substr( $part, 0, 3 ) == 'id=' )
				{
				    if ( ! in_array( $part, $querystring ) && ! in_array( $part, $keep_args ) )
                    {
                        $querystring[] = $part;
                    }
				}
			}
		}

		foreach ( $args as $key => $val )
		{
			$querystring[] = $key . '=' . $val;
		}

		foreach ( $keep_args as $arg )
        {
            $querystring[] = $arg;
        }

		return $url . ( ( count( $querystring ) > 0 ) ? '?' . implode( '&', $querystring ) : '' );
	}
	
	public function short_code( $attributes, $content = NULL )
	{
        $this->attributes = shortcode_atts( array(
            'page' => '',
            'section' => '',
            'login' => '',
            'tour_id' => NULL
        ), $attributes );

        if ( $this->getProvider() !== NULL )
        {
            $this->content = $this->getProvider()->fill( $content );
        }

        $this->shortcode_page = $this->getProviderPages()[ get_the_ID() ];

		ob_start();
		include( dirname( dirname( __DIR__ ) ) . '/includes/shortcode.php');
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $attribute
     *
     * @return mixed|string
     */
	public function getAttribute( $attribute )
    {
        if ( isset( $this->attributes[ $attribute ] ) )
        {
            return $this->attributes[ $attribute ];
        }

        return '';
    }

    /**
     * @return bool
     */
    public function isLoginHidden()
    {
        return ( $this->getAttribute( 'login' ) == 'hidden' && ! is_user_logged_in() );
    }

    /**
     * @param $page
     *
     * @return bool
     */
	public function isShortCodePage( $page )
    {
        return ( isset( $this->attributes['page'] ) && $this->attributes['page'] == $page );
    }

    /**
     * @return bool
     */
    public function isEditPage()
    {
        return $this->isShortCodePage( 'edit' );
    }

    /**
     * @return bool
     */
    public function isDashboardPage()
    {
        return $this->isShortCodePage( 'dashboard' );
    }

    /**
     * @return bool
     */
	public function isDirectoryPage()
    {
        return $this->isShortCodePage( 'directory' );
    }

    /**
     * @return bool
     */
    public function isForumPage()
    {
        return $this->isShortCodePage( 'forum' );
    }

	public function admin_menus()
	{
		add_menu_page( 'SNAP-Ed', 'SNAP-Ed', 'manage_options', 'wasnap', array( $this, 'print_settings_page' ), 'dashicons-carrot' );
		add_submenu_page( 'wasnap', 'Settings', 'Settings', 'manage_options', 'wasnap' );
        add_submenu_page( 'wasnap', 'Providers', 'Providers', 'manage_options', 'wasnap_providers', array( $this, 'print_providers_page' ) );
        add_submenu_page( 'wasnap', 'Pre-Approved Providers', 'Pre-Approved Providers', 'manage_options', 'wasnap_approved', array( $this, 'print_approved_page' ) );
        add_submenu_page( 'wasnap', 'Resources', 'Resources', 'manage_options', 'wasnap_resources', array( $this, 'print_resources_page' ) );
	}
	
	public function register_settings()
	{
        register_setting( 'wasnap_settings', 'wasnap_regions' );
        register_setting( 'wasnap_settings', 'wasnap_roles' );
        register_setting( 'wasnap_settings', 'wasnap_focuses' );
        register_setting( 'wasnap_settings', 'wasnap_audiences' );
        register_setting( 'wasnap_settings', 'wasnap_sites' );
        register_setting( 'wasnap_settings', 'wasnap_emails' );
        register_setting( 'wasnap_settings', 'wasnap_resource_categories' );
	}

    /**
     * @param bool $as_list
     *
     * @return array|string
     */
	public function getRegions( $as_list = FALSE )
    {
        $regions = explode( ',', get_option( 'wasnap_regions', '' ) );
        foreach ( $regions as $index => $region )
        {
            $regions[ $index ] = trim( $region );
        }

        return ( $as_list ) ? implode( ', ', $regions ) : $regions;
    }

    /**
     * @param bool $as_list
     *
     * @return array|string
     */
    public function getResourceCategories( $as_list = FALSE )
    {
        $regions = explode( ',', get_option( 'wasnap_resource_categories', '' ) );
        foreach ( $regions as $index => $region )
        {
            $regions[ $index ] = trim( $region );
        }

        return ( $as_list ) ? implode( ', ', $regions ) : $regions;
    }

    /**
     * @param bool $raw
     *
     * @return array|mixed
     */
    public function getRoles( $raw = FALSE )
    {
        $roles = get_option( 'wasnap_roles' , '' );

        if ( $raw )
        {
            return $roles;
        }

        $roles = str_replace( "\r", '', $roles );
        $roles = str_replace( "\n", '', $roles );
        $roles = explode( '~', $roles );
        $parsed = array();

        foreach ( $roles as $index => $role )
        {
            $role = str_replace( ']', '', $role );
            $parts = explode( '[', $role );
            $parsed[ $index ][ 'role' ] = trim( $parts[0] );
            if ( isset( $parts[1] ) )
            {
                $parsed[ $index ][ 'mouseover' ] = trim( $parts[1] );
            }
        }

        return $parsed;
    }

    /**
     * @param bool $raw
     *
     * @return array|mixed
     */
    public function getFocuses( $raw = FALSE )
    {
        $focuses = get_option( 'wasnap_focuses' , '' );

        if ( $raw )
        {
            return $focuses;
        }

        $focuses = str_replace( "\r", '', $focuses );
        $focuses = str_replace( "\n", '', $focuses );
        $focuses = explode( '~', $focuses );
        $parsed = array();

        foreach ( $focuses as $index => $focus )
        {
            $focus = str_replace( ']', '', $focus );
            $parts = explode( '[', $focus );
            $parsed[ $index ][ 'focus' ] = trim( $parts[0] );
            if ( isset( $parts[1] ) )
            {
                $parsed[ $index ][ 'mouseover' ] = trim( $parts[1] );
            }
        }

        return $parsed;
    }

    /**
     * @param bool $raw
     *
     * @return array|mixed
     */
    public function getAudiences( $raw = FALSE )
    {
        $audiences = get_option( 'wasnap_audiences' , '' );

        if ( $raw )
        {
            return $audiences;
        }

        $audiences = str_replace( "\r", '', $audiences );
        $audiences = str_replace( "\n", '', $audiences );
        $audiences = explode( '~', $audiences );
        $parsed = array();

        foreach ( $audiences as $index => $audience )
        {
            $audience = str_replace( ']', '', $audience );
            $parts = explode( '[', $audience );
            $parsed[ $index ][ 'audience' ] = trim( $parts[0] );
            if ( isset( $parts[1] ) )
            {
                $parsed[ $index ][ 'mouseover' ] = trim( $parts[1] );
            }
        }

        return $parsed;
    }

    /**
     * @param bool $raw
     *
     * @return array|mixed
     */
    public function getSites( $raw = FALSE )
    {
        $sites = get_option( 'wasnap_sites' , '' );

        if ( $raw )
        {
            return $sites;
        }

        $sites = str_replace( "\r", '', $sites );
        $sites = str_replace( "\n", '', $sites );
        $sites = explode( '~', $sites );
        $parsed = array();

        foreach ( $sites as $index => $site )
        {
            $site = str_replace( ']', '', $site );
            $parts = explode( '[', $site );
            $parsed[ $index ][ 'site' ] = trim( $parts[0] );
            if ( isset( $parts[1] ) )
            {
                $parsed[ $index ][ 'mouseover' ] = trim( $parts[1] );
            }
        }

        return $parsed;
    }

    /**
     * @param bool $as_list
     *
     * @return array|string
     */
    public function getEmails( $as_list = FALSE )
    {
        $emails = explode( ',', get_option( 'wasnap_emails' , '' ) );
        foreach ( $emails as $index => $email )
        {
            if ( is_email( trim( $email ) ) )
            {
                $emails[ $index ] = trim( $email );
            }
            else
            {
                unset( $emails[ $index ] );
            }
        }

        return ( $as_list ) ? implode( ', ', $emails ) : $emails;
    }

    /**
     * @return array
     */
    public function getApprovedEmails()
    {
        $approved_emails = trim( get_option( 'wasnap_approved' , '' ) );
        return ( strlen ( $approved_emails ) == 0 ) ? array() : json_decode( $approved_emails, TRUE );
    }
	
	public function admin_scripts()
	{
		wp_enqueue_media();
		add_thickbox();
		wp_enqueue_script( 'wasnap-admin', plugin_dir_url( dirname( __DIR__ ) ) . 'js/admin.js', array( 'jquery' ), ( WP_DEBUG ) ? time() : self::VERSION_JS, TRUE );
		wp_localize_script( 'wasnap-admin', 'url_variables', $_GET );
	}

	/**
	 * @param array $links
	 *
	 * @return array
	 */
	public function settings_link( $links )
	{
		$link = '<a href="options-general.php?page=wasnap">Settings</a>';
		$links[] = $link;
		return $links;
	}

	public function settings_page()
	{
		add_options_page(
			'Settings',
			'Settings',
			'manage_options',
			'wasnap',
			array( $this, 'print_settings_page')
		);
	}

	public function print_settings_page()
	{
		include( dirname( dirname( __DIR__ ) ) . '/includes/settings.php' );
	}

    public function print_providers_page()
    {
        include( dirname( dirname( __DIR__ ) ) . '/includes/providers.php' );
    }

    public function print_approved_page()
    {
        include( dirname( dirname( __DIR__ ) ) . '/includes/approved.php' );
    }

    public function print_resources_page()
    {
        include( dirname( dirname( __DIR__ ) ) . '/includes/resources.php' );
    }

	public function create_nonce()
	{
		$nonce = uniqid();
		update_option( 'wasnap_nonce', $nonce );
		return $nonce;
	}

	public function validate_nonce( $nonce )
	{
		$option = get_option( 'wasnap_nonce', uniqid() );
		if ( $option == $nonce )
		{
			$this->create_nonce();
			return TRUE;
		}

		return FALSE;
	}

    public function extra_profile_fields()
    {
        include( dirname( dirname( __DIR__ ) ) . '/includes/user_fields.php' );
    }

    public function save_extra_profile_fields()
    {
        global $pagenow;

        if ( is_admin() && 'user-new.php' == $pagenow )
        {
            $user_details = get_user_by( 'email', $_REQUEST['email'] );
            $user_id = $user_details->ID;
        }
        else
        {
            $user_id = $_POST['user_id'];
        }

        if ( ! current_user_can( 'edit_user', $user_id ) )
        {
            return FALSE;
        }

        if ( isset( $_POST['agency'] ) )
        {
            update_user_meta( $user_id, 'agency', $_POST['agency'] );
        }

        if ( isset( $_POST['address'] ) )
        {
            update_user_meta( $user_id, 'address', $_POST['address'] );
        }

        if ( isset( $_POST['address2'] ) )
        {
            update_user_meta( $user_id, 'address2', $_POST['address2'] );
        }

        if ( isset( $_POST['city'] ) )
        {
            update_user_meta( $user_id, 'city', $_POST['city'] );
        }

        if ( isset( $_POST['state'] ) )
        {
            update_user_meta( $user_id, 'state', $_POST['state'] );
        }

        if ( isset( $_POST['zip'] ) )
        {
            update_user_meta( $user_id, 'zip', $_POST['zip'] );
        }

        if ( isset( $_POST['phone'] ) )
        {
            update_user_meta( $user_id, 'phone', $_POST['phone'] );
        }

        if ( isset( $_POST['url'] ) )
        {
            update_user_meta( $user_id, 'url', $_POST['url'] );
        }

        if ( isset( $_POST['region'] ) )
        {
            update_user_meta( $user_id, 'region', $_POST['region'] );
        }

        if ( isset( $_POST['snap_ed_role'] ) )
        {
            update_user_meta( $user_id, 'snap_ed_role', $_POST['snap_ed_role'] );
        }

        if ( isset( $_POST['program_focus'] ) )
        {
            update_user_meta( $user_id, 'program_focus', $_POST['program_focus'] );
        }

        if ( isset( $_POST['audiences'] ) )
        {
            update_user_meta( $user_id, 'audiences', $_POST['audiences'] );
        }

        if ( isset( $_POST['sites'] ) )
        {
            update_user_meta( $user_id, 'sites', $_POST['sites'] );
        }

        if ( isset( $_POST['is_profile_private'] ) )
        {
            update_user_meta( $user_id, 'is_profile_private', $_POST['is_profile_private'] );
        }

        if ( isset( $_POST['receives_notifications'] ) )
        {
            update_user_meta( $user_id, 'receives_notifications', $_POST['receives_notifications'] );
        }

        if ( isset( $_POST['is_in_provider_directory'] ) )
        {
            update_user_meta( $user_id, 'is_in_provider_directory', $_POST['is_in_provider_directory'] );
        }

        if ( isset( $_POST['is_approved'] ) && $_POST['is_approved'] == 1 )
        {
            update_user_meta( $user_id, 'approved_at', date( 'Y-m-d H:i:s' ) );
            $provider = new Provider( $user_id );
            $provider->sendApproval( $_REQUEST['password'] );
        }

        if ( isset( $_POST['is_dshs'] ) )
        {
            update_user_meta( $user_id, 'is_dshs', $_POST['is_dshs'] );
        }

        return TRUE;
    }

    public function redirect_after_add_user( $location )
    {
        global $pagenow;

        if( is_admin() && 'user-new.php' == $pagenow )
        {
            $user_details = get_user_by( 'email', $_REQUEST[ 'email' ] );
            $user_id = $user_details->ID;

            if( implode( ',', $user_details->roles ) == 'provider' && $location == 'users.php?update=add&id=' . $user_id )
            {
                return add_query_arg( array (
                    'page' => 'wasnap_providers',
                    'action' => 'view',
                    'id' => $user_id
                ), 'admin.php?' );
            }
        }

        return $location;
    }

    /**
     * @return Page[]
     */
    public function getProviderPages()
    {
        global $wpdb;

        if ( $this->shortcode_pages === NULL )
        {
            $this->shortcode_pages = array();

            $sql = "
                SELECT
                    ID,
                    post_title,
                    post_name,
                    guid,
                    post_content
                FROM
                    " . $wpdb->prefix . "posts
                WHERE
                    post_type = 'page'
                    AND post_status = 'publish'
                    AND post_content LIKE '%[wasnap%'
                ORDER BY
                    ID ASC";

            $rows = $wpdb->get_results( $sql );

            /* dashboard */
            foreach ( $rows as $index => $row )
            {
                if ( strpos( $row->post_content, '[wasnap page="dashboard"]' ) !== FALSE )
                {
                    $this->shortcode_pages[ $row->ID ] = new Page( $row->ID, $row->post_title, $row->post_name, $row->guid, 'dashboard' );
                    unset( $rows[ $index ] );
                    break;
                }
            }

            /* forum */
            foreach ( $rows as $index => $row )
            {
                if ( strpos( $row->post_content, '[wasnap page="forum"]' ) !== FALSE )
                {
                    $this->shortcode_pages[ $row->ID ] = new Page( $row->ID, $row->post_title, $row->post_name, $row->guid, 'forum' );
                    unset( $rows[ $index ] );
                    break;
                }
            }

            /* directory */
            foreach ( $rows as $index => $row )
            {
                if ( strpos( $row->post_content, '[wasnap page="directory"]' ) !== FALSE )
                {
                    $this->shortcode_pages[ $row->ID ] = new Page( $row->ID, $row->post_title, $row->post_name, $row->guid, 'directory' );
                    unset( $rows[ $index ] );
                    break;
                }
            }

            /* menu */
            foreach ( $rows as $index => $row )
            {
                if ( strpos( $row->post_content, '[wasnap page="menu"]' ) !== FALSE )
                {
                    $this->shortcode_pages[ $row->ID ] = new Page( $row->ID, $row->post_title, $row->post_name, $row->guid, 'menu' );
                    unset( $rows[ $index ] );
                    break;
                }
            }

            /* all others */
            foreach ( $rows as $index => $row )
            {
                $this->shortcode_pages[ $row->ID ] = new Page( $row->ID, $row->post_title, $row->post_name, $row->guid, '' );
            }
        }

        return $this->shortcode_pages;
    }

    /**
     * @return Page[]
     */
    public function getProviderLinksPages()
    {
        $pages = [];

        foreach ( $this->getProviderPages() as $page )
        {
            if ( $page->isProtected() && strlen( $page->getShortcodePage() ) > 0 )
            {
                $pages[] = $page;
            }
        }

        return $pages;
    }

    /**
     * @return Page
     */
    public function getFirstProviderPage()
    {
        foreach ( $this->getProviderLinksPages() as $page )
        {
            return $page;
        }
    }

    public function getDashboardUrl()
    {
        foreach ( $this->getProviderLinksPages() as $page )
        {
            if ( $page->getShortcodePage() == 'dashboard' )
            {
                return get_permalink( $page->getId() );
            }
        }
    }

    public function getForumPageUrl()
    {
        foreach ( $this->getProviderLinksPages() as $page )
        {
            if ( $page->getShortcodePage() == 'forum' )
            {
                return get_permalink( $page->getId() );
            }
        }

        return $this->add_to_querystring( array( 'page' => 'forum' ), TRUE, $this->getDashboardUrl() );
    }

    public function disable_richedit( $default )
    {
        global $post;

        if ( get_post_type( $post ) == 'wasnap_dshs_message' || get_post_type( $post ) == 'wasnap_message' || get_post_type( $post ) == 'wasnap_hopscotch' )
        {
            return FALSE;
        }
        return $default;
    }

    public function dshs_message_save()
    {
        $return = [
            'success' => 0,
            'id_in' => $_POST['id'],
            'id_out' => '',
            'message' => $_POST['message'],
            'error' => '',
            'date' => ''
        ];

        if ( $return['id_in'] == 'new' )
        {
            $arguments = array(
                'post_content' => $return['message'],
                'post_content_filtered' => '',
                'post_title' => date( 'F j, Y g:i a' ),
                'post_excerpt' => '',
                'post_status' => 'publish',
                'post_type' => 'wasnap_dshs_message',
                'comment_status' => 'closed',
                'ping_status' => '',
                'post_password' => '',
                'to_ping' =>  '',
                'pinged' => '',
                'post_parent' => 0,
                'menu_order' => 0,
                'guid' => '',
                'import_id' => 0,
                'context' => '',
            );

            $return['date'] = date('n/j/Y');
            $return['id_out'] = wp_insert_post( $arguments );
        }
        else
        {
            $return['id_out'] = wp_update_post( array(
                'ID' => $return['id_in'],
                'post_content' => $return['message']
            ) );
        }

        wp_send_json( $return );
    }

    public function dshs_message_delete()
    {
        if ( $post = get_post( $_POST['id'] ) )
        {
            if ( $post->post_type == 'wasnap_dshs_message' )
            {
                wp_delete_post( $_POST['id'] );
            }
        }
        wp_send_json( array( 'id' => $_POST['id'] ) );
    }

    public function wp_mail_content_type()
    {
        return 'text/html';
    }

    public function retrieve_password_message( $content, $key )
    {
        //$content = str_replace( "\r\n", '<br>', $content );
        $content = str_replace( '<', '', $content );
        $content = str_replace( '>', '', $content );

        return Email::buildEmail( $content );
    }

    public function set_hopscotch_custom_columns( $column_name )
    {
        global $post;

        if ( $column_name == 'shortcode' )
        {
            echo '[wasnap section="tour" tour_id="' . $post->ID . '"]';
        }
    }

    public function set_hopscotch_columns( $columns )
    {
        $columns['shortcode'] = 'Shortcode';

        return $columns;
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public function formatLinks( $content )
    {
        $xp = '@(http(s)?)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
        return preg_replace( $xp, '<a href="http$2://$4" title="$0">$0</a>', $content );
    }
}