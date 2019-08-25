<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\Api;

class System
{
    private const PREFIX = 'System';

    public $api;

    public function __construct(Api $api) {
        $this->api = $api;
        $this->api->prefix = self::PREFIX;
    }

    public function stats() {
        return $this->api->command("Stats");
    }
}

