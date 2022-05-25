<?php

namespace QuickSSH\Commands;

use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;
use QuickSSH\App\App;
use QuickSSH\Error\Error;

class Help extends Command
{
    public function __construct()
    {
        parent::__construct("--help", function(array $args, App $app) {
            $this->printHeader();

            if (count($args) === 2) {
                $app->printHelp($this->console);
            } else {
                Error::print("You have entered an invalid number of arguments.", $this->console);
            }
        });
    }
}