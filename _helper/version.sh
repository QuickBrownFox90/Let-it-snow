#!/bin/bash

HELPER_DIR="$(dirname "$(realpath "$0")")"

# load functions including settings variables
. ${HELPER_DIR}/_functions.sh


echo ""
echo "┌─────────────────────────────────────────────┐"
echo "│                                             │"
echo "│       WP Plugin Version Helper v1.0.0       │"
echo "│                                             │"
echo "└─────────────────────────────────────────────┘"
echo ""


# functions

help () {
    echo -e "${OFFSET}usage: ./version.sh <option>"
    echo -e "${OFFSET}options:"
    echo -e "${OFFSET}\t-p, --patch           Patch version"
    echo -e "${OFFSET}\t--minor               Minor version"
    echo -e "${OFFSET}\t--major               Major version"
    echo -e "${OFFSET}\t-v, --version  <arg>  Specific version number like '1.12.4'"
    echo -e "${OFFSET}\t-h, --help            Show this help"
    exit 0
}


# parsing arguments

if [[ -n $1 ]]; then
    case $1 in
        -p|--patch)
            PATCH_BUMP=1
        ;;
        --minor)
            MINOR_BUMP=1
        ;;
        --major)
            MAJOR_BUMP=1
        ;;
        -v|--version)
            if [[ -z "$2" ]]; then
                log "error" "You must specify a version number like '1.0.0'"
                echo ""
                help
            fi
            NEW_VERSION=$2
        ;;
        -h|--help)
            help
        ;;
        -*|--*)
            log "error" "Unknown option $1"
            echo ""
            help
        ;;
    esac
else
    log "error" "No option given"
    help
fi


# the real fun

# update the version number string

CURRENT_VERSION_DUMP=$(jq -r '.version' package.json)

if [[ -z "$NEW_VERSION" ]]; then

    if [[ -z "$PATCH_BUMP" ]]; then
        PATCH_BUMP=0
    fi

    if [[ -z "$MINOR_BUMP" ]]; then
        MINOR_BUMP=0
    fi

    if [[ -z "$MAJOR_BUMP" ]]; then
        MAJOR_BUMP=0
    fi

    IFS='.' read -ra CURRENT_VERSION <<< "$CURRENT_VERSION_DUMP"

    MAJOR=${CURRENT_VERSION[0]}
    MINOR=${CURRENT_VERSION[1]}
    PATCH=${CURRENT_VERSION[2]}

    if [[ "$MAJOR_BUMP" -eq 1 ]]; then
        NEW_MAJOR=$( expr $MAJOR + 1 )
        NEW_MINOR=0
        NEW_PATCH=0
    elif [[ "$MINOR_BUMP" -eq 1 ]]; then
        NEW_MAJOR=$MAJOR
        NEW_MINOR=$( expr $MINOR + 1 )
        NEW_PATCH=0
    elif [[ "$PATCH_BUMP" -eq 1 ]]; then
        NEW_MAJOR=$MAJOR
        NEW_MINOR=$MINOR
        NEW_PATCH=$( expr $PATCH + 1 )
    else
        NEW_MAJOR=$MAJOR
        NEW_MINOR=$MINOR
        NEW_PATCH=$PATCH
    fi

    NEW_VERSION=${NEW_MAJOR}.${NEW_MINOR}.${NEW_PATCH}
fi


log "info" "Bump version from ${CYAN}v${CURRENT_VERSION_DUMP}${NC} to ${CYAN}v${NEW_VERSION}${NC}"


# Update the package.json

log "info" "Updating ${CYAN}'package.json'${NC}"
sed -i "" "s/\"version\": \"${CURRENT_VERSION_DUMP}\"/\"version\": \"${NEW_VERSION}\"/g" package.json

log "success" "Done"


log "info" "Updating ${CYAN}'gruntfile.js'${NC}"
sed -i "" "s/'v${CURRENT_VERSION_DUMP}'/'v${NEW_VERSION}'/g" gruntfile.js

log "success" "Done"


# Update the main file

log "info" "Updating ${CYAN}'qbf-let-it-snow.php'${NC}"
sed -i "" "s/${CURRENT_VERSION_DUMP}/${NEW_VERSION}/g" qbf-let-it-snow.php

log "success" "Done"