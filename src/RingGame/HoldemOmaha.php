<?php namespace Arivelox\Pokermavens2\RingGame;

use Arivelox\Pokermavens2\Api;

class HoldemOmaha extends RingGame {

    /**
     * HoldemOmaha constructor.
     * @param Api $api
     * @param $opts
     */
    public function __construct(Api $api, $opts) {
        parent::__construct($api, (object)$opts);
    }
}