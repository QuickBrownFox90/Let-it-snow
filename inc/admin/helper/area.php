<?php

/**
 * Admin options area
 * @version     1.0.0
 * @author      Patrick Mauersberger
 *
 * @package     QBF
 * @subpackage  Let_It_Snow
 */

namespace QBF\Let_It_Snow\Admin\Helper;

use QBF\Let_It_Snow\Core as Plugin;

/**
 * Admin options area helper class to generate a options page `Area` and hold different `Sections` that containing the form fields.
 * @version     1.0.0
 * @author      Patrick Mauersberger
 */

class Area {

    /**
     * @since   1.0.0
     * @access  protected
     * @var     QBF\Let_It_Snow\Admin\Helper\Sections[]  $sections  Simple class buffer for added section objects
     */

    protected $sections = [];


    /**
     * @since 1.0.0
     * @access  public
     * @var     string  $id  The current area identifier.
     */

    var       $id;


    /**
     * Constructs a new instance.
     * @since   1.0.0
     * @access  public
     *
     * @param   string  $_id  The identifier
     */

    public function __construct( $_id ) {
        $this->id = Plugin::get_prefix() . '_' . $_id;
    }


    /**
     * Print a the areas buffered sections. This is a wrapper for WordPress native `settings_field()`, `do_settings_sections()` and submit_button() functions to build all setting section forms in the current area.
     * @since   1.0.0
     * @access  public
     *
     * @see     https://developer.wordpress.org/reference/functions/do_settings_sections/  For more information
     *
     * @return  void
     */
    public function print() {

        $A = $this; // A means Area

        settings_fields( $A->get_ID() );

        foreach ( $A->get_sections() as $section_id ) {
            echo '<div class="card wp-options__card">';
            do_settings_sections( $section_id );
            echo '</div>';
        }

        submit_button();
    }


    /**
     * Gets the area ID.
     * @since   1.0.0
     * @access  private
     *
     * @return  string  The current area identifier.
     */

    private function get_ID() {
        return $this->id;
    }


    /**
     * Gets the sections buffer class variable.
     * @since   1.0.0
     * @access  private
     *
     * @return  QBF\Let_It_Snow\Admin\Helper\Sections[]  The buffered section objects as array
     */

    private function get_sections() {
        return $this->sections;
    }


    /**
     * Get a section.
     * @since   1.0.0
     * @access  public
     *
     * @param   string   $_id     The section identifier
     * @param   string   $_title  The section title
     *
     * @return  QBF\Let_It_Snow\Admin\Helper\Sections  A section object
     */

    public function add_section( $_id, $_title ) {

        $A = $this; // A means Area

        $args = array(
            'area'     => $A->get_ID(),
            'id'       => Plugin::get_prefix() . '_' . $_id,
            'title'    => $_title,
            'callback' => null,
        );

        $section = new Section( $args );
        $A->sections[] = $section->get_ID();

        return $section;
    }
}