<?php namespace Arivelox\Pokermavens2\RingGame;

use Arivelox\Pokermavens2\Api\RingGames;

class HoldemOmaha extends RingGame
{

    /**
     * HoldemOmaha constructor.
     * @param RingGames $api
     * @param $opts
     */
    public function __construct(RingGames $api, $opts) {
        parent::__construct($api, (object)$opts);
    }
}