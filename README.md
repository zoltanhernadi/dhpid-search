# DHPID Deployment Packages

The scripts in this repository facilitate the deployment of the DHPID admin portal and search sites to the IMSD cloud environment.

Jenkins is used as the deployment orchestrator, which builds two Docker images (admin and search) and then deploys them as running containers on the appropriate host (dev, test, or production).

## Pipeline Overview

Here is a broad overview of the deployment pipeline:

1. HC's Jenkins service has hooks into the HC GitHub Enterprise repositories, and will spin up a new deployment upon any commit to the master branch of a hooked repository.
1. Jenkins begins by invoking a fresh build of a Docker image based on the latest Dockerfile (`admin/docker/Dockerfile` or `search/docker/Dockerfile`)
1. Once the latest Dockerfile has been used to create a new docker image, this image is pushed to [Artifactory](https://jfrog.com/artifactory/)
1. In the "Deploy to Dev" stage, Jenkins invokes the script {admin,search}/container.sh which finalizes the deployment.
1. The container.sh script creates a new docker container based on the image pushed to Artifactory earlier, and then starts this container with appropriate network parameters to expose tcp/443 and to ensure that the database service can be contacted using TLS by mapping a specific hostname to a specific internal IP address.
1. Finally, the container.sh script starts the Docker container and invokes `/install.sh` which sets up the Laravel environments (configures `.env`, invokes `php artisan key:generate`, and sets filesystem ownership and permissions). Once Laravel has been configured, the `install.sh` script runs Apache HTTPD in the foreground.

## Notes

* Xelerance has R/W and full root-level access to IMSD's DEV environment; R/O in TEST; No direct access to PROD.
* It is necessary to configure the "{admin,search}_secrets.sh" file based on the included sample with appropriate settings (database credentials, hostnames, etc) for each environment.

## Cloud Deployment Instructions

In order to setup the Dev, Test, and Production environments it is necessary to perform the following tasks:

### Create Databases

For each DHPID search programme a database is required to hold the inspection records. Currently this application provides three searches: AHR/DSO, CTO, and CTA/GCP.

The dhpid-admin application should be configured with database credentials providing full access to modify records in the database. The dhpid-search application should be configured with database credentials which are limited to providing records to the application only (i.e. "SELECT" privilege).

1. Identify the hostname and IP address used to connect to the database service.
1. Identify the hostname from which database requests originate (the environment VM's IP address); This is required to identify SQL users as 'user'@'host'.
1. Create one database for each DHPID search programme being deployed:
    ```sql
    CREATE DATABASE `dhpid-ahr`;
    CREATE DATABASE `dhpid-cto`;
    CREATE DATABASE `dhpid-cta`;
    ```
1. Create an administrative database user with ALL PRIVILEGES. This is the user for the dhpid-admin web application:
    ```sql
    # Replace "x.x.x.x" with the IP or hostname from which the database connections will originate (the web server)
    # Replace "Set A Password Here" with a strong password
    CREATE USER `dhpid-admin`@`x.x.x.x` IDENTIFIED BY "Set A Password Here";
    GRANT ALL PRIVILEGES on `dhpid-ahr`.* to `dhpid-admin`@`x.x.x.x`;
    GRANT ALL PRIVILEGES on `dhpid-cto`.* to `dhpid-admin`@`x.x.x.x`;
    GRANT ALL PRIVILEGES on `dhpid-cta`.* to `dhpid-admin`@`x.x.x.x`;
    ```
1. Create a search database user with only SELECT privilege. This is the user for the dhpid-search web application:
    ```sql
    # Replace "x.x.x.x" with the IP or hostname from which the database connections will originate (the web server)
    # Replace "Set A Password Here" with a strong password
    CREATE USER `dhpid-search`@`x.x.x.x` IDENTIFIED BY "Set A Password Here";
    GRANT SELECT on `dhpid-ahr`.* to `dhpid-search`@`x.x.x.x`;
    GRANT SELECT on `dhpid-cto`.* to `dhpid-search`@`x.x.x.x`;
    GRANT SELECT on `dhpid-cta`.* to `dhpid-search`@`x.x.x.x`;
    ```
1. If this environment is to be deployed using the Jenkins build pipeline, then the database settings including DB hostname, IP address, username, password, and database names must be configured in a "secrets file" contained securely within the Jenkins user home directory. It should be based on the templates provided in this repository (See docker/secrets.sh):
    ```sh
    # Here we invoke `sudo` assuming you are not user "jenkins"
    export JENKINS_SECRETS_PATH="~jenkins/secrets"
    sudo mkdir -p "${JENKINS_SECRETS_PATH}"
    sudo cp docker/secrets.sh "${JENKINS_SECRETS_PATH}/{admin,search}_secrets.sh"
    sudo chown -R jenkins.jenkins "${JENKINS_SECRETS_PATH}"
    sudo chmod 0700 "${JENKINS_SECRETS_PATH}"
    # Edit each admin_secrets.sh and search_secrets.sh now
    sudo chmod 0440 "${JENKINS_SECRETS_PATH}/*"
    ```

This environment is now configured to support automated build jobs invoked by Jenkins.

## TODO

* Both admin and search Jenkinsfile only defines "Deploy to Dev" stage, but not yet "Deploy to Test" or "Deploy to Prod". Will these be necessary?
