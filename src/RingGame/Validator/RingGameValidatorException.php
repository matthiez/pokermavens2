<?php
declare(strict_types=1);

namespace Arivelox\Pokermavens2\RingGame\Validator;

use Exception;

class RingGameValidatorException extends Exception
{
    public function __construct($message, int $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string {
        return __CLASS__ . ": [{$this->code}]: {$this->message}" . PHP_EOL;
    }
}
