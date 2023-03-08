<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Исключение 'Передан пустая коллекция ярлыков'.
 */
class EmptyLabelCollectionException extends Exception
{
    public function __construct($code = 0, Throwable $previous = null) {
        $message = "Передан пустой список ярлыков.";
        parent::__construct($message, $code, $previous);
    }
}
