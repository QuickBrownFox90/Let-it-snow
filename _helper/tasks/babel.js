module.exports = function (grunt) {
    var config = {
        options: {
            sourceMap: true,
            sourceType: 'script',
            presets: [ '@babel/preset-env' ],
        },
        dist: {
            files: {
                '<%=project.dist.js%>let-it-snow.js': '<%=project.dist.js%>let-it-snow.js'
            }
        }
    };

    return config;
}