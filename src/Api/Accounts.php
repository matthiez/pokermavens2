<?php namespace Arivelox\Pokermavens2\Api;

class Accounts
{
    private const PREFIX = 'Accounts';

    public $api;

    public function __construct(Api $api) {
        $this->api = $api;
        $this->api->prefix = self::PREFIX;
    }

    public function get($merge = []) {
        return $this->api->command('Get', $merge);
    }

    public function set($merge = []) {
        return $this->api->command('Edit', $merge);
    }

    public function getBalance($player) {
        $api = $this->get([
            'Player' => $player
        ]);
        return (int)$api->Balance;
    }

    public function getChipLeaders() {
        $api = $this->api->instance(['Command' => "AccountsList", "Fields" => "Player,Balance"]);
        $data = [];
        if (isset($api->Accounts) && isset($api->Player) && isset($api->Balance)) {
            for ($i = 0; $i < $api->Accounts; $i++) $data[$api->Player[$i]] = $api->Balance[$i];
            arsort($data);
        }
        return $data;
    }

    public function getPlayer($player) {
        return $this->get([
            'Player' => $player
        ]);
    }

    public function isPlayer($player) {
        $api = $this->get([
            'Player' => $player
        ]);

        return isset($api->Error) && $api->Error === 'Unknown account' ? false : true;
    }

    public function setAvatar($player, $avatar) {
        return $this->set([
            'Player' => $player,
            'Avatar' => $avatar
        ]);
    }

    public function setAvatarCustom($player, $avatarFile) {
        return $this->set([
            'Player' => $player,
            'AvatarFile' => $avatarFile,
            'Avatar' => 0
        ]);
    }

    public function setEmail($player, $email) {
        return $this->set([
            'Player' => $player,
            'Email' => $email
        ]);
    }

    public function setLocation($player, $location) {
        return $this->set([
            'Player' => $player,
            'Location' => $location
        ]);
    }
}


