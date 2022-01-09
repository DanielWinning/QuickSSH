<?php

namespace QuickSSH\Commands;

use QuickSSH\Error\Error;
use QuickSSH\App\App;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;

class SetServer extends Command
{
    public function __construct()
    {
        parent::__construct("set", function (array $args, App $app) {
            $this->console->color([SGR::COLOR_FG_PURPLE])->bold()->text("QuickSSH")->reset()->lf();

            if (count($args) === 5) {
                $this->console->italic()->text("Saving server...")->reset()->lf();

                $app->addServer($args[2], $args[3], $args[4]);

                $this->console->bold()->text("The server \e[31m{$args[2]}\e[0m\e[1m has been saved.")->reset()->lf();
            } else {
                Error::print("Invalid arguments. Use \e[1mqssh set <name> <user> <host>\e[0m to save a new connection.", $this->console);
            }
        });
    }
}