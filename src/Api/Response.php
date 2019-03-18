<?php namespace Arivelox\Pokermavens2\Api;

class Response
{

    /**
     * Response constructor.
     * @param $curl
     * @param bool $toLowerCase
     */
    public function __construct($curl, $toLowerCase = false) {
        foreach ($curl() as $key => $value)
            $this->{$toLowerCase ? lcfirst($key) : $key} = $value;
    }
}

