<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Исключение 'Ярлык не существует'.
 */
class UndefinedLabelsException extends Exception
{
    public function __construct(Collection $labels, $code = 0, Throwable $previous = null) {
        $labelNames = implode(', ', $labels->pluck('name')->toArray());
        $message = "Ярлыки [$labelNames] не существуют.";
        parent::__construct($message, $code, $previous);
    }
}
