<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\Api;

class Tournaments
{
    private const PREFIX = 'Tournaments';

    public $api;

    public function __construct(Api $api) {
        $this->api = $api;

        $this->api->prefix = self::PREFIX;
    }

    public function results(): array {
        $data = [];

        $api = $this->api->command("Results");

        if (isset($api->Files) && isset($api->Date) && isset($api->Name)) {
            $data['total'] = $api->Files;

            $data['options'] = [];

            for ($i = 0; $i < $data['total']; $i++) {
                $data['options'][] = $api->Date[$i] . "  " . htmlspecialchars($api->Name[$i], ENT_QUOTES);
            }
        }

        return $data;
    }
}

