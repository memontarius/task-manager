up:
	docker compose up -d

dw:
	docker compose down

cache-clr:
	php artisan cache:clear

config-clr:
	php artisan config:clear

set-local:
	php artisan config:cache --env=local

set-testing:
	php artisan config:cache --env=testing

mig:
	php artisan migrate

test:
	make config-clr
	php artisan test

cname=task_tracker_app
in:
	docker exec -it $(cname) bash

c=DatabaseSeeder
seed:
	php artisan db:seed --class=$(c)


c-mig:
	docker exec $(cname) make mig

c-test:
	docker exec $(cname) make test

c-seed:
	docker exec $(cname) make seed c=$(c)
