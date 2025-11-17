pipeline {
    agent any

    environment {
        DOCKERHUB = credentials('DockerHub') // Make sure this matches your Jenkins credentials ID
        IMAGE_NAME = "st20276784/devops_shop"
    }

    stages {
        stage('Docker Login') {
            steps {
                sh 'echo "$DOCKERHUB_PSW" | docker login -u "$DOCKERHUB_USR" --password-stdin'
            }
        }

        stage('Build Docker Image') {
            steps {
                echo 'Building Docker image...'
                sh "docker build -t $IMAGE_NAME ."
            }
        }

        stage('Run Containers') {
            steps {
                echo 'Stopping any previous containers...'
                sh '''
                    docker stop devops_shop || true
                    docker rm devops_shop || true
                    docker compose up -d
                '''
                echo 'Waiting for services to initialize...'
                sh 'sleep 15'
            }
        }

        stage('Test (Optional)') {
            steps {
                echo 'Skipping health check from Jenkins container...'
                // If you want to test, you can do it inside the container:
                // sh 'docker exec devops_shop curl -f http://localhost:8080 || exit 1'
            }
        }

        stage('Push to Docker Hub') {
            steps {
                echo 'Pushing image to Docker Hub...'
                sh "docker push $IMAGE_NAME"
            }
        }

        stage('Clean Up') {
            steps {
                echo 'Cleaning up containers and images...'
                sh '''
                    docker compose down || true
                    docker rmi $IMAGE_NAME || true
                '''
            }
        }
    }
}
