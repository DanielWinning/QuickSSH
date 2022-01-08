<?php

require_once dirname(__FILE__) . "/../vendor/autoload.php";

use QuickSSH\App\App;
use Bramus\Ansi\Ansi;
use Bramus\Ansi\Writers\StreamWriter;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;

$qssh = new App();
$console = new Ansi(new StreamWriter(STDOUT));

if (count($argv) < 2) {
    $console->color([SGR::COLOR_FG_PURPLE])->bold()->text("--- QuickSSH ---")->reset()->lf();
    $console->color()->italic()->text("The simple command line SSH credential and connection manager.")->reset()->lf()->lf();
    $console->color([SGR::COLOR_FG_RED])->bold()->text("Usage:")->reset()->lf();
    $console->color([SGR::COLOR_FG_WHITE_BRIGHT, SGR::COLOR_BG_PURPLE_BRIGHT])->text("qssh <command> [<args>]")->reset()->lf()->lf();
} else {
    $qssh->runCommand($argv[1], $argv);
}