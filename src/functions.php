<?php

function listCommands()
{
    echo "---------------------\n";
    echo "Welcome to QuickSSH, the easy SSH connection manager.\n";
    echo "---------------------\n";
    echo "qssh <name>                      | SSH into a named server\n";
    echo "qssh set <name> <user>@<host>    | Set a new named connection\n";
    echo "qssh unset <name>                | Remove a named connection\n";
    echo "qssh list                        | List all connections\n";
    echo "---------------------\n";
}

function checkNamedServerExists($name, $servers)
{
    $exists = false;
    $connectTo = null;

    foreach ($servers as $server) {
        if ($server["name"] === $name) {
            $exists = true;
            $connectTo = $server;
        }
    }

    if ($exists) {
        return $connectTo;
    }

    return false;
}

function parseConnectionName($connection)
{
    if (strpos($connection, "@")) {
        $connection = explode("@", $connection);
    }

    return $connection;
}

function listAllServers($servers): bool
{
    if (!count($servers)) {
        echo "You don't have any servers saved yet. Use qssh set <name> <user>@<host> to add one.\n";
        return false;
    } else {
        echo "---------------------\n";

        foreach ($servers as $server) {
            echo "alias: ${server["name"]}\n";
            echo "user: ${server["user"]}\n";
            echo "host: ${server["host"]}\n";
            echo "---------------------\n";
        }

        return true;
    }
}

function connectToServer($user, $host)
{
    $script = dirname(__FILE__) . "/../bin/connect.sh";

    echo "Connecting to server via SSH using $user@$host...\n";
    echo "This process will close when you exit the SSH session.\n";
    shell_exec("$script $user $host");
    echo "Until next time!\n";
    exit(1);
}

function serverNotFound()
{
    echo "QSSH Error: No server with that name exists.\n";
    exit(0);
}

function unsetServer($serverName, $servers)
{
    foreach ($servers as $index => $server) {
        if ($server["name"] === $serverName) {
            unset($servers[$index]);

            echo "Server $serverName has been removed.\n";
            $handler = fopen(dirname(__FILE__) . "/../config/servers.php", "w");
            fwrite($handler, "<?php\n\nreturn " . var_export($servers, true) . ";\n");
            fclose($handler);
        }
    }
}

function setServer($name, $user, $host, $servers)
{
    echo "Setting server $name to $user@$host...\n";
    $servers[] = [
        "name" => $name,
        "user" => $user,
        "host" => $host
    ];
    $handler = fopen(dirname(__FILE__) . "/../config/servers.php", "w");
    fwrite($handler, "<?php\n\nreturn " . var_export($servers, true) . ";\n");
    fclose($handler);
    echo "The '{$name}' shortcut has been registered. You can now call qssh {$name} to connect to your server.\n";
}

function getConfigValue($key)
{
    $config = require dirname(__FILE__) . "/../config/qssh.php";
    return $config[$key];
}