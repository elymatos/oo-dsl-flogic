<?php

namespace OODSLToFLogic\Utils;


/**
 * Simple logger for debugging
 */
class Logger
{
    private static ?Logger $instance = null;
    private bool $debug = false;

    public static function getInstance(): Logger
    {
        if (self::$instance === null) {
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    public function debug(string $message): void
    {
        if ($this->debug) {
            echo "[DEBUG] " . $message . "\n";
        }
    }

    public function info(string $message): void
    {
        echo "[INFO] " . $message . "\n";
    }

    public function warning(string $message): void
    {
        echo "[WARNING] " . $message . "\n";
    }

    public function error(string $message): void
    {
        echo "[ERROR] " . $message . "\n";
    }
}