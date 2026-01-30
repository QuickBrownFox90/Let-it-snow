module.exports = function (grunt) {
    var config = {
        dependency: {
            src: [
                'package.json',
                'bower.json'
            ]
        },
        rcfiles: {
            src: [
                '.stylelintrc',
                '.eslintrc.json',
                '.bowerrc'
            ]
        },
        js: {
            src: [
                '<%=project.js%>_js.json',
            ]
        }
    };

    return config;
}