<?php namespace Arivelox\Pokermavens2\RingGame;

use Arivelox\Pokermavens2\Api;
use Arivelox\Pokermavens2\RingGame\Validator\RingGameValidator;

class RingGame
{
    private $api;

    public $buyInMax;
    public $buyInMin;
    public $buyInDef;
    public $rakePercentage;
    public $BB;
    public $SB;
    public $PW;
    public $name;
    public $private;
    public $seats;
    public $game;
    public $dupeIPs;
    public $ante;
    public $bringIn;

    public function __construct(Api $api, $opts) {
        $this->api = $api;

        $this->set($opts);
    }

    private function set($opts) {
        $this->bringIn = $opts->bringIn;
        $this->name = $opts->name;
        $this->game = $opts->game;
        $this->seats = $opts->seats;
        $this->buyInMin = $opts->buyInMin;
        $this->buyInMax = $opts->buyInMax;
        $this->buyInDef = isset($opts->buyInDef) ? $opts->buyInDef : $opts->buyInMax / 2;
        $this->SB = $opts->SB;
        $this->BB = $opts->BB;
        $this->ante = (float)$opts->ante;
        if (isset($opts->PW))$this->PW = (string)$opts->PW;
        $this->private = (bool)$this->private ? 'Yes' : 'No';
        $this->dupeIPs = (bool)$opts->dupeIPs ? 'Yes' : 'No';
        $this->rakePercentage = isset($opts->rakePercentage) ? (float)$opts->rakePercentage : 0;
    }

    /**
     * @param $name
     * @param $game
     * @param $seats
     * @param $sb
     * @param $bb
     * @param $minBuyIn
     * @param $maxBuyIn
     * @param $pw
     * @param bool $private
     * @param bool $dupe
     * @return mixed|object
     * @throws \Exception
     */
    public function create($validate = true, $merge = []) {
        $className = (new \ReflectionClass($this))->getShortName();
        $isHoldemOmaha = $className === 'HoldemOmaha';
        if ($validate) {
            $Validator = __NAMESPACE__."\\Validator\\RingGameValidator$className";
            (new $Validator($this))->validate();
        }
        return $this->api->ringGamesAdd(array_merge([
            'Name' => $this->name,
            'Game' => $this->game,
            'PW' => $this->PW,
            'Private' => $this->private,
            'Seats' => $this->seats,
            'BuyInMin' => $this->buyInMin,
            'BuyInMax' => $this->buyInMax,
            'BuyInDef' => $this->buyInDef,
            'RakePercent' => $this->rakePercentage,
            'DupeIPs' => $this->dupeIPs,
            $isHoldemOmaha ? 'SmallBlind' : 'SmallBet' => $this->SB,
            $isHoldemOmaha ? 'BigBlind' : 'BigBet' => $this->BB,
            'Ante' => $this->ante,
            'BringIn' => $this->bringIn
        ], $merge));
    }

    protected function validate() {
        new RingGameValidator($this);
    }
}