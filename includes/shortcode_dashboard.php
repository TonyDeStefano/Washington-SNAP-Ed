<?php

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

/** @var \WaSnap\Controller $this */

echo $this->content;
include( 'shortcode_forum.php' );