# Php Madeline Proto

## Make before run

### Register Telegram API

1. Go to https://my.telegram.org
2. Select <b>API Development Tools</b>
3. Register new app
4. Get 'api_id' and 'api_hash'

## First run

1. Set env variables: <b>API_ID</b>, <b>API_HASH</b>, <b>TOKEN_KEY</b>
2. Run this commands and authorization with QR code

```sh
make up

curl -v -X POST http://localhost:9090 -d token={TOKEN_KEY} cmd=ping
```

## Commands:

```sh
make env # touch .env file from .env.example

make up # docker compose build

make down # docker compose down
```
