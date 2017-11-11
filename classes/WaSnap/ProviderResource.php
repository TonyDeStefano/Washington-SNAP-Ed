<?php

namespace WaSnap;

class ProviderResource {

    const TABLE_NAME = 'wasnap_resources';

    private $id;
    private $provider_id;
    private $category;
    private $title;
    private $location;
    private $created_at;

    public function __construct( $id = NULL )
    {
        $this
            ->setId( $id )
            ->read();
    }

    public function create()
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        $this->setCreatedAt( time() );

        $wpdb->insert(
            $wpdb->prefix . self::TABLE_NAME,
            array(
                'provider_id' => $this->provider_id,
                'category' => $this->category,
                'location' => $this->location,
                'title' => $this->title,
                'created_at' => $this->getCreatedAt()
            ),
            array( '%d', '%s', '%s', '%s', '%s' )
        );

        $this->id = $wpdb->insert_id;
    }

    public function read()
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        if ( $this->id !== NULL )
        {
            $sql = "
                SELECT
                    *
                FROM
                    " . $wpdb->prefix . self::TABLE_NAME . "
                WHERE
                    id = %d";
            $sql = $wpdb->prepare( $sql, array ( $this->id ) );

            if ( $row = $wpdb->get_row( $sql ) )
            {
                $this->loadFromObject( $row );
            }
            else
            {
                $this->id = NULL;
            }
        }
    }

    /**
     * @param \stdClass $row
     */
    public function loadFromObject( $row )
    {
        if ( $row !== NULL )
        {
            $this
                ->setId( $row->id )
                ->setProviderId( $row->provider_id )
                ->setCategory( $row->category )
                ->setTitle( $row->title )
                ->setLocation( $row->location )
                ->setTitle( $row->title )
                ->setCreatedAt( $row->created_at );
        }
    }

    public function delete()
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        if ( $this->id !== NULL )
        {
            if ( file_exists( $this->getLocation() ) )
            {
                unlink( $this->getLocation() );
            }
            
            $wpdb->delete(
                $wpdb->prefix . self::TABLE_NAME,
                array( 'id' => $this->id ),
                array( '%d' )
            );
        }
    }

    public function uploadFromFileArray( $key, $provider_id, $category = '' )
    {
        if ( isset( $_FILES[ $key ] ) )
        {
            $name = $_FILES[ $key ]['name'];
            $tmp = $_FILES[ $key ]['tmp_name'];

            if ( strlen( $name ) > 0 && strlen( $tmp ) > 0 )
            {
                $this->upload( $name, $tmp, $provider_id, $category );
            }
        }
    }

    public function upload( $title, $tmp_location, $provider_id, $category = '' )
    {
        $folder = ABSPATH . '/wp-content/uploads/wasnap';

        if ( ! file_exists( $folder ) )
        {
            mkdir( $folder );
        }

        $file = uniqid();
        move_uploaded_file( $tmp_location, $folder . '/' . $file );

        $this
            ->setTitle( $title )
            ->setLocation( $file )
            ->setCategory( $category )
            ->setProviderId( $provider_id )
            ->create();
    }

    public function download()
    {
        header( 'Content-Type: application/octet-stream' );
        header( 'Content-Transfer-Encoding: Binary' );
        header( 'Content-disposition: attachment; filename="' . $this->getTitle() . '"');
        echo file_get_contents( $this->getLocation() );
        die();
    }

    /**
     * @return ProviderResource[]
     */
    public static function getAllResources()
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        $resources = [];

        $sql = "
            SELECT
                *
            FROM
                " . $wpdb->prefix . self::TABLE_NAME . "
            ORDER BY
                id DESC";

        if ( $rows = $wpdb->get_results( $sql ) )
        {
            foreach ( $rows as $row )
            {
                $resource = new ProviderResource();
                $resource->loadFromObject( $row );
                $resources[ $resource->getId() ] = $resource;
            }
        }

        return $resources;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return ProviderResource
     */
    public function setId( $id )
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->provider_id;
    }

    /**
     * @param mixed $provider_id
     *
     * @return ProviderResource
     */
    public function setProviderId( $provider_id )
    {
        $this->provider_id = $provider_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     *
     * @return ProviderResource
     */
    public function setCategory( $category )
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return ProviderResource
     */
    public function setTitle( $title )
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return ABSPATH . '/wp-content/uploads/wasnap/' . $this->location;
    }

    /**
     * @param mixed $location
     *
     * @return ProviderResource
     */
    public function setLocation( $location )
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getCreatedAt( $format = 'Y-m-d H:i:s' )
    {
        return Util::getDate( $this->created_at, $format );
    }

    /**
     * @param mixed $created_at
     *
     * @return ProviderResource
     */
    public function setCreatedAt( $created_at )
    {
        $this->created_at = $created_at;

        return $this;
    }
}