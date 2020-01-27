# Microservices com Laravel, Kafka e Docker

Start project:

    docker-compose up

Entrar na workspace:

    docker-compose exec customerapp bash
    docker-compose exec productapp bash
    docker-compose exec rentalapp bash

Para criar uma networks:

    docker network create microservices-network

Send messenger kafka of Orders:

    kafka-console-producer --broker-list localhost:9092 --topic orders
