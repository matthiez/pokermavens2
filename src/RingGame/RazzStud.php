<?php namespace Arivelox\Pokermavens2\RingGame;

use Arivelox\Pokermavens2\Api\RingGames;

class RazzStud extends RingGame {
    /**
     * RazzStud constructor.
     * @param RingGames $api
     * @param $opts
     */
    public function __construct(RingGames $api, $opts) {
        parent::__construct($api, (object)$opts);
    }
}