<?php

namespace QuickSSH\Commands;

use QuickSSH\App\App;
use QuickSSH\Error\Error;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;

class UnsetServer extends Command
{
    public function __construct()
    {
        parent::__construct("unset", function (array $args, App $app) {
            $this->console->color([SGR::COLOR_FG_PURPLE])->bold()->text("QuickSSH")->reset()->lf();

            if (count($args) === 3) {
                $this->console->italic()->text("Removing server...")->reset()->lf();

                if ($app->getServer($args[2])) {
                    if ($app->removeServer($args[2])) {
                        $this->console->bold()->text("The server \e[31m{$args[2]}\e[0m\e[1m has been removed from your saved connections.")->reset()->lf();
                    }
                } else {
                    Error::print("You don't have any servers saved with that name. Use \e[1mqssh list\e[0m to see all saved connections.", $this->console);
                }
            } else {
                Error::print("Invalid arguments. Use \e[1mqssh unset <name>\e[0m to remove a saved server.", $this->console);
            }
        });
    }
}