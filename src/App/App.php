<?php

namespace QuickSSH\App;

use Bramus\Ansi\Ansi;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;
use QuickSSH\Commands as Commands;
use QuickSSH\Error\Error;
use QuickSSH\Server\Server;

class App
{
    public array $commands;
    protected array $servers;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $this->registerCommand("connect", new Commands\Connect());
        $this->registerCommand("list", new Commands\ListServers());
        $this->registerCommand("set", new Commands\SetServer());
        $this->registerCommand("unset", new Commands\UnsetServer());
        $this->registerCommand("--help", new Commands\Help());
        $this->registerCommand("--version", new Commands\Version());
        $this->registerCommand("-v", new Commands\Version());
        $this->servers = $this->getServers();
    }

    private function registerCommand(string $command, Commands\Command $commandInstance)
    {
        $this->commands[$command] = $commandInstance;
    }

    public function runCommand(string $command, array $args)
    {
        if (array_key_exists($command, $this->commands)) {
            $this->commands[$command]->run($args, $this);
        } else {
            Error::print("Command not found. Use \e[1mqssh --help\e[0m to list available commands.", new Ansi());
        }
    }

    public function getServers()
    {
        $configFile = dirname(__FILE__) . "/../../config/servers.php";
        return file_exists($configFile) ? require $configFile : [];
    }

    public function getServer(string $name)
    {
        if (array_key_exists($name, $this->servers)) {
            return $this->servers[$name];
        }

        return false;
    }

    public function addServer(string $name, string $username, string $host): Server
    {
        $server = new Server($name, $username, $host);
        $servers = $this->getServers();
        $servers[$name] = $server;

        if (file_exists(dirname(__FILE__) . "/../../config")) {
            $configFile = dirname(__FILE__) . "/../../config/servers.php";
        } else {
            mkdir(dirname(__FILE__) . "/../../config");
            $configFile = dirname(__FILE__) . "/../../config/servers.php";
        }

        $handler = fopen($configFile, "w");
        fwrite($handler, "<?php return " . var_export($servers, true) . ";");
        fclose($handler);

        return $server;
    }

    public function removeServer(string $name): bool
    {
        if ($this->getServer($name)) {
            $servers = $this->getServers();
            unset($servers[$name]);
            $configFile = dirname(__FILE__) . "/../../config/servers.php";

            $handler = fopen($configFile, "w");
            fwrite($handler, "<?php return " . var_export($servers, true) . ";");
            fclose($handler);
            return true;
        } else {
            return false;
        }
    }

    public function connect(string $serverName, Ansi $console)
    {
        $console->italic()->text("Connecting to server...")->reset()->lf();
        $server = $this->getServer($serverName);
        $shellScript = dirname(__FILE__) . "/../../bin/connect.sh";

        if ($server) {
            $console->text("Server found. Establishing connection...")->lf();
            $console->text("This process will close once you \e[1mexit\e[0m from the SSH session.")->lf();
            shell_exec("$shellScript {$server->user} {$server->host}");
            $console->text("Connection closed.")->lf();
        } else {
            Error::print("Server not found", $console);
        }
    }

    public function getVersion()
    {
        $composerJson = json_decode(file_get_contents(dirname(__FILE__) . "/../../composer.json"));
        return $composerJson->version;
    }

    public function printVersion(Ansi $console)
    {
        $console->text("\e[1mv" . $this->getVersion() . "\e[0m")->lf();
    }

    public function printHelp(Ansi $console)
    {
        $console->color()->italic()->text("The simple command line SSH credential and connection manager.")->reset()->lf()->lf();
        $console->color([SGR::COLOR_FG_RED])->bold()->text("Usage:")->reset()->lf();

        $helpCommands = $this->getHelpCommands();

        foreach ($helpCommands as $helpCommand) {
            $this->printHelpLine($helpCommand["command"], $helpCommand["text"], $console);
        }
    }

    protected function printHelpLine(string $command, string $explainer, Ansi $console)
    {
        $console->color([SGR::COLOR_FG_GREEN])->bold()->text($command)->reset()->lf()->text($explainer)->lf()->lf();
    }

    protected function getHelpCommands(): array
    {
        return [
            [
                "command" => "qssh set <name> <user> <host>",
                "text" => "Save a new named connection."
            ],
            [
                "command" => "qssh connect <name>",
                "text" => "Connects to a saved connection by name."
            ],
            [
                "command" => "qssh unset <name>",
                "text" => "Removes a named server from your saved servers."
            ],
            [
                "command" => "qssh list",
                "text" => "Lists all saved connections."
            ]
        ];
    }
}