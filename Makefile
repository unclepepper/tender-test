PROJECT_NAME="$(shell basename "$(PWD)")"
PROJECT_DIR="$(shell pwd)"
DOCKER_COMPOSE="$(shell which docker-compose)"
DOCKER="$(shell which docker)"
CONTAINER_PHP="php-unit"


init: generate-env  up ci  m-migrate generate-keypair right
restart: down up

##
## Docker
## ----------------------

sleep-5:
	sleep 5

up:
	docker-compose  --env-file .env.local up --build -d

down:
	docker-compose  --env-file .env.local down --remove-orphans


generate-env:
	@if [ ! -f .env.local ]; then \
		cp .env .env.local && \
		sed -i "s/^POSTGRES_PASSWORD=/POSTGRES_PASSWORD=$(shell openssl rand -hex 8)/" .env.local; \
		sed -i "s/^APP_SECRET=/APP_SECRET=$(shell openssl rand -hex 8)/" .env.local; \
	fi

.PHONY: sleep-5 up down generate-env init restart

##
## Bash, composer
## ----------------------

bash:
	${DOCKER_COMPOSE} exec -it ${CONTAINER_PHP} /bin/bash

ps:
	${DOCKER_COMPOSE} ps

logs:
	${DOCKER_COMPOSE} logs -f

ci:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} composer install --no-interaction

.PHONY: bash ps logs ci


##
## Database
## ----------------------

m-create:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:database:create --if-not-exists -n

m-list:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:migrations:list

m-diff:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:migrations:diff

m-up:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:migrations:migrate

m-migrate:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:migrations:migrate -n

m-prev:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:migrations:migrate prev

cc:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console cache:clear

right:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} chown -R www-data:www-data .

ip:
	${DOCKER} inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' ${CONTAINER_PHP}

.PHONY: m-create m-list m-diff m-up m-migrate m-prev cc right ip

generate-keypair:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console lexik:jwt:generate-keypair --skip-if-exists -n


tender-create:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console app:tender-create --file=test_task_data.csv

user-create:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console app:user-create
