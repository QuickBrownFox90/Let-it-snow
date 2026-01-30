module.exports = function (grunt) {
    var config = {
        build: {
            files: [{
                expand: true,
                cwd: '<%=project.dist.js%>',
                src: '**/*.js',
                dest: '<%=project.dist.js%>'
            }]
        }
    };

    return config;
}