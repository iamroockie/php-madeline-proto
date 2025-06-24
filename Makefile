env:
	cp .env.example .env

up:
	docker-compose up -d --build

down:
	docker-compose down
