module.exports = function (grunt) {
    var config = {
        build: {
            files: [
                { src: '<%=project.base%>*.php', dest: '<%=project.build.base%>' },
                { src: '<%=project.base%>license.md', dest: '<%=project.build.base%>' },
                { src: '<%=project.inc%>**', dest: '<%=project.build.base%>' },
                { src: '<%=project.dist.js%>**', dest: '<%=project.build.base%>' }
            ]
        }
    };

    return config;
}