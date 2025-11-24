pipeline {
    agent any

    environment {
        DOCKERHUB = credentials('DockerHub')  // Jenkins credential ID
        IMAGE_NAME = "st20276784/devops_shop_web"
        IMAGE_TAG  = "1.0"
    }

    stages {
        stage('Docker Login') {
            steps {
                echo 'Logging in to Docker Hub...'
                sh 'echo "$DOCKERHUB_PSW" | docker login -u "$DOCKERHUB_USR" --password-stdin'
            }
        }

        stage('Build Docker Image') {
            steps {
                echo "Building Docker image $IMAGE_NAME:$IMAGE_TAG ..."
                sh "docker build -t $IMAGE_NAME:$IMAGE_TAG ."
            }
        }

        stage('Push to Docker Hub') {
            steps {
                echo "Pushing Docker image $IMAGE_NAME:$IMAGE_TAG to Docker Hub..."
                sh "docker push $IMAGE_NAME:$IMAGE_TAG"
            }
        }

        stage('Run Containers') {
            steps {
                echo 'Stopping previous containers and starting new ones...'
                sh '''
                    docker compose down || true
                    docker compose pull
                    docker compose up -d
                '''
            }
        }

        stage('Clean Up (Optional)') {
            steps {
                echo 'Cleaning up unused images...'
                sh '''
                    docker image prune -f
                '''
            }
        }
    }
}
