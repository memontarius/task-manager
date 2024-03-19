
cname=task_tracker_app # Container name
c= # Class name

up:
	docker compose up -d

dw:
	docker compose down

in:
	docker exec -it $(cname) bash


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

c-mig:
	docker exec $(cname) make mig


# _____________ Testing _____________
test:
	make config-clr
	php artisan test

testc:
	make config-clr
	php artisan test --filter $(c)

c-testc:
	docker exec $(cname) make testc c=$(c)

c-test:
	docker exec $(cname) make test


# _____________ Seeding _____________
c-seed:
	docker exec $(cname) make seed c=$(c)

c=DatabaseSeeder
seed:
	php artisan db:seed --class=$(c)
