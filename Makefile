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

to-app:
	docker exec -it task_tracker_app bash

c-mig:
	docker exec task_tracker_app make mig

c-test:
	docker exec task_tracker_app make test
