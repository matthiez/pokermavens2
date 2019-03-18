<?php namespace Arivelox\Pokermavens2\RingGame\Validator;

use Exception;

class RingGameValidatorException extends Exception
{
    /**
     * RingGameValidatorException constructor.
     * @param $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}" . PHP_EOL;
    }
}