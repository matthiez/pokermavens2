<?php namespace Arivelox\Pokermavens2\RingGame;

use Arivelox\Pokermavens2\Api;

/**
 * Class HoldemOmaha
 * @package Arivelox\Pokermavens2\RingGame
 */
class HoldemOmaha extends RingGame {
    /**
     * HoldemOmaha constructor.
     * @param Api $api
     * @param $required
     * @param array $merge
     * @param bool $private
     * @param bool $dupe
     * @throws \Exception
     */
    public function __construct(Api $api, $opts) {
        parent::__construct($api, (object)$opts);
    }
}