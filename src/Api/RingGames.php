<?php namespace Arivelox\Pokermavens2\Api;

class RingGames
{
    private const PREFIX = 'RingGames';

    public $api;

    public function __construct(Api $api) {
        $this->api = $api;
        $this->api->prefix = self::PREFIX;
    }

    public function add($name, $merge = []) {
        return $this->instance(array_merge(['Command' => static::prefix . 'Add', 'Name' => $name], $merge));
    }

    public function online($name) {
        return $this->command('Online', [
            'Name' => $name
        ]);
    }

    public function offline($name) {
        return $this->command('Offline', [
            'Name' => $name
        ]);
    }
}

