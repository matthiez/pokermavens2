<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\Api;

class Blacklist
{
    private const PREFIX = 'Blacklist';

    public $api;

    public function __construct(Api $api) {
        $this->api = $api;

        $this->api->prefix = self::PREFIX;
    }

    public function get(array $merge = []) {
        return $this->api->command('Get', $merge);
    }

    public function stats() {
        return $this->api->command("Stats");
    }
}

