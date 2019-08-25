<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\Api;

class Response
{
    public function __construct($curl, bool $toLowerCase = false) {
        foreach ($curl() as $key => $value) {
            $this->{$toLowerCase ? lcfirst($key) : $key} = $value;
        }
    }
}

