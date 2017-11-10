<?php

namespace WaSnap;

class Question extends ForumPost {

    const PAGE_SIZE = 10;

    /** @var Answer[] $answers */
    private $answers;

    /**
     * Question constructor.
     *
     * @param null $id
     * @param bool $load_answers
     */
    public function __construct( $id = NULL, $load_answers = FALSE )
    {
        parent::__construct( $id, $load_answers );
    }

    /**
     * @return Answer[]
     */
    public function getAnswers()
    {
        if ( $this->answers === NULL )
        {
            $this->loadAnswers();
        }

        return $this->answers;
    }

    /**
     * @param Answer[] $answers
     *
     * @return Question
     */
    public function setAnswers( $answers )
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * @param Answer $answer
     *
     * @return $this
     */
    public function addAnswer( $answer )
    {
        if ( $this->answers === NULL )
        {
            $this->answers = array();
        }

        $this->answers[ $answer->getId() ] = $answer;

        return $this;
    }

    public function loadAnswers()
    {
        if ( $this->id !== NULL )
        {
            $this->setAnswers( Answer::getByParentId( $this->id ) );
        }
    }

    /**
     * @return int
     */
    public static function getQuestionCount()
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        $sql = "
            SELECT
                COUNT( * ) AS `count`
            FROM
                " . $wpdb->prefix . self::TABLE_NAME . "
            WHERE
                parent_id IS NULL
                AND is_archived = 0";
        $row = $wpdb->get_row( $sql );

        return $row->count;
    }

    /**
     * @return int
     */
    public static function getPageCount()
    {
        $page_count = 0;
        $total = self::getQuestionCount();

        if ( $total > 0 && $total <= self::PAGE_SIZE )
        {
            $page_count = 1;
        }
        elseif ( $total > self::PAGE_SIZE )
        {
            $page_count = floor( $total / self::PAGE_SIZE );
            if ( $total % self::PAGE_SIZE > 0 )
            {
                $page_count ++;
            }
        }

        return $page_count;
    }

    /**
     * @param $page
     * @param $page_size
     *
     * @return Answer[]|ForumPost[]|Question[]
     */
    public static function getForumQuestions( $page, $page_size = NULL )
    {
        return self::getCollection( NULL, NULL, FALSE, $page, $page_size );
    }
}