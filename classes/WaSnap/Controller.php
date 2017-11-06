<?php

namespace WaSnap;

class Controller {
	
	const VERSION = '0.0.1';
	const VERSION_JS = '0.0.1';
	const VERSION_CSS = '0.0.1';

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

	}

	public function init()
	{
		wp_enqueue_media();
		add_thickbox();
		wp_enqueue_style( 'wasnap-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), ( WP_DEBUG ) ? time() : self::VERSION_JS, TRUE );
		wp_enqueue_script( 'wasnap-js', plugin_dir_url( dirname( __DIR__ )  ) . 'js/wasnap.js', array( 'jquery' ), ( WP_DEBUG ) ? time() : self::VERSION_JS, TRUE );
		wp_enqueue_style( 'wasnap-bootstrap-css', plugin_dir_url( dirname( __DIR__ ) ) . 'css/bootstrap.css', array(), ( WP_DEBUG ) ? time() : self::VERSION_CSS );
		wp_enqueue_style( 'wasnap-css', plugin_dir_url( dirname( __DIR__ ) ) . 'css/wasnap.css', array(), ( WP_DEBUG ) ? time() : self::VERSION_CSS );

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
	
	public function form_capture()
	{
	    if ( isset( $_POST['wasnap_action'] ) )
		{
			if ( isset( $_POST['wasnap_nonce'] ) && wp_verify_nonce( $_POST['wasnap_nonce'], 'wasnap_' . $_POST['wasnap_action'] ) )
			{
				switch ( $_POST['wasnap_action'] )
                {
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
                            update_user_meta( $user_id, 'program_focus', $_POST['program_focus'] );
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

                            if ( count( $this->getEmails() ) > 0 )
                            {
                                $message = '
                                    <p><strong>' . $_POST['agency'] . '</strong> has just registered to be a provider on the website.</p>
                                    <p>Please <a href="' . get_admin_url() . '">log in</a> to view the application.</p>';

                                $headers = array( 'Content-Type: text/html; charset=UTF-8' );
                                wp_mail( $this->getEmails(), 'New Provider Registration', $message, $headers );
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
     *
     * @return string
     */
	public function add_to_querystring( array $args, $remove_old_query_string=FALSE )
	{
		$url = $_SERVER['REQUEST_URI'];
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
					$querystring[] = $part;
				}
			}
		}

		foreach ( $args as $key => $val )
		{
			$querystring[] = $key . '=' . $val;
		}

		return $url . ( ( count( $querystring ) > 0 ) ? '?' . implode( '&', $querystring ) : '' );
	}
	
	public function short_code( $attributes, $content = NULL )
	{
        $this->attributes = shortcode_atts( array( 'page' => '' ), $attributes );
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
	}
	
	public function register_settings()
	{
        register_setting( 'wasnap_settings', 'wasnap_regions' );
        register_setting( 'wasnap_settings', 'wasnap_roles' );
        register_setting( 'wasnap_settings', 'wasnap_emails' );
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
    public function getRoles( $as_list = FALSE )
    {
        $roles = explode( ',', get_option( 'wasnap_roles' , '' ) );
        foreach ( $roles as $index => $role )
        {
            $roles[ $index ] = trim( $role );
        }

        return ( $as_list ) ? implode( ', ', $roles ) : $roles;
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
}