<?php namespace Arivelox\Pokermavens2\RingGame;

use Arivelox\Pokermavens2\Api;

class RazzStud extends RingGame {
    public function __construct(Api $api, $opts) {
        parent::__construct($api, (object)$opts);
    }
}