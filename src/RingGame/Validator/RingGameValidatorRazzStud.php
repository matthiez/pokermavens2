<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\RingGame\Validator;

use Arivelox\Pokermavens2\RingGame\RingGame;

class RingGameValidatorRazzStud extends RingGameValidator
{
    public const GAME_TYPES = [
        "Limit Razz",
        "Limit Stud",
        "Limit Stud Hi-Lo"
    ];

    public const MAX_SEATS = 8;

    public function __construct(RingGame $game, string $placeholder = 'Bet') {
        parent::__construct($game);

        $this->gameTypes = self::GAME_TYPES;
        $this->maxSeats = self::MAX_SEATS;
        $this->placeholder = $placeholder;
    }
}
