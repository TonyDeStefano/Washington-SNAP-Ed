<?php

namespace WaSnap;

if ( ! class_exists( 'WP_List_Table' ) )
{
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class ProviderTable extends \WP_List_Table {

    /**
     * PhotographerTable constructor.
     */
    public function __construct()
    {
        parent::__construct( array(
            'singular' => 'Provider',
            'plural' => 'Providers',
            'ajax' => TRUE
        ) );
    }

    /**
     * @return array
     */
    public function get_columns()
    {
        $return = array(
            'name' => 'Name',
			'agency' => 'Agency',
            'region' => 'Region',
            'snap_ed_role' => 'Role',
            'approved' => 'Approved',
            'view' => 'View'
        );

        return $return;
    }

    /**
     * @return array
     */
    public function get_sortable_columns()
    {
        $return =  array(
            
            'name' => array( 'ln.last_name', TRUE ),
			'agency' => array( 'a.agency', TRUE ),
            'region' => array( 'r.region', TRUE ),
            'snap_ed_role' => array( 'sr.snap_ed_role', TRUE ),
            'approved' => array( 'approved', TRUE )
        );

        return $return;
    }

    /**
     * @param object $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'name':
                return $item->last_name . ', ' . $item->first_name . '<br><a href="mailto:' . $item->email . '">' . $item->email . '</a><br>' . $item->phone;
            case 'view':
                return '<a href="?page=' . $_REQUEST['page'] . '&action=view&id=' . $item->ID . '" class="button-primary">View</a>';
            case 'approved':
                return ( $item->approved == 1 ) ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';
            default:
                return $item->$column_name;
        }
    }

    /**
     *
     */
    public function prepare_items()
    {
        global $wpdb;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $sql = "
			SELECT
				u.ID,
				u.user_email AS email,
				fn.first_name,
				ln.last_name,
				a.agency,
				p.phone,
				r.region,
				sr.snap_ed_role,
				IF( x.approved_at IS NULL, 0, 1 ) AS approved
			FROM
				" . $wpdb->prefix . "users u
				JOIN " . $wpdb->prefix . "usermeta um
				    ON u.ID = um.user_id
				LEFT JOIN
				(
					SELECT
						user_id,
						meta_value AS first_name
					FROM
						" . $wpdb->prefix . "usermeta
					WHERE
						meta_key = 'first_name'
				) fn ON u.ID = fn.user_id
				LEFT JOIN
				(
					SELECT
						user_id,
						meta_value AS last_name
					FROM
						" . $wpdb->prefix . "usermeta
					WHERE
						meta_key = 'last_name'
				) ln ON u.ID = ln.user_id
				LEFT JOIN
				(
					SELECT
						user_id,
						meta_value AS agency
					FROM
						" . $wpdb->prefix . "usermeta
					WHERE
						meta_key = 'agency'
				) a ON u.ID = a.user_id
				LEFT JOIN
				(
					SELECT
						user_id,
						meta_value AS phone
					FROM
						" . $wpdb->prefix . "usermeta
					WHERE
						meta_key = 'phone'
				) p ON u.ID = p.user_id
				LEFT JOIN
				(
					SELECT
						user_id,
						meta_value AS region
					FROM
						" . $wpdb->prefix . "usermeta
					WHERE
						meta_key = 'region'
				) r ON u.ID = r.user_id
				LEFT JOIN
				(
					SELECT
						user_id,
						meta_value AS snap_ed_role
					FROM
						" . $wpdb->prefix . "usermeta
					WHERE
						meta_key = 'snap_ed_role'
				) sr ON u.ID = sr.user_id
				LEFT JOIN
				(
					SELECT
						user_id,
						meta_value AS approved_at
					FROM
						" . $wpdb->prefix . "usermeta
					WHERE
						meta_key = 'approved_at'
				) x ON u.ID = x.user_id
			WHERE
			    um.meta_value = 'a:1:{s:8:\"provider\";b:1;}'
			GROUP BY
				u.ID";
        if ( isset( $_GET[ 'orderby' ] ) )
        {
            foreach ( $sortable as $s )
            {
                if ( $s[ 0 ] == $_GET[ 'orderby' ] )
                {
                    $sql .= "
						ORDER BY " . $_GET[ 'orderby' ] . " " . ( ( isset( $_GET['order']) && strtolower( $_GET['order'] == 'desc' ) ) ? "DESC" : "ASC" );
                    break;
                }
            }
        }
        else
        {
            $sql .= "
				ORDER BY
					ln.last_name DESC";
        }

        $total_items = $wpdb->query( $sql );

        $max_per_page = 50;
        $paged = ( isset( $_GET[ 'paged' ] ) && is_numeric( $_GET['paged'] ) ) ? abs( round( $_GET[ 'paged' ])) : 1;
        $total_pages = ceil( $total_items / $max_per_page );

        if ( $paged > $total_pages )
        {
            $paged = $total_pages;
        }

        $offset = ( $paged - 1 ) * $max_per_page;
        $offset = ( $offset < 0 ) ? 0 : $offset; //MySQL freaks out about LIMIT -10, 10 type stuff.

        $sql .= "
			LIMIT " . $offset . ", " . $max_per_page;

        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'total_pages' => $total_pages,
            'per_page' => $max_per_page
        ) );

        $this->_column_headers = array( $columns, $hidden, $sortable );
        $this->items = $wpdb->get_results( $sql );
    }
}