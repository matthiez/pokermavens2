<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\RingGame\Validator;

use Arivelox\Pokermavens2\RingGame\RingGame;

/** @package Arivelox\Pokermavens2\RingGame\Validator */
class RingGameValidator
{
    public const MIN_SEATS = 2;

    public const MAX_TABLE_NAME_LENGTH = 25;

    public const BB_MIN = 1;

    public const BB_MAX = 10000;

    public const SB_MIN = 1;

    public const SB_MAX = 5000;

    public const BUYIN_MIN = 10;

    public const BUYIN_MAX = 1000000;

    /** @var RingGame */
    protected $game;

    /** @var */
    public $gameTypes;

    /** @var */
    public $maxSeats;

    /** @var */
    public $placeholder;

    public function __construct(RingGame $game) {
        $this->game = $game;
    }

    /** @throws RingGameValidatorException */
    public function validate(): void {
        $this->name();
        $this->buyInDiffs();
        $this->blindDiffs();
        $this->reservedChars();
        $this->gameType();
        $this->buyIn();
        $this->seats();
        $this->bb();
        $this->sb();
    }

    /** @throws RingGameValidatorException */
    public function name() {
        if (strlen($this->game->name) > self::MAX_TABLE_NAME_LENGTH) {
            throw new RingGameValidatorException("Table name length cannot exceed " . self::MAX_TABLE_NAME_LENGTH . " characters.");
        }
    }

    /** @throws RingGameValidatorException */
    public function buyInDiffs() {
        if ($this->game->buyInMax < $this->game->buyInMin) {
            throw new RingGameValidatorException("Maximum Buy-In cannot be less than minimum Buy-In.");
        }
    }

    /** @throws RingGameValidatorException */
    public function blindDiffs() {
        if ($this->game->BB < $this->game->SB) {
            throw new RingGameValidatorException("Big $this->placeholder cannot be less than Small $this->placeholder.");
        }
    }

    /** @throws RingGameValidatorException */
    public function reservedChars() {
        if (strpos($this->game->name, "[") !== false ||
            strpos($this->game->name, "=") !== false ||
            strpos($this->game->name, "\\") !== false ||
            strpos($this->game->name, "<") !== false) {
            throw new RingGameValidatorException("Table Name cannot contain reserved characters [, =, \\, and <.");
        }
    }

    /** @throws RingGameValidatorException */
    public function gameType() {
        $gameType = $this->game->game;
        if (!in_array($gameType, $this->gameTypes)) {
            throw new RingGameValidatorException("Unknown Game Type: $gameType.");
        }
    }

    /** @throws RingGameValidatorException */
    public function buyIn() {
        if ($this->game->buyInMax < self::BUYIN_MIN ||
            $this->game->buyInMin > self::BUYIN_MAX) {
            throw new RingGameValidatorException("Maximum Buy-In must be a number between " . self::BUYIN_MIN . "-" . self::BUYIN_MAX . ".");
        }
    }

    /** @throws RingGameValidatorException */
    public function seats() {
        if ($this->game->seats < self::MIN_SEATS ||
            $this->game->seats > $this->maxSeats) {
            throw new RingGameValidatorException("Seat Count must be from " . self::MIN_SEATS . " to $this->maxSeats.");
        }
    }

    /** @throws RingGameValidatorException */
    public function bb() {
        if ($this->game->BB < self::BB_MIN ||
            $this->game->BB > self::BB_MAX) {
            throw new RingGameValidatorException("Big $this->placeholder must be from " . self::BB_MIN . " to " . self::BB_MAX . " chips.");
        }
    }

    /** @throws RingGameValidatorException */
    public function sb() {
        if ($this->game->SB < self::SB_MIN ||
            $this->game->SB > self::SB_MAX) {
            throw new RingGameValidatorException("Small $this->placeholder must be from self::SB_MIN to " . self::SB_MAX . " chips.");
        }
    }
}
