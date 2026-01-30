/**
 * JS magic
 * @since   1.0.0
 * @author  Patrick Mauersberger
 */

( function( win, doc ) {
    'use strict';

    /**
     * Kickstart the global project JS
     */

    win.letItSnow = new Project();
    const P     = win.letItSnow;

    /**
     * You can store all your objects in Projects components variable
     * to make them accessible from every where in your project.
     *
     * For this use the component setter method from class Project
     * Project.component = [ 'name', object ];
     * @see  _assets/js/base.js
     */

    /**
     * Let it snow
     */

    if ( typeof Snow !== 'undefined' ) {

        const canvas = doc.querySelector( '.qbf_let-it-snow' );

        if ( canvas )
            P.component = [ 'snow', new Snow( canvas, 250, true ) ];
    }

} ) ( window, document );
