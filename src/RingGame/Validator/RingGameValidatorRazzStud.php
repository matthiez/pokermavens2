<?php namespace Arivelox\Pokermavens2\RingGame\Validator;

use Arivelox\Pokermavens2\RingGame\RingGame;

class RingGameValidatorRazzStud extends RingGameValidator {
    /**
     *
     */
    public const GAME_TYPES = [
        "Limit Razz",
        "Limit Stud",
        "Limit Stud Hi-Lo"
    ];

    /**
     *
     */
    public const MAX_SEATS = 8;

    /**
     * RingGameValidatorRazzStud constructor.
     * @param RingGame $game
     * @param string $placeholder
     */
    public function __construct(RingGame $game, $placeholder = 'Bet') {
        parent::__construct($game);

        $this->gameTypes = self::GAME_TYPES;
        $this->maxSeats = self::MAX_SEATS;
        $this->placeholder = $placeholder;
    }
}