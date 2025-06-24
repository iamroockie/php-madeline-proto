<?php

namespace App;

use danog\MadelineProto\API;
use Exception;
use InvalidArgumentException;

class App
{
    const string ME = 'me';

    private API $api;

    public function __construct()
    {
        if (empty($_ENV['API_ID'])) {
            throw new Exception("API_ID env variable required");
        }

        if (empty($_ENV['API_HASH'])) {
            throw new Exception("API_HASH env variable required");
        }

        $settings = (new \danog\MadelineProto\Settings\AppInfo)
            ->setApiId($_ENV['API_ID'])
            ->setApiHash($_ENV['API_HASH']);

        $this->api = new API('session.madeline', $settings);
    }

    public function start()
    {
        try {
            $this->api->start();
            return Response::success();
        } catch (Exception $e) {
            return Response::error($e->getMessage());
        }
    }

    public function run(string $cmd, array $params = []): string
    {
        if (!method_exists($this, $cmd)) {
            return Response::error("Unknown command");
        }

        try {
            $result = call_user_func_array([$this, $cmd], [$params]);

            return empty($result) ? Response::success() : Response::success($result);
        } catch (Exception $e) {
            return Response::error($e->getMessage());
        }
    }

    public function ping(): array
    {
        return ['pong' => true, 'timestamp' => time()];
    }

    public function me(): array|false
    {
        return $this->api->getSelf();
    }

    public function sendMessage(array $params = []): void
    {
        $this->validateParams($params, ['peer', 'message']);

        $peer = $params['peer'];
        $message = $params['message'];

        $this->api->messages->sendMessage(compact('peer', 'message'));
    }

    public function addContact(array $params = []): void
    {
        $this->validateParams($params, ['user_id', 'first_name', 'last_name', 'phone']);

        $this->api->contacts->addContact(
            id: $params['user_id'],
            phone: $params['phone'],
            first_name: $params['first_name'],
            last_name: $params['last_name']
        );
    }

    public function resolvePhone(array $params = []): array
    {
        $this->validateParams($params, ['phone']);

        return $this->api->contacts->resolvePhone(
            phone: $params['phone']
        );
    }

    public function getHistory(array $params = []): array
    {
        $this->validateParams($params, ['peer']);

        $peer = $params['peer'];

        $req = compact('peer');

        if (!empty($params['limit'])) {
            $req['limit'] = $params['limit'];
        }

        if (!empty($params['offset'])) {
            $req['add_offset'] = $params['offset'];
        }

        return $this->api->messages->getHistory($req);
    }

    private function validateParams(array $params, array $keys)
    {
        if (empty($params)) {
            throw new InvalidArgumentException("Params required");
        }

        foreach ($keys as $key) {
            if (!empty($params[$key])) {
                continue;
            }

            throw new InvalidArgumentException("Param '$key' required");
        }
    }
}
