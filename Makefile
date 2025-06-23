env:
	cp .env.example .env

up:
	docker compose up --build

install:
	docker compose run --rm madeline composer install

run:
	docker compose run --rm madeline php ./app/index.php

down:
	docker compose down
