<?php namespace Arivelox\Pokermavens2\RingGame\Validator;

use Arivelox\Pokermavens2\RingGame\RingGame;

class RingGameValidator
{
    /**
     *
     */
    public const MIN_SEATS = 2;
    /**
     *
     */
    public const MAX_TABLE_NAME_LENGTH = 25;
    /**
     *
     */
    public const BB_MIN = 1;
    /**
     *
     */
    public const BB_MAX = 10000;
    /**
     *
     */
    public const SB_MIN = 1;
    /**
     *
     */
    public const SB_MAX = 5000;
    /**
     *
     */
    public const BUYIN_MIN = 10;
    /**
     *
     */
    public const BUYIN_MAX = 1000000;

    /**
     * @var RingGame
     */
    protected $game;

    /**
     * @var
     */
    public $gameTypes;
    /**
     * @var
     */
    public $maxSeats;
    /**
     * @var
     */
    public $placeholder;

    /**
     * RingGameValidator constructor.
     * @param RingGame $game
     */
    public function __construct(RingGame $game) {
        $this->game = $game;
    }

    /**
     * @throws RingGameValidatorException
     */
    public function validate() {
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

    /**
     * @throws RingGameValidatorException
     */
    public function name() {
        $max = self::MAX_TABLE_NAME_LENGTH;
        if (strlen($this->game->name) > $max)
            throw new RingGameValidatorException("Table name length cannot exceed $max characters.");
    }

    /**
     * @throws RingGameValidatorException
     */
    public function buyInDiffs() {
        if ($this->game->buyInMax < $this->game->buyInMin)
            throw new RingGameValidatorException("Maximum Buy-In cannot be less than minimum Buy-In.");
    }

    /**
     * @throws RingGameValidatorException
     */
    public function blindDiffs() {
        if ($this->game->BB < $this->game->SB)
            throw new RingGameValidatorException("Big $this->placeholder cannot be less than Small $this->placeholder.");
    }

    /**
     * @throws RingGameValidatorException
     */
    public function reservedChars() {
        if (strpos($this->game->name, "[") !== false ||
            strpos($this->game->name, "=") !== false ||
            strpos($this->game->name, "\\") !== false ||
            strpos($this->game->name, "<") !== false)
            throw new RingGameValidatorException("Table Name cannot contain reserved characters [, =, \\, and <.");
    }

    /**
     * @throws RingGameValidatorException
     */
    public function gameType() {
        $gameType = $this->game->game;
        if (!in_array($gameType, $this->gameTypes))
            throw new RingGameValidatorException("Unknown Game Type: $gameType.");
    }

    /**
     * @throws RingGameValidatorException
     */
    public function buyIn() {
        $min = self::BUYIN_MIN;
        $max = self::BUYIN_MAX;
        if ($this->game->buyInMax < $min ||
            $this->game->buyInMin > $max)
            throw new RingGameValidatorException("Maximum Buy-In must be a number between $min - $max.");
    }

    /**
     * @throws RingGameValidatorException
     */
    public function seats() {
        $min = self::MIN_SEATS;
        $max = $this->maxSeats;
        if ($this->game->seats < $min ||
            $this->game->seats > $max)
            throw new RingGameValidatorException("Seat Count must be from $min to $max.");
    }

    /**
     * @throws RingGameValidatorException
     */
    public function bb() {
        $min = self::BB_MIN;
        $max = self::BB_MAX;
        if ($this->game->BB < $min ||
            $this->game->BB > $max)
            throw new RingGameValidatorException("Big $this->placeholder must be from $min to $max chips.");
    }

    /**
     * @throws RingGameValidatorException
     */
    public function sb() {
        $min = self::SB_MIN;
        $max = self::SB_MAX;
        if ($this->game->SB < $min ||
            $this->game->SB > $max)
            throw new RingGameValidatorException("Small $this->placeholder must be from $min to $max chips.");
    }
}