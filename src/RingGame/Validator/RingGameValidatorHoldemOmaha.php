<?php namespace Arivelox\Pokermavens2\RingGame\Validator;

use Arivelox\Pokermavens2\RingGame\RingGame;

class RingGameValidatorHoldemOmaha extends RingGameValidator {
    public const GAME_TYPES = [
        "Limit Hold'em",
        "Pot Limit Hold'em",
        "No Limit Hold'em",
        "Limit Omaha",
        "Pot Limit Omaha",
        "No Limit Omaha",
        "Limit Omaha Hi-Lo",
        "Pot Limit Omaha Hi-Lo",
        "No Limit Omaha Hi-Lo"
    ];

    public const MAX_SEATS = 10;

    public function __construct(RingGame $game, $placeholder = 'Blind') {
        parent::__construct($game);

        $this->gameTypes = self::GAME_TYPES;
        $this->maxSeats = self::MAX_SEATS;
        $this->placeholder = $placeholder;
    }
}