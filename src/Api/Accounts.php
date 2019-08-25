<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\Api;

class Accounts
{
    private const PREFIX = 'Accounts';

    public $api;

    public function __construct(Api $api) {
        $this->api = $api;

        $this->api->prefix = self::PREFIX;
    }

    public function get(array $merge = []) {
        return $this->api->command('Get', $merge);
    }

    public function set(array $merge = []) {
        return $this->api->command('Edit', $merge);
    }

    public function getBalance(string $player) {
        $api = $this->get([
            'Player' => $player
        ]);
        return (int)$api->Balance;
    }

    public function getChipLeaders(): array {
        $api = $this->api->instance(['Command' => "AccountsList", "Fields" => "Player,Balance"]);

        $data = [];

        if (isset($api->Accounts) && isset($api->Player) && isset($api->Balance)) {
            for ($i = 0; $i < $api->Accounts; $i++) {
                $data[$api->Player[$i]] = $api->Balance[$i];
            }

            arsort($data);
        }

        return $data;
    }

    public function getPlayer(string $player) {
        return $this->get([
            'Player' => $player
        ]);
    }

    public function isPlayer(string $player) {
        $api = $this->get([
            'Player' => $player
        ]);

        return isset($api->Error) && $api->Error == 'Unknown account' ? false : true;
    }

    public function setAvatar(string $player, int $avatar) {
        return $this->set([
            'Player' => $player,
            'Avatar' => $avatar
        ]);
    }

    public function setAvatarCustom(string $player, string $avatarFile) {
        return $this->set([
            'Player' => $player,
            'AvatarFile' => $avatarFile,
            'Avatar' => 0
        ]);
    }

    public function setEmail(string $player, string $email) {
        return $this->set([
            'Player' => $player,
            'Email' => $email
        ]);
    }

    public function setLocation(string $player, string $location) {
        return $this->set([
            'Player' => $player,
            'Location' => $location
        ]);
    }
}


