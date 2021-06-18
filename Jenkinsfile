/**
 *   Jenkins build script for DHPID public search site
 */

pipeline {
    // Agent label should match the VM hostname
    agent {
        label 'dockerv1'
    }

    options { disableConcurrentBuilds() }

    environment {
        containerRegistry = 'jack.hc-sc.gc.ca'
        containerRegistryPull = 'jack.hc-sc.gc.ca'
    }

    stages {

        stage('appmeta Info') {
            steps {
                checkout scm
                script {

                    def properties = readProperties  file: 'appmeta.properties'

                    //Get basic meta-data
                    rootGroup = properties.root_group
                    rootVersion = properties.root_version
                    buildId = env.BUILD_ID
                    version = rootVersion + "." + (buildId ? buildId : "MANUAL-BUILD")
                    module = rootGroup

                    // Setup Artifactory connection
                    artifactoryServer = Artifactory.server 'default'
                    artifactoryGradle = Artifactory.newGradleBuild()
                    artifactoryDocker = Artifactory.docker server: artifactoryServer
                    buildInfo = Artifactory.newBuildInfo()
                }
            }
        }

        stage('Docker Image') {
            when {
                branch 'master'
            }
            steps {
                //sh 'rm -rf ./docker/content'
                //sh 'cp -r ./content ./docker'

                withCredentials([
                    usernamePassword(credentialsId:'ARTIFACTORY_PUBLISH', usernameVariable: 'USR', passwordVariable: 'PWD')
                ]) {
                    sh """
                        docker login -u ${USR} -p ${PWD} ${
                        containerRegistry
                    }
			docker build -t dhpid-search:${version} . -f ./docker/Dockerfile
                        docker tag dhpid-search:${version} ${containerRegistry}/dhpid-search:${version}
                    """
                }

                script {
                    def buildInfoTemp
                    buildInfoTemp = artifactoryDocker.push "${containerRegistry}/dhpid-search:${version}", 'docker-local'
                    buildInfo.append buildInfoTemp
                }
            }
        }

/*
        stage('Publish Terraform') {
            when {
                branch 'master'
            }
            steps {
                sh """
                    rm -f terraform.tar.gz
                    tar -czvf terraform.tar.gz terraform/*.tf
                """
                script {
                    def uploadSpec = """{
                        "files": [
                            {
                                "pattern": "terraform.tar.gz",
                                "target": "pipeline-terraform/hcweb/cpnp/${version}/"
                            }
                        ]
                    }"""
                    artifactoryServer.upload spec: uploadSpec
                }
            }
        }
*/

        stage('Deploy to dev') {
            when {
                branch 'master'
            }
            agent {
                label 'dhpid2-dv-wb-01'
            }
            steps {
                sh """
		    ./container.sh
                """
            }
        }
    }

    post {
        always {
            script {
                resultString = "None"
            }
        }
        success {
            script {
                resultString = "Success"
            }
        }
        unstable {
            script {
                resultString = "Unstable"
            }
        }
        failure {
            script {
                resultString = "Failure"
            }
        }
        cleanup {
            emailext body: "<p>See build result details at: <a href='${env.JOB_URL}'>${env.JOB_URL}</a></p>", mimeType: 'text/html; charset=UTF-8', recipientProviders: [[$class: 'CulpritsRecipientProvider'], [$class: 'DevelopersRecipientProvider'], [$class: 'UpstreamComitterRecipientProvider'], [$class: 'RequesterRecipientProvider']], replyTo: 'no-reply@build.scs-lab.com', subject: "${currentBuild.fullDisplayName} ${resultString}"
            script {
                jiraIssueSelector(issueSelector: [$class: 'DefaultIssueSelector'])
                        .each {
                    id -> jiraComment body: "*Build Result ${resultString}* Module: ${module} appmeta: ${version} [Details|${env.BUILD_URL}]", issueKey: id
                }
            }
        }
    }
}
