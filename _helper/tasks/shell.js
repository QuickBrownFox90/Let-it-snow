module.exports = function (grunt) {
    var config = {
        checkAlert: {
            command: 'grep -R "alert(" <%=project.js%>'
        },
        checkConsole: {
            command: 'grep -R "console.log(" <%=project.js%>'
        },
        zip: {
            command: 'cd <%=project.build.dir%> && zip -rom let-it-snow_<%=project.build.version%>.zip let-it-snow/'
        },
        todo: {
            command: 'grep -lir --color --exclude-dir=node_modules --exclude-dir=libs --exclude-dir=.git --exclude=*.md "todo"'
        },
        noticeBuild: {
            command: 'echo "\nPS: \033[0;35mDid you update your project version?\033[0m\n\nIf not, but necessary, use the command \033[0;36m./_helper/version.sh\033[0m or \033[0;36mproject-version\033[0m\nPlease, don\'t forget this before the last COMMIT before DEPLOY!"'
        },
        options: {
            stdout: true
        }
    };

    return config;
}