<?php

namespace QuickSSH\Error;

use Bramus\Ansi\Ansi;
use Bramus\Ansi\Writers\StreamWriter;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;

class Error
{
    public static function print(string $message, Ansi $console)
    {
        $console->lf();
        $console->color([SGR::COLOR_FG_RED_BRIGHT])
            ->bold()
            ->text("ERROR")
            ->nostyle()
            ->bold()
            ->text(": ")
            ->nostyle()
            ->text($message)
            ->reset()
            ->lf();
    }
}