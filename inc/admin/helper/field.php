<?php

/**
 * Admin options form field helper
 * @version     1.0.0
 * @author      Patrick Mauersberger
 *
 * @package     QBF
 * @subpackage  Let_It_Snow
 */


namespace QBF\Let_It_Snow\Admin\Helper;

use QBF\Let_It_Snow\Core as Plugin;


/**
 * Admin options form field helper class to generate a options page fields inside an `Section`.
 * @version     1.0.0
 * @author      Patrick Mauersberger
 */

class Field {

    const CSS_CLASS_NAME = 'let-it-snow';

    /**
     * Constructs a wrapper object for WordPress native `add_settings_field()` and `register_setting()` functions.
     * @since   1.0.0
     * @access  public
     *
     * @see     https://developer.wordpress.org/reference/functions/add_settings_field/  To learn about adding settings fields
     *
     * @param   array<string,mixed>  $_args  The field arguments. Should contain: string `id`, string `title`, string `type`, string `section` (identifier), string `area` (identifier), array `attr` (WP native setting field arguments)
     */

    public function __construct( $_args ) {

        add_settings_field(
            $_args['id'],
            $_args['title'],
            [ $this, strval( 'add_' . $_args['type'] ) ],
            $_args['section'],
            $_args['area'],
            $_args['attr']
        );

        register_setting( $_args['area'], $_args['id'] );
    }

    /**
     * Helper function, adding a textarea and handle the options value
     * @since   1.0.0
     * @access  public
     *
     * @param   string|array  $_args  Arguments, as string: WP Option key, as array: WP Option key and field description as strings
     * @return  void
     */

    public function add_textarea( $_args ) {
        if ( is_array( $_args ) )
            echo    '<textarea class="regular-text" name="' . $_args[0] . '" id="' . $_args[0] . '">' . get_option( $_args[0] ) . '</textarea><br>'.
                    '<p class="description">' . __( 'Voreinstellung:', Plugin::get_prefix() ) . ' ' . $_args[1] . '</p>';
        else
            echo '<textarea class="regular-text" name="' . $_args . '" id="' . $_args . '">' . get_option( $_args ) . '</textarea>';
    }


    /**
     * Helper function, adding a textarea and handle the options value
     * @since   1.0.0
     * @access  public
     *
     * @param   string|array  $_args  Arguments, as string: WP Option key, as array: WP Option key and field description as strings
     * @return  void
     */

    public function add_wysiwyg( $_args ) {
        wp_editor( htmlspecialchars_decode( get_option( $_args ) ), $_args, array( "media_buttons" => false ) );
    }



    /**
     * Helper function, adding a text input and handle the options value
     * @since   1.0.0
     * @access  public
     *
     * @param   string  $_args  WP Options key
     * @return  void
     */

    public function add_input( $_args ) {
        echo '<input type="text" class="regular-text" name="' . $_args . '" id="' . $_args . '" value="' . @get_option( $_args ) . '" />';
    }


    /**
     * Helper function, adding a text input and handle the options value
     * @since   1.0.0
     * @access  public
     *
     * @param   string  $_args  WP Options key
     * @return  void
     */

    public function add_url( $_args ) {
        echo '<input type="url" class="regular-text" name="' . $_args . '" id="' . $_args . '" value="' . @get_option( $_args ) . '" />';
    }


    /**
     * Helper function, adding a number input and handle the options value
     * @since   1.0.0
     * @access  public
     *
     * @param   string  $_args  WP Options key
     * @return  void
     */

    public function add_number( $_args ) {
        echo '<input type="number" class="regular-text" name="' . $_args . '" id="' . $_args . '" value="' . ( ( @get_option( $_args ) ) ? get_option( $_args ) : '0' ) . '" />';
    }


    /**
     * Helper function, adding a checkbox and handle the options value
     * @since   1.0.0
     * @access  public
     *
     * @param   string  $_args  WP Options key
     * @return  void
     */

    public function add_checkbox( $_args ) {
        echo '<input type="checkbox" name="' . $_args . '" id="' . $_args . '" value="use" ' . ( ( get_option( $_args ) == 'use' ) ? 'checked=""' : '' ) . ' ><label for="' . $_args . '"> ' . __( 'Yes', Plugin::get_prefix() ) . '</label>';
    }


    /**
     * Helper function, adding a selectbox to select a page and handle the options value
     * @since   1.0.0
     * @access  public
     *
     * @param   string  $_args  WP Options key
     * @return  void
     */

    public function add_page_select( $_args ) {

        $current_value = @get_option( $_args );

        $args = array(
            'post_type'      => 'page',
            'posts_per_page' => -1,
            'status'         => 'publish'
        );

        $pages = new \WP_Query( $args );

        if ( $pages->have_posts() ) {

            $options = '<option value="0">' . __( 'none', Plugin::get_prefix() ) . '</option>';
            $current_option = '';

            while ( $pages->have_posts() ) {
                $pages->the_post();

                $post_id = get_the_ID();

                if ( $post_id == $current_value )
                    $current_option .= '<option value="' . $post_id . '" selected="selected">' . get_the_title() . '</option>';
                else
                    $options .= '<option value="' . $post_id . '">' . get_the_title() . '</option>';
            }

            echo '<select name="' . $_args . '" id="' . $_args . '">';
            echo $current_option;
            echo $options;
            echo '</select>';

            wp_reset_postdata();
        }

        else
            printf( __( '%sYou did not have any page.%s', Plugin::get_prefix() ), '<p><em>', '</em></p>' );
    }
}