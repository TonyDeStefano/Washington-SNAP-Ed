<?php

namespace WaSnap;

class ForumPost {

    const TABLE_NAME = 'wasnap_forum_posts';

    protected $id;
    protected $parent_id;
    protected $provider_id;
    protected $child_count;
    protected $title;
    protected $content;
    protected $is_sticky = FALSE;
    protected $is_archived = FALSE;
    protected $created_at;
    protected $updated_at;

    /**
     * ForumPost constructor.
     *
     * @param null $id
     * @param bool $load_children
     */
    public function __construct( $id = NULL, $load_children = FALSE )
    {
        $this
            ->setId( $id )
            ->read();
    }

    public function create()
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        $this
            ->setCreatedAt( time() )
            ->setUpdatedAt( time() )
            ->setChildCount( 0 );

        $wpdb->insert(
            $wpdb->prefix . self::TABLE_NAME,
            array(
                'parent_id' => $this->parent_id,
                'provider_id' => $this->provider_id,
                'child_count' => $this->child_count,
                'content' => $this->content,
                'title' => $this->title,
                'is_sticky' => ( $this->isSticky() ) ? 1 : 0,
                'is_archived' => ( $this->isArchived() ? 1 : 0 ),
                'created_at' => $this->getCreatedAt(),
                'updated_at' => $this->getUpdatedAt()
            ),
            array( '%d', '%d', '%d', '%s', '%s', '%d', '%d', '%s', '%s' )
        );

        $this->setId( $wpdb->insert_id );

