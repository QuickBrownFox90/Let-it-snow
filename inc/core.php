<?php

/**
 * QBF Let_It_Snow core
 * @version     1.0.0
 * @author      Patrick
 *
 * @package     QBF
 * @subpackage  Let_It_Snow
 */

namespace QBF\Let_It_Snow;

require_once( 'helper/exceptions.php' );
require_once( 'admin/options.php' );

use QBF\Let_It_Snow\Helper\Exception;
use QBF\Let_It_Snow\Admin\Options;


/**
 * QBF Let_It_Snow core class
 * @since       1.0.0
 * @author      Patrick
 */

class Core {

    /**
     * Define constant variables
     * @since   1.0.0
     *
     * @var  string  Prefix  The in plugin use prefix for methods or key or some other stuff like this
     * @var  string  Name    The plugin name
     */

    const Prefix = 'QBF_snow';
    const Name   = 'Let it snow';


    /**
     * Define protected variables
     * @since   1.0.0
     * @access  protected
     *
     * @var     string  $url  The URL to the plugin folder, defined in main constructor
     */

    protected $url = '';


    /**
     * Main class constructor
     * @since   1.0.0
     * @access  public
     *
     * @return  void
     */

    public function __construct() {

        $C = $this; // C means Core

        $C->url = plugin_dir_url( __DIR__ );

        add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );

        if ( ! is_admin() ) {
            add_action( 'wp_enqueue_scripts', [ $this, 'add_script' ] );
            add_action( 'wp_footer', [ $this, 'add_canvas' ] );

            if ( WP_DEBUG ) {
                // this is little bit unconventional, but works very well
                if ( file_exists( QBF_LET_IT_SNOW_ROOT . '/_helper/livereload.php' ) )
                    require_once( QBF_LET_IT_SNOW_ROOT . '/_helper/livereload.php' );
            }
        }

        else
            $Options = new Options( $C );
    }


    /**
     * Add action to load the text domain for translations
     * @since   1.0.0
     * @access  public
     *
     * @return  void
     */

    public function load_textdomain() {
        $C = $this;

        load_plugin_textdomain(
            $C->get_prefix(),
            false,
            plugin_basename( QBF_LET_IT_SNOW_ROOT ) . '/languages/'
        );
    }


    /**
     * Add a javascript to the frontend
     * @since   1.0.0
     * @access  public
     *
     * @return  void
     */

    function add_script() {
        $C = $this;

        if ( ! is_admin() ) {

            wp_enqueue_script(
                self::get_prefix() . '_script',
                $C->get_plugin_url() . 'dist/js/let-it-snow.js',
                null,
                QBF_LET_IT_SNOW_VERSION,
                true
            );

            if ( $color = Options::get( 'color' ) ) // yes one =
                wp_localize_script(
                    self::get_prefix() . '_script',
                    self::get_prefix() . '_wpOptions',
                    [ 'color' => $color ]
                );
        }
    }


    public function add_canvas() {
        echo '<canvas class="qbf_let-it-snow"></canvas>';
    }


    /**
     * Get the plugin prefix
     * @since   1.0.0
     * @static
     *
     * @return  string  The prefix for option keys, meta keys and other stuff like this
     */

    static function get_prefix() {
        return self::Prefix;
    }


    /**
     * Get the plugin prefix
     * @since   1.0.0
     * @static
     *
     * @return  string  The prefix for option keys, meta keys and other stuff like this
     */

    static function get_name() {
        return self::Name;
    }


    /**
     * Get the plugin path url
     * @since   1.0.0
     * @access  public
     *
     * @return  string  The path to the plugin directory
     */

    public function get_plugin_url() {
        return $this->url;
    }
}