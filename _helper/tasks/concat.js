module.exports = function (grunt) {
    var config = {
        dev: {
            options: {
                sourceMap: true,
            },
            src: [
                '<%=project.jsconf.src%>'
            ],
            dest: '<%=project.dist.js%>let-it-snow.js',
            nonull: true
        },
        build: {
            src: '<%=project.jsconf.src%>',
            dest: '<%=project.dist.js%>let-it-snow.js',
            nonull: true,
        }
    };

    return config;
}