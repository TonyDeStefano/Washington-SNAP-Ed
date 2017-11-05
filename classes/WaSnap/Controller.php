<?php

namespace WaSnap;

class Controller {
	
	const VERSION = '0.0.1';
	const VERSION_JS = '0.0.1';
	const VERSION_CSS = '0.0.1';

	private $errors;

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
	}
	
	public function form_capture()
	{
	    if ( isset( $_POST['wasnap_action'] ) )
		{
			if ( isset( $_POST['wasnap_nonce'] ) && wp_verify_nonce( $_POST['wasnap_nonce'], 'wasnap_' . $_POST['wasnap_action'] ) )
			{
				switch ( $_POST['wasnap_action'] )
                {

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
	
	public function short_code()
	{
		ob_start();
		include( dirname( dirname( __DIR__ ) ) . '/includes/shortcode.php');
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	public function admin_menus()
	{
		add_menu_page( 'SNAP-Ed', 'SNAP-Ed', 'manage_options', 'wasnap', array( $this, 'print_settings_page' ), 'dashicons-carrot' );
		add_submenu_page( 'wasnap', 'Settings', 'Settings', 'manage_options', 'wasnap' );
	}
	
	public function register_settings()
	{

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

	/**
	 *
	 */
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

	/**
	 *
	 */
	public function print_settings_page()
	{
		include( dirname( dirname( __DIR__ ) ) . '/includes/settings.php' );
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
}