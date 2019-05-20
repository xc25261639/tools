<?php

namespace tools\Exceptions;

class InvalidSignException extends Exception
{
    /**
     * Raw error info
     *
     * @var array|string
     */
    public $raw;

    /**
     * Bootstrap.
     *
     * @author liyong <458878932@qq.com>
     *
     * @param string       $message
     * @param array|string $raw
     * @param int|string   $code
     */
    public function __construct($message, $raw = '', $code = 2)
    {
        parent::__construct($message, intval($code));

        $this->raw = $raw;
    }
}
