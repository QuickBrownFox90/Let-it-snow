/**
 * This class describes the main project
 * @since   1.0.0
 * @author  Patrick Mauersberger
 *
 * @class   Project
 */


class Project {

    constructor() {
        const P = this;

        P._win  = window;
        P._doc  = document;
        P._body = document.body;

        P.components = {};
    }

    /**
     * Setter method to collect project components
     *
     * @type    obj
     * @param   array  comp  A key value pair like: [ 'objectName', classObject ]
     * @return  void
     */

    set component( comp ) {
        this.components[comp[0]] = comp[1];
    }


    /**
     * Check for client has touch support
     * @since   Version 1.0.0
     *
     * @return  bool  True if client supports touch inputs
     */

    supportsTouch() {
        const P = this;

        //if ('ontouchstart' in P._doc.documentElement)
        if ( ( 'ontouchstart' in P._win ) || ( navigator.MaxTouchPoints > 0 ) || ( navigator.msMaxTouchPoints > 0 ) )
            return true;

        else
            return false;
    }


    /**
     * Check for client supports flexbox
     * @since   Version 1.0.0
     *
     * @return  bool  True if client supports touch inputs
     */

    supportsFlexbox() {
        const P = this;

        const body  = P._doc.body || P._doc.documentElement;
        const style = body.style;

        if ( ( style.webkitFlexWrap == '' || style.msFlexWrap == '' || style.flexWrap == '' ) )
            return true;

        else
            return false;
    }
}