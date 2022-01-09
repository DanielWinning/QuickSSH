<?php

namespace QuickSSH\Commands;

use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;
use QuickSSH\App\App;

class Version extends Command
{
    public function __construct()
    {
        parent::__construct("--version", function (array $args, App $app) {
            $this->console->color([SGR::COLOR_FG_PURPLE])->bold()->text("QuickSSH")->reset()->lf();

            if (count($args) === 2) {
                $app->printVersion($this->console);
            }
        });
    }
}