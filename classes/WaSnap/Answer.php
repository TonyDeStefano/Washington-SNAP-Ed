<?php

namespace WaSnap;

class Answer extends ForumPost {

    /**
     * @param $parent_id
     * @param bool $is_archived
     *
     * @return Answer[]
     */
    public static function getByParentId( $parent_id, $is_archived = FALSE )
    {
        return self::getCollection( $parent_id, NULL, $is_archived );
    }
}