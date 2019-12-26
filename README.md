# Course Micro Services

Para criar uma networks:

    docker network create microservices-network

Send messenger kafka of Orders:

    kafka-console-producer --broker-list localhost:9092 --topic orders