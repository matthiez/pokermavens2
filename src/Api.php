<?php namespace Arivelox\Pokermavens2;

use Arivelox\Pokermavens2\Exception\UnreachableException;
use Arivelox\Pokermavens2\Exception\EmptyResponseException;
use Arivelox\Pokermavens2\Exception\ApiException;

/**
 * Class Api
 * @package Arivelox\Pokermavens2
 */
class Api
{
    /**
     * @var
     */
    protected $url;
    /**
     * @var
     */
    protected $pw;
    /**
     * @var bool
     */
    protected $verifyPeer;

    /**
     * Api constructor.
     * @param $url
     * @param $pw
     * @param bool $verifyPeer
     */
    public function __construct($url, $pw, $verifyPeer = true) {
        $this->url = $url;
        $this->pw = $pw;
        $this->verifyPeer = $verifyPeer;
    }

    /**
     * @param $params
     * @param bool $json
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function instance($params, $json = true) {
        $params['Password'] = $this->pw;
        $params['JSON'] = $json ? 'Yes' : 'No';
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->verifyPeer);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        $response = curl_exec($curl);
        if (empty($response)) throw new EmptyResponseException($response);
        if (curl_errno($curl)) throw new UnreachableException(curl_error($curl));
        $obj = (object)json_decode($response);
        curl_close($curl);

        if (isset($obj->Error)) {
            $err = $obj->Error;
            if ($params['Command'] === 'AccountsGet' && $err === 'Unknown account') return $obj;
            throw new ApiException($err);
        }
        return $obj;
    }

    /**
     * @param array $merge
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function accountsEdit($merge = []) {
        return $this->instance(array_merge([
            'Command' => 'AccountsEdit'
        ], $merge));
    }

    /**
     * @param array $merge
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function accountsGet($merge = []) {
        return $this->instance(array_merge([
            'Command' => 'AccountsGet'
        ], $merge));
    }

    /**
     * @param array $merge
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function logsError($merge = []) {
        return $this->instance(array_merge([
            'Command' => 'LogsError'
        ], $merge));
    }

    /**
     * @param array $merge
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function logsEvent($merge = []) {
        return $this->instance(array_merge([
            'Command' => 'LogsEvent'
        ], $merge));
    }

    /**
     * @param array $merge
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function logsHandHistory($merge = []) {
        return $this->instance(array_merge([
            'Command' => 'LogsHandHistory'
        ], $merge));
    }

    /**
     * @param array $merge
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function ringGamesAdd($merge = []) {
        return $this->instance(array_merge([
            'Command' => 'RingGamesAdd'
        ], $merge));
    }

    /**
     * @param $player
     * @return int
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getBalance($player) {
        $api = $this->accountsGet([
            'Player' => $player
        ]);
        return (int)$api->Balance;
    }

    /**
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getSystemStats() {
        return $this->instance(['Command' => "SystemStats"]);
    }

    /**
     * @param $player
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getPlayer($player) {
        return $this->accountsGet([
            'Player' => $player
        ]);
    }

    /**
     * @param $player
     * @return bool
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function isPlayer($player) {
        $api = $this->accountsGet([
            'Player' => $player
        ]);

        return isset($api->Error) && $api->Error === 'Unknown account' ? false : true;
    }

    /**
     * @return array
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getChipLeaders() {
        $api = $this->instance(['Command' => "AccountsList", "Fields" => "Player,Balance"]);
        $data = [];
        if (isset($api->Accounts)) {
            for ($i = 0; $i < $api->Accounts; $i++) $data[$api->Player[$i]] = $api->Balance[$i];
            arsort($data);
        }
        return $data;
    }

    /**
     * @return array
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getTourneyResults() {
        $data = [];
        $api = $this->instance(['Command' => "TournamentsResults"]);
        if (isset($api->Files)) {
            $data['total'] = $api->Files;
            $data['options'] = [];
            for ($i = 0; $i < $data['total']; $i++) $data['options'][] = $api->Date[$i] . "  " . htmlspecialchars($api->Name[$i], ENT_QUOTES);
        }
        return $data;
    }

    /**
     * @return array
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getErrorLogs() {
        $arr = [];
        $api = $this->logsError();
        if (isset($api->Files))
            for ($i = 0; $i < $api->Files; $i++)
                $arr[] = $api->Date[$i];
        return $arr;
    }

    /**
     * @param $edate
     * @return string
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getErrorLog($edate) {
        $str = '';
        $api = $this->logsError(["Date" => $edate]);
        if (isset($api->Data))
            for ($i = 0; $i < count($api->Data); $i++)
                $str .= "$api->Data[$i]<br>";
        return $str;
    }

    /**
     * @return array
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getEventLogs() {
        $arr = [];
        $api = $this->logsEvent();
        if (isset($api->Files))
            for ($i = 0; $i < $api->Files; $i++)
                $arr[] = $api->Date[$i];
        return $arr;
    }

    /**
     * @param $date
     * @return array
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getEventLog($date) {
        $arr = [];
        $api = $this->logsEvent(["Date" => $date]);
        if (isset($api->Data) && count($api->Data) > 0)
            for ($i = 0; $i < count($api->Data); $i++)
                $arr[] = $api->Data[$i];
        return $arr;
    }

    /**
     * @return array
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getHandHistories() {
        $arr = [];
        $api = $this->logsHandHistory();
        if (isset($api->Files))
            for ($i = 0; $i < $api->Files; $i++)
                $arr[] = $api->Date[$i] . "  " . htmlspecialchars($api->Name[$i], ENT_QUOTES);
        return $arr;
    }

    /**
     * @param $history
     * @return array
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function getHandHistory($history) {
        $handHistory = [];
        $history = stripslashes($history);
        $api = $this->logsHandHistory(["Date" => substr($history, 0, 10), 'Name' => substr($history, 12)]);
        if (isset($api->Data)) {
            $data = $api->Data;
            for ($i = 0; $i < count($data); $i++) $handHistory[] = $data[$i];
        }
        return $handHistory;
    }

    /**
     * @param $player
     * @param $avatar
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function setAvatar($player, $avatar) {
        return $this->accountsEdit([
            'Player' => $player,
            'Avatar' => $avatar
        ]);
    }

    /**
     * @param $player
     * @param $location
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function setLocation($player, $location) {
        return $this->accountsEdit([
            'Player' => $player,
            'Location' => $location
        ]);
    }

    /**
     * @param $player
     * @param $email
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function setEmail($player, $email) {
        return $this->accountsEdit([
            'Player' => $player,
            'Email' => $email
        ]);
    }

    /**
     * @param $player
     * @param $avatarFile
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function setCustomAvatar($player, $avatarFile) {
        return $this->accountsEdit([
            'Player' => $player,
            'AvatarFile' => $avatarFile,
            'Avatar' => 0
        ]);
    }

    /**
     * @param $name
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function ringGamesOnline($name) {
        return $this->instance([
            'Command' => 'RingGamesOnline',
            'Name' => $name
        ]);
    }

    /**
     * @param $name
     * @return object
     * @throws ApiException
     * @throws EmptyResponseException
     * @throws UnreachableException
     */
    public function ringGamesOffline($name) {
        return $this->instance([
            'Command' => 'RingGamesOffline',
            'Name' => $name
        ]);
    }

    /**
     * @param $callbackPath
     * @return false|int|string
     * @throws \Exception
     */
    public static function callbacks($callbackPath) {
        $file = $_SERVER['DOCUMENT_ROOT'] . $callbackPath;
        if (!file_exists($file)) throw new \Exception("File $file not found.");
        return filesize($file) === 0 ? '' : readfile($file);
    }
}
