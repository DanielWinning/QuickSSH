<?php

namespace QuickSSH\App;

use Bramus\Ansi\Ansi;
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
            Error::print("Command not found", new Ansi());
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

    public function addServer(string $name, string $username, string $host)
    {
        $server = new Server($name, $username, $host);
        $servers = $this->getServers();
        $servers[$name] = $server;

        $configFile = dirname(__FILE__) . "/../../config/servers.php";

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
}