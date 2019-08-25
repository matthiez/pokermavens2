<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\Api;

use Arivelox\Pokermavens2\Exception\UnreachableException;
use Arivelox\Pokermavens2\Exception\EmptyResponseException;
use Arivelox\Pokermavens2\Exception\ApiException;

class Api
{
    public $path;

    public $params;

    public $url;

    public $port;

    public $verifyPeer;

    public $prefix;

    public function __construct(string $pw, string $path, string $url = '127.0.0.1', int $port = 7077, bool $json = true, bool $verifyPeer = true) {
        $this->path = $path;

        $this->url = $url;

        $this->port = $port;

        $this->verifyPeer = $verifyPeer;

        $this->params = [
            'Password' => $pw,
            'JSON' => $json ? 'Yes' : 'No'
        ];
    }

    public function command(string $cmd, array $merge = []) {
        return $this->instance(array_merge([
            'Command' => $this->prefix . $cmd
        ], $merge));
    }

    public function instance(array $params) {
        $this->params = array_merge($this->params, $params);

        $response = $this->curlResponse();

        if (isset($response->Error)) {
            if ($response->Error === 'Unknown account' && $params['Command'] === 'AccountsGet') {
                return $response;
            }

            throw new ApiException($response->Error);
        }

        return $response;
    }

    private function curlResponse() {
        $curl = curl_init("$this->url:$this->port/$this->path");

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->verifyPeer);

        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->params));

        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_VERBOSE, false);

        $response = curl_exec($curl);

        if (empty($response)) {
            throw new EmptyResponseException($response);
        }

        if (curl_errno($curl)) {
            throw new UnreachableException(curl_error($curl));
        }

        curl_close($curl);

        return (object)json_decode($response);
    }
}
