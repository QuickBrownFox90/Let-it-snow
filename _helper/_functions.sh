#!/bin/bash

HELPER_DIR="$(dirname "$(realpath "$0")")"

# load setting variables
. ${HELPER_DIR}/_vars.sh

log () {
    case $1 in
        info)
            echo -e "${OFFSET}${CYAN}[INFO]${NC}     $2"
        ;;
        warning)
            echo -e "${OFFSET}${YELLOW}[WARNING]${NC}  $2"
        ;;
        error)
            echo -e "${OFFSET}${RED}[ERROR]${NC}    $2"
        ;;
        success)
            echo -e "${OFFSET}${GREEN}[SUCCESS]${NC}  $2"
            echo ""
        ;;
        question)
            echo -e "${OFFSET}${MAGENTA}[QUESTION]${NC} $2"
        ;;
        none)
            echo -e "${WIDE_OFFSET}$2"
        ;;
    esac
}

get_version () {
    local CURRENT_VERSION=$( jq -r '.version' ${HELPER_DIR}/../package.json )
    echo "${CURRENT_VERSION}"
}

get_repo_service () {
    echo "${REPO_SERVICE}" #from _vars.sh
}

get_repo_name () {
    local REPO_NAME=$( jq -r '.name' ${HELPER_DIR}/../package.json )
    echo "${REPO_NAME}"
}

get_deploy_method () {
    echo "${DEPLOY_METHOD}" #from _vars.sh
}

get_deploy_server () {
    echo "${DEPLOY_SERVER}" #from _vars.sh
}

get_deploy_username () {
    echo "${DEPLOY_USER}" #from _vars.sh
}

get_deploy_directory () {
    echo "${DEPLOY_DIR}" #from _vars.sh
}