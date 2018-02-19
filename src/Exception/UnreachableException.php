<?php namespace Arivelox\Pokermavens2\Exception;

use Exception;

class UnreachableException extends Exception
{
    /**
     * UnreachableException constructor.
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
        return __CLASS__ . ": [{$this->code}]: {$this->message}".PHP_EOL;
    }
}