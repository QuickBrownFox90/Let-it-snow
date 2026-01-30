/**
 * This class is a snow machine
 * @since   1.0.0
 * @author  Patrick Mauersberger
 *
 * @class   Snow
 */


class Snow {

    constructor( _canvas, _count, _autostart ) {

        if ( typeof _canvas == 'undefined' )
            return;

        if ( typeof _count == 'undefined' )
            _count = 150;

        if ( typeof _autostart == 'undefined' )
            _autostart = false;

        const S = this;

        S._win    = window;
        S._doc    = document;

        S.canvas  = _canvas;
        S.context = S.canvas.getContext( '2d' );
        S.frame   = S._win.requestAnimationFrame ||
                    S._win.mozRequestAnimationFrame ||
                    S._win.webkitRequestAnimationFrame ||
                    S._win.msRequestAnimationFrame;

        S.flakesCount = _count;
        S.autostart   = _autostart;

        S.setupCanvas();

        S.context.canvas.width  = _canvas.offsetWidth;
        S.context.canvas.height = _canvas.offsetHeight;

        S.snowflakes = [];

        for ( let i = 0; i < S.flakesCount; i++ )
            S.snowflakes[i] = new Snowflake( S.context );

        S.addResizeHandler();

        if ( S.autostart )
            S.loop();
    }


    /**
     * initial styles for the canvas container
     * @since   Version 1.0.0
     *
     * @return  void
     */

    setupCanvas() {
        const S = this;

        S.canvas.style.position      = 'fixed';
        S.canvas.style.top           = '0';
        S.canvas.style.width         = '100%';
        S.canvas.style.height        = '100vh';
        S.canvas.style.pointerEvents = 'none';
        S.canvas.style.zIndex        = '998';
    }


    /**
     * Draw the snowflakes inside the context
     * @since   Version 1.0.0
     *
     * @return  void
     */

    draw() {
        const S = this;

        S.context.clearRect( 0, 0, S.context.canvas.width, S.context.canvas.height );

        for ( var i = 0; i < S.snowflakes.length; i++ )
            S.snowflakes[i].draw();
    }


    /**
     * Update the snowflakes
     * @since   Version 1.0.0
     *
     * @return  void
     */

    update() {
        const S = this;

        for ( var i = 0; i < S.snowflakes.length; i++ )
            S.snowflakes[i].update();
    }


    /**
     * Add a resize handler in window
     * @since   Version 1.0.0
     *
     * @return  void
     */

    addResizeHandler() {
        const S = this;

        S._win.onresize = function() {
            S.context.canvas.width  = S.canvas.offsetWidth;
            S.context.canvas.height = S.canvas.offsetHeight;

            for ( var i = 0; i < S.snowflakes.length; i++ )
                S.snowflakes[i].resized;
        };
    }


    /**
     * The main animation loop
     * @since   Version 1.0.0
     *
     * @return  void
     */

    loop() {
        const S = this;

        const go = function() {
            S.draw();
            S.update();
            S.loop();
        };

        S.frame.call( window, go );
    }
}


/**
 * This class describes a single snowflake
 * @since   1.0.0
 * @author  Patrick Mauersberger
 *
 * @class   Snowflake
 */

class Snowflake {

    constructor( _context ) {

        const SF = this;

        SF.context   = _context;
        SF.x         = SF.random( 0, SF.context.canvas.width );
        SF.y         = SF.random( -SF.context.canvas.height, 0 );
        SF.radius    = SF.random( .5, 3.0 );
        SF.speed     = SF.random( 1, 3 );
        SF.wind      = SF.random( -.5, 3.0 );
        SF.isResized = false;
    }


    /**
     * Draw a the snowflake
     * @since   Version 1.0.0
     *
     * @return  void
     */

    draw() {
        const SF = this;

        let color = '#fff';

        if ( typeof QBF_snow_wpOptions != 'undefined' )
            color = QBF_snow_wpOptions.color;

        SF.context.beginPath();
        SF.context.arc( SF.x, SF.y, SF.radius, 0, 2 * Math.PI );
        SF.context.fillStyle = color;
        SF.context.fill();
        SF.context.closePath();
    }


    /**
     * Update the snowflake
     * @since   Version 1.0.0
     *
     * @return  void
     */

    update() {

        const SF = this;

        SF.y += SF.speed;
        SF.x += SF.wind;

        if ( SF.y > SF.context.canvas.height ) {
            if ( SF.isResized ) {

                SF.x = SF.random( 0, SF.context.canvas.width );
                SF.y = SF.random( -SF.context.canvas.height, 0 );

                SF.isResized = false;

            }

            else {
                SF.y = 0;
                SF.x = SF.random( 0, SF.context.canvas.width );
            }
        }
    }


    /**
     * Setter for resize attribute
     * @since   Version 1.0.0
     *
     * @param   bool  bool  Optional
     * @return  void
     */

    set resized( bool = true ) {
        const SF = this;

        SF.isResized = bool;
    }


    /**
     * Helper function to generate random number between a given range
     * @since   Version 1.0.0
     *
     * @param   int   min  Minimum value
     * @param   int   max  Maximum value
     * @return  int        A random number between the given range
     */

    random( min, max ) {

        let rand = ( min + Math.random() * ( max - min ) ).toFixed( 1 );
        rand = Math.round( rand );

        return rand;
    }
}


