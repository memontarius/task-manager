
ENV_PATH=./.env
ifneq ("$(wildcard $(ENV_PATH))","")
	 include $(ENV_PATH)
endif

DOCKER_FILE_PREFIX=
ifeq ($(APP_ENV),developement)
	DOCKER_FILE_PREFIX=-dev
endif
ifeq ($(APP_ENV),local)
	DOCKER_FILE_PREFIX=-dev
endif

DOCKER_FILE=docker-compose$(DOCKER_FILE_PREFIX).yml

cnn=task_tracker_app # Container name
sn=app #Service name
c= # Class name

# _____________ Setup _____________
i:
	composer install
	npm i
	npm run build

prepare-env:
	cp -n .env.example .env || true
	make key

setup:
	sudo chmod 777 -R storage/
	sudo chmod 777 -R bootstrap/cache/
	make c-mig

# _____________ Docker _____________

b:
	docker-compose --file $(DOCKER_FILE) build

bs:
	docker-compose --file $(DOCKER_FILE) build $(sn)

upb:
	docker-compose --file $(DOCKER_FILE) up --build -d

up:
	docker-compose --file $(DOCKER_FILE) up -d

dw:
	docker compose --file $(DOCKER_FILE) down

in:
	docker exec -it $(cnn) bash


# _____________ Other helpers _____________

key:
	php artisan key:generate

cache-clr:
	php artisan cache:clear

config-clr:
	php artisan config:clear

set-local:
	php artisan config:cache --env=local

set-testing:
	php artisan config:cache --env=testing


#_____________ Migrations _____________
mig:
	php artisan migrate

migrf:
	php artisan migrate:refresh

migf:
	php artisan migrate:fresh

migrb:
	php artisan migrate:rollback

c-mig:
	docker exec $(cnn) make mig

c-migrb:
	docker exec $(cnn) make migrb


# _____________ Testing _____________
test:
	make config-clr
	php artisan test

testc:
	make config-clr
	php artisan test --filter $(c)

c-testc:
	docker exec $(cnn) make testc c=$(c)

c-test:
	docker exec $(cnn) make test


# _____________ Seeding _____________
c=DatabaseSeeder
seed:
	php artisan db:seed --class=$(c)

c-seed:
	docker exec $(cnn) make seed c=$(c)
