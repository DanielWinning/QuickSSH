<?php

namespace QuickSSH\Commands;

use QuickSSH\App\App;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;
use QuickSSH\Error\Error;

class Connect extends Command
{
    public function __construct()
    {
        parent::__construct("connect", function (array $args, App $app) {
            $this->printHeader();

            if (count($args) === 3) {
                $server = $args[2];

                if ($app->getServer($server)) {
                    $app->connect($server, $this->console);
                } else {
                    Error::print("You do not have any servers saved with that name. Use \e[1mqssh set <name> <user> <host>\e[0m to save a new connection.", $this->console);
                }
            } else {
                Error::print("Invalid arguments", $this->console);
            }
        });
    }
}