        if ( $this->parent_id !== NULL )
        {
            $sql = "
                UPDATE
                    " . $wpdb->prefix . self::TABLE_NAME . "
                SET
                    child_count = child_count + 1,
                    updated_at = '" . date( 'Y-m-d H:i:s' ) . "'
                WHERE
                    id = %d";
            $sql = $wpdb->prepare( $sql, array( $this->parent_id ) );
            $wpdb->query( $sql );
        }
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
                ->setParentId( $row->parent_id )
                ->setProviderId( $row->provider_id )
                ->setChildCount( $row->child_count )
                ->setContent( $row->content )
                ->setTitle( $row->title )
                ->setIsSticky( $row->is_sticky )
                ->setIsArchived( $row->is_archived )
                ->setCreatedAt( $row->created_at )
                ->setUpdatedAt( $row->updated_at );
        }
    }

    public function update()
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        if ( $this->id !== NULL )
        {
            $this->setUpdatedAt( time() );

            $wpdb->update(
                $wpdb->prefix . self::TABLE_NAME,
                array(
                    'parent_id' => $this->parent_id,
                    'provider_id' => $this->provider_id,
                    'child_count' => $this->child_count,
                    'content' => $this->content,
                    'title' => $this->title,
                    'is_sticky' => ( $this->isSticky() ) ? 1 : 0,
                    'is_archived' => ( $this->isArchived() ? 1 : 0 ),
                    'created_at' => $this->getCreatedAt(),
                    'updated_at' => $this->getUpdatedAt()
                ),
                array( '%d', '%d', '%d', '%s', '%s', '%d', '%d', '%s', '%s' )
            );
        }

    }

    public function delete()
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        if ( $this->id !== NULL )
        {
            if ( $this->parent_id !== NULL )
            {
                $sql = "
                    UPDATE
                        " . $wpdb->prefix . self::TABLE_NAME . "
                    SET
                        child_count = child_count - 1
                    WHERE
                        id = %d";
                $sql = $wpdb->prepare( $sql, array( $this->parent_id ) );
                $wpdb->query( $sql );
            }

            $wpdb->delete(
                $wpdb->prefix . self::TABLE_NAME,
                array( 'id' => $this->id ),
                array( '%d' )
            );

            $wpdb->delete(
                $wpdb->prefix . self::TABLE_NAME,
                array( 'parent_id' => $this->id ),
                array( '%d' )
            );
        }
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
     * @return ForumPost
     */
    public function setId( $id )
    {
        $this->id = ( is_numeric( $id ) && $id > 0 ) ? abs( round( $id ) ) : NULL;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     *
     * @return ForumPost
     */
    public function setParentId( $parent_id )
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return Util::getString( $this->content );
    }

    /**
     * @param mixed $content
     *
     * @return ForumPost
     */
    public function setContent( $content )
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return Util::getString( $this->title );
    }

    /**
     * @param mixed $title
     *
     * @return ForumPost
     */
    public function setTitle( $title )
    {
        $this->title = $title;

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
     * @return ForumPost
     */
    public function setProviderId( $provider_id )
    {
        $this->provider_id = $provider_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChildCount()
    {
        return $this->child_count;
    }

    /**
     * @param mixed $child_count
     *
     * @return ForumPost
     */
    public function setChildCount( $child_count )
    {
        $this->child_count = $child_count;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSticky()
    {
        return Util::getBool( $this->is_sticky );
    }

    /**
     * @param bool $is_sticky
     *
     * @return ForumPost
     */
    public function setIsSticky( $is_sticky )
    {
        $this->is_sticky = Util::setBool( $is_sticky );

        return $this;
    }

    /**
     * @return bool
     */
    public function isArchived()
    {
        return Util::getBool( $this->is_archived );
    }

    /**
     * @param bool $is_archived
     *
     * @return ForumPost
     */
    public function setIsArchived( $is_archived )
    {
        $this->is_archived = Util::setBool( $is_archived );

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
     * @return ForumPost
     */
    public function setCreatedAt( $created_at )
    {
        $this->created_at = Util::setDate( $created_at );

        return $this;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getUpdatedAt( $format = 'Y-m-d H:i:s' )
    {
        return Util::getDate( $this->updated_at, $format );
    }

    /**
     * @param mixed $updated_at
     *
     * @return ForumPost
     */
    public function setUpdatedAt( $updated_at )
    {
        $this->updated_at = Util::setDate( $updated_at );

        return $this;
    }

    /**
     * @param null $parent_id
     * @param null $provider_id
     * @param null|bool $is_archived
     * @param null|int $page
     * @param null|int $page_size
     *
     * @return ForumPost[]|Answer[]|Question[]
     */
    public static function getCollection( $parent_id = NULL, $provider_id = NULL, $is_archived = FALSE, $page = NULL, $page_size = NULL )
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        $args = array();
        $posts = [];

        $sql = "
            SELECT
                *
            FROM
                " . $wpdb->prefix . self::TABLE_NAME . "
            WHERE
                id > 0";

        if ( $parent_id !== NULL )
        {
            $sql .= "
                AND parent_id = %d";
            $args[] = $parent_id;
        }
        else
        {
            $sql .= "
                AND parent_id IS NULL";
        }

        if ( $provider_id !== NULL )
        {
            $sql .= "
                AND provider_id = %d";
            $args[] = $provider_id;
        }

        if ( $is_archived !== NULL )
        {
            $sql .= "
                AND is_archived = %d";
            $args[] = ( $is_archived ) ? 1 : 0;
        }

        $sql .= "
            ORDER BY
                is_sticky DESC,
                updated_at ASC";

        if ( $page_size !== NULL || $page !== NULL )
        {
            if ( $page_size == NULL || ! is_numeric( $page ) )
            {
                $page_size = Question::PAGE_SIZE;
            }
            else
            {
                $page_size = abs( round( $page_size ) );
            }

            if ( $page == NULL || ! is_numeric( $page ) )
            {
                $page = 1;
            }
            else
            {
                $page = abs( round( $page ) );
            }

            $sql .= "
                LIMIT " . $page_size . ' OFFSET ' . ( $page_size * ( $page - 1 ) );
        }

        $sql = $wpdb->prepare( $sql, $args );

        if ( $rows = $wpdb->get_results( $sql ) )
        {
            foreach ( $rows as $row )
            {
                $post = new ForumPost;
                $post->loadFromObject( $row );
                $posts[ $post->getId() ] = $post;
            }
        }

        return $posts;
    }
}