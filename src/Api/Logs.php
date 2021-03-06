<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\Api;

class Logs
{
    private const PREFIX = 'Logs';

    public $api;

    public function __construct(Api $api) {
        $this->api = $api;

        $this->api->prefix = self::PREFIX;
    }

    public function error($merge = []) {
        return $this->api->command('Error', $merge);
    }

    public function event($merge = []) {
        return $this->api->command('Event', $merge);
    }

    public function handHistory($merge = []) {
        return $this->api->command('HandHistory', $merge);
    }

    public function getErrorlogs(): array {
        $arr = [];

        $api = $this->error();

        if (isset($api->Files)) {
            for ($i = 0; $i < $api->Files; $i++) {
                $arr[] = $api->Date[$i];
            }
        }

        return $arr;
    }

    public function getErrorLog(string $edate): array {
        $arr = [];

        $api = $this->error(['Date' => $edate]);

        if (isset($api->Data)) {
            for ($i = 0; $i < count($api->Data); $i++) {
                $arr[] = $api->Data[$i];
            }
        }

        return $arr;
    }

    public function getEventLogs(): array {
        $arr = [];

        $api = $this->event();

        if (isset($api->Files)) {
            for ($i = 0; $i < $api->Files; $i++) {
                $arr[] = $api->Date[$i];
            }
        }

        return $arr;
    }

    public function getEventLog(string $date): array {
        $arr = [];

        $api = $this->event(['Date' => $date]);

        if (isset($api->Data) && count($api->Data) > 0) {
            for ($i = 0; $i < count($api->Data); $i++) {
                $arr[] = $api->Data[$i];
            }
        }
        return $arr;
    }

    public function getHandHistories(): array {
        $arr = [];

        $api = $this->handHistory();

        if (isset($api->Files)) {
            for ($i = 0; $i < $api->Files; $i++) {
                $arr[] = $api->Date[$i] . '  ' . htmlspecialchars($api->Name[$i], ENT_QUOTES);
            }
        }

        return $arr;
    }

    public function getHandHistory(string $history) {
        $handHistory = [];

        $history = stripslashes($history);

        $api = $this->handHistory(['Date' => substr($history, 0, 10), 'Name' => substr($history, 12)]);

        if (isset($api->Data)) {
            for ($i = 0; $i < count($api->Data); $i++) {
                $handHistory[] = $api->Data[$i];
            }
        }

        return $handHistory;
    }
}

