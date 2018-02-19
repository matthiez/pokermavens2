<?php namespace Arivelox\Pokermavens2\RingGame;

use Arivelox\Pokermavens2\Api;
use Arivelox\Pokermavens2\RingGame\Validator\RingGameValidator;

class RingGame
{
    /**
     * @var Api
     */
    private $api;

    /**
     * @var
     */
    public $buyInMax;
    /**
     * @var
     */
    public $buyInMin;
    /**
     * @var
     */
    public $buyInDef;
    /**
     * @var
     */
    public $rakePercentage;
    /**
     * @var
     */
    public $BB;
    /**
     * @var
     */
    public $SB;
    /**
     * @var
     */
    public $PW;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $private;
    /**
     * @var
     */
    public $seats;
    /**
     * @var
     */
    public $game;
    /**
     * @var
     */
    public $dupeIPs;
    /**
     * @var
     */
    public $ante;
    /**
     * @var
     */
    public $bringIn;

    /**
     * RingGame constructor.
     * @param Api $api
     * @param $opts
     */
    public function __construct(Api $api, $opts) {
        $this->api = $api;

        $this->set($opts);
    }

    /**
     * @param $opts
     */
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
     * @param bool $validate
     * @param array $merge
     * @return object
     * @throws \Arivelox\Pokermavens2\Exception\ApiException
     * @throws \Arivelox\Pokermavens2\Exception\EmptyResponseException
     * @throws \Arivelox\Pokermavens2\Exception\UnreachableException
     * @throws \ReflectionException
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

    /**
     *
     */
    protected function validate() {
        new RingGameValidator($this);
    }
}