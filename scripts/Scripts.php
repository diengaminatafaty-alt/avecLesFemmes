<?php

namespace Diengaminatafaty;

use Composer\Script\Event;

class Scripts
{
    public static function makeEntity(Event $event): int
    {
        $args = implode(' ', array_map('escapeshellarg', $event->getArguments()));
        passthru('php bin/console make:entity ' . $args, $code);

        return $code;
    }
}