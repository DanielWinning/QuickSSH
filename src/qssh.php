<?php

require_once dirname(__FILE__) . "/../vendor/autoload.php";

use QuickSSH\App\App;
use Bramus\Ansi\Ansi;
use Bramus\Ansi\Writers\StreamWriter;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;

$qssh = new App();
$console = new Ansi(new StreamWriter(STDOUT));

if (count($argv) < 2) {
    $console->color([SGR::COLOR_FG_PURPLE])->bold()->text("QuickSSH")->reset()->lf();
    $qssh->printHelp($console);
} else {
    $qssh->runCommand($argv[1], $argv);
}