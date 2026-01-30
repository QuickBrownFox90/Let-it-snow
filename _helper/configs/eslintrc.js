const globals = require( 'globals' );

// Fix the globals "AudioWorkletGlobalScope " has leading or trailing whitespace
const GLOBALS_BROWSER = Object.assign( {}, globals.browser, {} );

delete GLOBALS_BROWSER['AudioWorkletGlobalScope '];

module.exports = [{
    rules: {
        "indent": [
            "error",
            4,
            {
                "SwitchCase": 1
            }
        ],
        "linebreak-style": [
            "error",
            "unix"
        ],
        "quotes": [
            "error",
            "single"
        ],
        "semi": [
            "error",
            "always"
        ],
        "no-undef": [
            "error",
            {
                "typeof": false
            }
        ],
        "no-unused-vars": [
            1,
            {
                "vars": "local",
                "args": "after-used"
            }
        ],
        "new-cap": 1,
        "no-invalid-this": 1,
        "object-curly-spacing": 0
    },

    languageOptions: {

        parserOptions: {
            ecmaVersion: 6,
            sourceType: "script",

            ecmaFeatures: {
                arrowFunctions: true,
                binaryLiterals: true,
                blockBindings:  true,
                classes:        true
            }
        },

        globals: {
            ...GLOBALS_BROWSER,

            Project:             true,
            Snow:                true,
            QBF_snow_wpOptions: true,
        },
    }
}];