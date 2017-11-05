<?php

namespace WaSnap;

class Util {

    /**
     * @param $string
     *
     * @return string
     */
    public static function getString( $string )
    {
        return ( $string === NULL ) ? '' : trim( $string );
    }

    /**
     * @param $bool
     *
     * @return bool
     */
    public static function setBool( $bool )
    {
        return ( $bool === TRUE || $bool == 1 );
    }

    /**
     * @param $bool
     *
     * @return bool
     */
    public static function getBool( $bool )
    {
        return ( $bool === TRUE );
    }

    /**
     * @param $date
     *
     * @return false|null|string
     */
    public static function setDate( $date )
    {
        if ( ! $date )
        {
            return NULL;
        }

        if ( is_numeric( $date ) )
        {
            return date( 'Y-m-d H:i:s', $date );
        }

        return ( date( 'Y-m-d H:i:s', strtotime( $date ) ) );
    }

    /**
     * @param $date
     * @param string $format
     *
     * @return false|string
     */
    public static function getDate( $date, $format = 'Y-m-d H:i:s' )
    {
        if ( ! $date )
        {
            return '';
        }

        if ( is_numeric( $date ) )
        {
            return date( $format, $date );
        }

        return ( date( $format, strtotime( $date ) ) );
    }

    /**
     * @param $url
     *
     * @return string
     */
    public static function getUrl( $url )
    {
        $url = self::getString( $url );

        if ( strlen( $url ) > 0 && substr( strtolower( $url ), 0, 4 ) !== 'http' )
        {
            $url = 'http://' . $url;
        }

        return $url;
    }
}