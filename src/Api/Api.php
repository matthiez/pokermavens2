<?php namespace Arivelox\Pokermavens2\Api;

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

    public function __construct($pw, $path, $url = '127.0.0.1', $port = 7077, $json = true, $verifyPeer = true) {
        $this->path = $path;
        $this->url = $url;
        $this->port = $port;
        $this->verifyPeer = $verifyPeer;

        $this->params = [
            'Password' => $pw,
            'JSON' => $json ? 'Yes' : 'No'
        ];
    }

    public function command($cmd, $merge = []): object {
        return $this->instance(array_merge([
            'Command' => $this->prefix . $cmd
        ], $merge));
    }

    public function instance($params): object {
        $this->params = array_merge($this->params, $params);
        $response = $this->curlResponse();

        $hasError = isset($response->Error);
        if ($hasError && $response->Error === 'Unknown account' && $params['Command'] === 'AccountsGet') return $response;
        if ($hasError) throw new ApiException($response->Error);

        return $response;
    }

    private function curlResponse(): obj {
        $curl = curl_init("$this->url:$this->port/$this->path");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->verifyPeer);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->params));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, false);
        $response = curl_exec($curl);
        if (empty($response)) throw new EmptyResponseException($response);
        if (curl_errno($curl)) throw new UnreachableException(curl_error($curl));
        curl_close($curl);
        $res = json_decode($response);

        return (object)$res;
    }
}