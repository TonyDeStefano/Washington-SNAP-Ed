<?php

namespace WaSnap;

class Page {

    private $id;
    private $title;
    private $post_name;
    private $guid;
    private $shortcode_page;
    private $shortcode_pages = array(
        '',
        'dashboard',
        'forum',
        'directory'
    );

    public function __construct( $id, $title, $post_name, $guid, $shortcode_page )
    {
        $this
            ->setId( $id )
            ->setTitle( $title )
            ->setPostName( $post_name )
            ->setGuid( $guid )
            ->setShortcodePage( $shortcode_page );
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
     * @return Page
     */
    public function setId( $id )
    {
        $this->id = $id;

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
     * @return Page
     */
    public function setTitle( $title )
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostName()
    {
        return $this->post_name;
    }

    /**
     * @param mixed $post_name
     *
     * @return Page
     */
    public function setPostName( $post_name )
    {
        $this->post_name = $post_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @param mixed $guid
     *
     * @return Page
     */
    public function setGuid( $guid )
    {
        $this->guid = $guid;

        return $this;
    }

    /**
     * @return bool
     */
    public function isProtected()
    {
        return ( in_array( $this->shortcode_page, $this->shortcode_pages ) );
    }

    /**
     * @return mixed
     */
    public function getShortcodePage()
    {
        return $this->shortcode_page;
    }

    /**
     * @param mixed $shortcode_page
     *
     * @return Page
     */
    public function setShortcodePage( $shortcode_page )
    {
        $this->shortcode_page = $shortcode_page;

        return $this;
    }
}