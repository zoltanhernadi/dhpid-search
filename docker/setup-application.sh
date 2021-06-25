#!/bin/bash
# set the script to exit if any errors are encounters
set -e

DEFAULT_SECRET_FILE_PATH="/run/secrets/secrets.sh"

# logging functions
app_log() {
    local type="$1"; shift
    printf '%s [%s] [Entrypoint]: %s\n' "$(date --rfc-3339=seconds)" "$type" "$*"
}
app_note() {
    app_log Note "$@"
}
app_warn() {
    app_log Warn "$@" >&2
}
app_error() {
    app_log ERROR "$@" >&2
    exit 1
}

# Verify that path to an existing secret file was given
docker_verify_minimum_env() {
    # if a var is named SECRET_FILE_PATH and is not empty...
    if [ -n "$SECRET_FILE_PATH" ]; then
        # ...and the is the path to an existing file...
        if [ -f "$SECRET_FILE_PATH" ]; then
            # ...then execute that file (should be only setting vars)
            app_note 'Using specified secret file'
            #. "$SECRET_FILE_PATH"
        else
            # ... if the file does not exists, throw an error
            app_error 'The specified secret file not found.'
        fi
    elif [ -f "$DEFAULT_SECRET_FILE_PATH" ]; then
        # ... if the var is not defined, but the default file exists use it
        app_note 'Using default secret file'
        #. "$DEFAULT_SECRET_FILE_PATH"
	SECRET_FILE_PATH=${DEFAULT_SECRET_FILE_PATH}
    else
        # ... if not, throw an error that the secret file cannot be located
        app_error "Secret file not found. File $DEFAULT_SECRET_FILE_PATH must exists or specify the new location with the env variable SECRET_FILE_PATH"
    fi

    # if we don't have the minimum variables needed for the application throw another error.
    if [ -z "BASE_URL" ] && [ -z "DB_HOST" ] && [ -z "DB_USER" ] && [ -z "DB_PASSWORD" ] && [ -z "ADMIN_PASSWORD" ] && [ -z "GC_NOTIFY_API_KEY" ]; then
        app_error 'Some mandatory variable were not found in the secret file. Please see the *-secrets.sh.dist for the variable to set.'
    fi
}
docker_verify_minimum_env

#bash install.sh $DB_USER $DB_PASS $DB_HOST $DB_AHR $DB_CTO $DB_CTA
bash install.sh ${SECRET_FILE_PATH}
