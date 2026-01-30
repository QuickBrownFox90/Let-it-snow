module.exports = function (grunt) {

    var config = {
        concatDev: {
            files: [
                '<%=project.js%>**/*.js',
                '<%=project.js%>*.json',
            ],
            tasks: [ 'concat:dev', 'babel' ],
            options: {
                spawn: false,
                livereload: {
                    port: 9003
                }
            }
        },
        inc: {
            files: [ '<%=project.base%>**/*.php' ],
            options: {
                spawn: false,
                livereload: {
                    port: 9003
                }
            }
        }
    };

    return config;
}
