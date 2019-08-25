<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\RingGame;

use Arivelox\Pokermavens2\Api\RingGames;

class RazzStud extends RingGame
{
    public function __construct(RingGames $api, $opts) {
        parent::__construct($api, (object)$opts);
    }
}
