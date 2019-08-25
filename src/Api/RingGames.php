<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\Api;

class RingGames
{
    private const PREFIX = 'RingGames';

    public $api;

    public function __construct(Api $api) {
        $this->api = $api;

        $this->api->prefix = self::PREFIX;
    }

    public function add(array $merge) {
        return $this->api->instance(array_merge(['Command' => self::PREFIX . 'Add'], $merge));
    }

    public function online(string $name) {
        return $this->api->command('Online', [
            'Name' => $name
        ]);
    }

    public function offline(string $name) {
        return $this->api->command('Offline', [
            'Name' => $name
        ]);
    }
}

