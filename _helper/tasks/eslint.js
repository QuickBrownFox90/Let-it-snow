module.exports = function (grunt) {
    var config = {
        options: {
            overrideConfigFile: '_helper/configs/eslintrc.js'
        },
        dev: [ '<%=project.js%>*.js' ]
    };

    return config;
}