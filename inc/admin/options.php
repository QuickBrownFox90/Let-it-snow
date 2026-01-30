<?php

/**
 * Admin options setting
 * @version     1.0.0
 * @author      Patrick Mauersberger
 *
 * @package     P191
 * @subpackage  Let_It_Snow\Admin
 */

namespace QBF\Let_It_Snow\Admin;

require_once( 'helper/area.php' );
require_once( 'helper/section.php' );
require_once( 'helper/field.php' );

use QBF\Let_It_Snow\Core as Plugin;
use QBF\Let_It_Snow\Admin\Helper\Area;
use QBF\Let_It_Snow\Admin\Helper\Section;
use QBF\Let_It_Snow\Admin\Helper\Field;


/**
 * Admin options helper class to generate a admin settings page and load sections, areas und fields into it.
 * @version     1.0.0
 * @author      Patrick Mauersberger
 */

class Options {

    const CSS_CLASS_NAME = 'let-it-snow';

    var $settings;
    var $template_settings;

    private $parent;

    /**
     * Options constructor, add menu button and options page in backend.
     * @since   1.0.0
     * @access  public
     *
     * @param   QBF\Let_It_Snow\Core  $_parent  QBF_Let_It_Snow Core object
     * @return  void
     */

    public function __construct( $_parent ) {

        try {
            if ( ! $_parent instanceof Plugin )
                throw new \Exception( 'The $_parent variable in ' . __METHOD__ . ' must be an object from type <b>QBF\Let_It_Snow\Core</b>', 1 );

            $this->parent = $_parent;
            add_action( 'admin_init', [ $this, 'page_settings' ] );
            add_action( 'admin_menu', [ $this, 'add_to_menu' ] );
        }

        catch ( \Exception $e ) {
            if ( WP_DEBUG )
                print( $e->getMessage() );
        }
    }


    /**
     * Add the menu button, triggered in constructor
     * @since   1.0.0
     * @access  public
     *
     * @return  void
     */

    public function add_to_menu() {

        add_menu_page(
            Plugin::get_name(),
            Plugin::get_name(),
            'manage_options',
            Plugin::get_prefix(),
            [ $this, 'add_page' ],
            'dashicons-cloud',
            99
        );
    }


    /**
     * Add the options page in backend
     * @since   1.0.0
     * @access  public
     *
     * @return  void
     */

    public function add_page() {

        if ( ! current_user_can( 'manage_options' ) )  {
            wp_die( __( 'Du hast keine Rechte um diese Seite zu bearbeiten.', Plugin::get_prefix() ) );
        }

        ?>
        <div class="wrap">
            <h1><?php printf( __( '%1$s Settings', Plugin::get_prefix() ), Plugin::get_name() ); ?></h1>

            <nav class="nav-tab-wrapper">
                <a href="?page=<?php echo $_GET['page']; ?>" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General options', Plugin::get_prefix() ); ?></a>
            </nav>

            <div class="tabs-content">
                <?php
                    $default_tab = null;
                    $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $default_tab;
                ?>

                <?php
                    switch( $tab ) {
                        default :
                            ?>
                                <form id="<?php echo self::CSS_CLASS_NAME; ?>" action="options.php" method="post">
                                    <div class="<?php echo self::CSS_CLASS_NAME; ?>__message"></div>
                                    <?php
                                        $this->settings->print();
                                    ?>
                                </form>
                            <?php
                        break;
                    }
                ?>
            </div>
        </div>
        <?php
    }


    /**
     * Setup for the options page, adding sections and fields
     * @since   1.0.0
     * @access  public
     *
     * @return  void
     */

    public function page_settings() {

        $this->settings = new Area( 'settings' );

        $main_section = $this->settings->add_section( 'main_section', __( 'Main settings', Plugin::get_prefix() ) );

        $main_section->add_field(
            'color',
            __( 'Snow color', Plugin::get_prefix() ),
            'input'
        );

        /**
         * This is a good place to add further options for geolocated settings.
         * I would recommend using the OpenWeather One Call API; I had good experiences with it in the past.
         *
         * After that we need a request handling, maybe with a transient caching on top ...
         *
         * @see  https://openweathermap.org/api/one-call-3?collection=one_call_api_3.0#current
         *

        $main_section->add_field(
            'ow-enable',
            __( 'Enable local weather', Plugin::get_prefix() ),
            'checkbox'
        );

        $main_section->add_field(
            'ow-key',
            __( 'OpenWeather API key', Plugin::get_prefix() ),
            'input'
        );

        $main_section->add_field(
            'ow-location',
            __( 'Geolocation', Plugin::get_prefix() ),
            'input'
        );
        /*__*/
    }


    /**
     * Options helper, to get options faster without thinking about the prefix
     * @since   1.0.0
     * @static
     *
     * @return  mixed  WP options value
     */

    static function get( $_key ) {
        return @get_option( Plugin::get_prefix() . '_' . $_key, false );
    }
}