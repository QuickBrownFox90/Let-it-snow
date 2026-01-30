<?php

/**
 * Admin options section
 * @version     1.0.0
 * @author      Patrick Mauersberger
 *
 * @package     QBF
 * @subpackage  Let_It_Snow
 */

namespace QBF\Let_It_Snow\Admin\Helper;

use QBF\Let_It_Snow\Core as Plugin;


/**
 * Admin options section helper class to generate a options page section inside an `Area` and hold the form fields
 * @version     1.0.0
 * @author      Patrick Mauersberger
 */

class Section {

    protected $id   = '';
    protected $area = '';

    /**
     * Constructs a wrapper object for WordPress native `add_settings_section()` function.
     * @since   1.0.0
     * @access  public
     *
     * @see     https://developer.wordpress.org/reference/functions/add_settings_section/  For getting a glue how WordPress adds settings sections
     *
     * @param   array  $_args  The section arguments, should containing: string `area`, string `title`, callable `callback`, string `id`
     */

    public function __construct( $_args ) {

        $S       = $this;
        $S->id   = $_args['id'];
        $S->area = $_args['area'];

        add_settings_section(
            $_args['area'],
            $_args['title'],
            $_args['callback'],
            $_args['id']
        );
    }

    /**
     * Adds a form field object from type `QBF\Let_It_Snow\Admin\Helper\Field`
     * @since   1.0.0
     * @access  public
     *
     * @param   string  $_id     The form field identifier
     * @param   string  $_title  The form field title
     * @param   string  $_type   The form field type
     * @param   string  $_desc   The form field description
     *
     * @return  QBF\Let_It_Snow\Admin\Helper\Field   A admin option form field object
     */

    public function add_field( $_id, $_title, $_type, $_desc = null ) {

        $S = $this;

        $field_id = Plugin::get_prefix() . '_' . $_id;

        $args = array(
            'id'       => $field_id,
            'title'    => $_title,
            'type'     => $_type,
            'section'  => $S->get_ID(),
            'area'     => $S->get_area(),
            'attr'     => ( $_desc == null ) ? $field_id : [ $field_id, $_desc ]
        );

        return new Field( $args );
    }


    /**
     * Get the sections ID
     * @since   1.0.0
     * @access  public
     *
     * @return  string  The section Identifier.
     */

    public function get_ID() {
        return $this->id;
    }


    /**
     * Get the parent area object.
     * @since   1.0.0
     * @access  private
     *
     * @return  QBF\Let_It_Snow\Admin\Helper\Area  The parent area object.
     */

    private function get_area() {
        return $this->area;
    }
}