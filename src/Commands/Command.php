<?php

namespace QuickSSH\Commands;

use QuickSSH\App\App;
use Bramus\Ansi\Ansi;
use Bramus\Ansi\Writers\StreamWriter;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;

class Command
{
    public string $name;
    public \Closure $method;
    public Ansi $console;

    public function __construct(string $name, \Closure $method)
    {
        $this->name = $name;
        $this->method = $method;
        $this->console = new Ansi(new StreamWriter(STDOUT));
    }

    protected function printHeader()
    {
        $this->console->color([SGR::COLOR_FG_BLUE])->bold()->text("QuickSSH")->reset()->lf();
    }

    public function run(array $args, App $app)
    {
        $method = $this->method;
        $method($args, $app);
    }
}