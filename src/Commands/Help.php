<?php

namespace QuickSSH\Commands;

use QuickSSH\App\App;

class Help extends Command
{
    public function __construct()
    {
        parent::__construct("--help", function(array $args, App $app) {

        });
    }
}