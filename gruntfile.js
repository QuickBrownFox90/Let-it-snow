module.exports = function( grunt ) {
    'use strict';

    const projectName    = 'let-it-snow';
    const projectVersion = 'v1.0.0'; // will be updated if you use the version update helper in `_helper/version.sh`

    const assetsFolder = '_assets/';
    const distFolder   = 'dist/';
    const tasksFolder  = '_helper/tasks/';

    // Load Grunt tasks automatically
    require( 'load-grunt-tasks' )( grunt, { scope: [ 'devDependencies', 'dependencies' ] } );

    /* config grunt
    ------------------------------------------------- */
    grunt.initConfig( {
        project: {
            base:     './',
            inc:      'inc/',

            dist: {
                js:    distFolder + 'js/',
            },

            js:        assetsFolder + 'js/',
            libs:      '_libs/',

            jsconf:    require( './' + assetsFolder + 'js/_js.json' ),

            build: {
                version: projectVersion,
                name:    projectName,
                dir:     'build/',
                base:    'build/' + projectName + '/',
                css:     'build/' + projectName + '/dist/',
                inc:     'build/' + projectName + '/inc/'
            }
        },


        /* watching
        ------------------------------------------------- */
        watch: require( './' + tasksFolder + 'watch' )( grunt ),

        /* code linting
        ------------------------------------------------- */
        jsonlint:  require( './' + tasksFolder + 'jsonlint' )( grunt ),
        eslint:    require( './' + tasksFolder + 'eslint' )( grunt ),

        /* js
        ------------------------------------------------- */
        concat: require( './' + tasksFolder + 'concat' )( grunt ),
        babel:  require( './' + tasksFolder + 'babel' )( grunt ),
        uglify: require( './' + tasksFolder + 'uglify' )( grunt ),

        /* misc
        ------------------------------------------------- */
        shell: require( './' + tasksFolder + 'shell' )( grunt ),
        copy:  require( './' + tasksFolder + 'copy' )( grunt ),
    });

    /* register tasks
    ------------------------------------------------- */
    grunt.registerTask( 'default', [ 'watch' ] );

    grunt.registerTask( 'lint', [ 'jsonlint', 'eslint' ] );
    grunt.registerTask( 'check', [ 'shell:checkAlert', 'shell:checkConsole', 'shell:todo' ] );

    grunt.registerTask( 'js', [ 'concat', 'babel' ] );
    grunt.registerTask( 'js-min', [ 'concat:build', 'concat:buildLegacy', 'babel', 'uglify' ]);

    /*
        main build task
        * linting JS
        * concat JS
        * minify JS
        * coping file in build directory
        * make a zip from build
    */
    grunt.registerTask( 'build', [
        'lint',
        'concat:build',
        'babel',
        'uglify',
        'copy:build',
        'shell:zip'
    ]);

    grunt.registerTask( 'b', ['build'] );
};