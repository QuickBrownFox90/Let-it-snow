<?php

/**
 * Custom exceptions
 * @version     1.0.0
 * @author      Patrick Mauersberger
 *
 * @package     QBF
 * @subpackage  Let_It_Snow
 */

namespace QBF\Let_It_Snow\Helper;


/**
 * Let_It_Snow custom exception helper class
 * @since       1.0.0
 * @author      Patrick Mauersberger
 */

class Exception extends \Exception {

    public function __construct( $_message, $_code = 0, Throwable $_previous = null ) {
        parent::__construct( $_message, $_code, $_previous );
    }

    /**
     * Print an exception on debug condition or send a json response if doing AJAX
     * @since   1.0.0
     *
     * @return  void
     */

    public function print() {

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            header( 'Content-Type', 'application/json' );
            echo json_encode( [ status => 'failed', msg => $this->getMessage() ] );
            wp_die();
        }

        else
            if ( WP_DEBUG ) {
                print( '<pre>' );
                print( $this->getMessage() );
                print( '</pre>' );
            }
    }
}