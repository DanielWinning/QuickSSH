<?php

namespace QuickSSH\Commands;

use QuickSSH\Error\Error;
use QuickSSH\App\App;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;

class ListServers extends Command
{
    public function __construct()
    {
        parent::__construct("list", function (array $args, App $app) {
            $this->printHeader();

            if (count($args) === 2) {
                $this->console->italic()->text("Listing your saved servers...")->reset()->lf()->lf();
                $servers = $app->getServers();

                if (count($servers)) {
                    foreach ($servers as $server) {
                        $this->console
                            ->color([SGR::COLOR_FG_PURPLE])
                            ->bold()
                            ->text($server->name)
                            ->reset()
                            ->bold()
                            ->text(": ")
                            ->color([SGR::COLOR_FG_GREEN])
                            ->text($server->user)
                            ->reset()
                            ->color([SGR::COLOR_FG_WHITE])
                            ->bold()
                            ->text("@")
                            ->reset()
                            ->bold()
                            ->color([SGR::COLOR_FG_BLUE])
                            ->text($server->host)
                            ->reset()
                            ->lf();
                    }

                    $this->console->lf();
                    $this->console
                        ->italic()
                        ->text("Use \e[1mqssh connect <name>\e[0m \e[3mto connect to a saved server.")
                        ->reset()
                        ->lf();
                } else {
                    $this->console
                        ->color([SGR::COLOR_FG_BLUE])
                        ->bold()
                        ->text("No servers found!")
                        ->reset()
                        ->text(" Use ")
                        ->bold()
                        ->text("qssh set <name> <user> <host>")->reset()->text(" to save a new connection")
                        ->lf();
                }
            } else {
                Error::print("The \e[1mlist\e[0m command does not take any arguments.", $this->console);
            }
        });
    }
}