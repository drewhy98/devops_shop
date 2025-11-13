pipeline {
    agent any
    stages {
        stage('Build Docker Image') {
            steps {
                echo 'Building Docker image...'
                sh 'docker build -t st20276784/devops_shop:latest .'
            }
        }

        stage('Run Containers') {
            steps {
                echo 'Starting containers with docker-compose...'
                sh 'docker compose up -d'
                echo 'Waiting for MySQL to initialize...'
                sh 'sleep 15'
            }
        }

        stage('Test') {
            steps {
                echo 'Running basic health check on web app...'
                sh 'curl -f http://localhost:8080 || exit 1'
            }
        }

        stage('Push to Docker Hub') {
            steps {
                echo 'Pushing image to Docker Hub...'
                withCredentials([usernamePassword(credentialsId: 'dockerhub', usernameVariable: 'USER', passwordVariable: 'PASS')]) {
                    sh 'docker login -u $USER -p $PASS'
                    sh 'docker push st20276784/devops_shop:latest'
                }
            }
        }

        stage('Clean Up') {
            steps {
                echo 'Cleaning up containers and images...'
                sh 'docker compose down'
                sh 'docker rmi st20276784/devops_shop:latest || true'
            }
        }
    }
}
