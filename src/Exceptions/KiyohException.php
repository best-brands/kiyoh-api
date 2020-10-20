<?php

namespace BestBrands\KiyohClient\Exceptions;

use Exception;
use Throwable;

/**
 * Class KiyohException
 * @package BestBrands\KiyohClient\Exceptions
 */
class KiyohException extends Exception
{
    protected array $rawError;

    /**
     * KiyohException constructor.
     *
     * @param array $message
     * @param int $code
     *
     *
     * @param Throwable|null $previous
     */
    public function __construct(array $message, $code = 0, Throwable $previous = null)
    {
        $this->rawError = $message;
        parent::__construct($this->getIndentMessage($message), $code, $previous);
    }

    /**
     * Creates a formatted message from an array
     *
     * @param array $message
     * @param int $indent
     *
     * @return string
     */
    public function getIndentMessage(array $message, int $indent = 0)
    {
        $formatted = '';

        foreach ($message as $key => $value) {
            if (is_array($value)) {
                $formatted .= $this->getIndentMessage($value, $indent + 4);
            } else {
                $formatted .= sprintf("%s%s: %s\n", str_repeat(" ", $indent), $key, $value);
            }
        }

        return $formatted;
    }

    /**
     * Get the raw error
     *
     * @return array
     */
    public function getRawError(): array
    {
        return $this->rawError;
    }
}