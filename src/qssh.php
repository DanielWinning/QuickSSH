<?php

require_once dirname(__FILE__) . "/functions.php";
$servers = array();

if (file_exists(dirname(__FILE__) . "/../config/servers.php")) {
    $servers = include(dirname(__FILE__) . "/../config/servers.php");
}
/*$servers = require_once dirname(__FILE__) . "/../config/servers.php";*/

if (count($argv) < 2) {
    listCommands();
} else if (count($argv) == 2) {
    if ($argv[1] == "list") {
        listAllServers($servers);
    } else if (in_array($argv[1], ["-v", "--version"])) {
        echo "v" . getConfigValue("version");
    } else {
        $serverToConnectTo = parseConnectionName($argv[1]);

        if (is_array($serverToConnectTo)) {
            $savedServer = checkNamedServerExists($serverToConnectTo[1], $servers);

            if ($savedServer) {
                connectToServer($serverToConnectTo[0], $savedServer["host"]);
            } else {
                serverNotFound();
            }
        } else {
            $savedServer = checkNamedServerExists($serverToConnectTo, $servers);

            if ($savedServer) {
                connectToServer($savedServer["user"], $savedServer["host"]);
            } else {
                serverNotFound();
            }
        }
    }
} else if (count($argv) == 3) {
    if ($argv[1] === "unset") {
        $savedServer = checkNamedServerExists($argv[2], $servers);

        if ($savedServer) {
            unsetServer($savedServer["name"], $servers);
        } else {
            echo "QSSH Error: Server does not exist.\n";
            exit(0);
        }
    } else {
        echo "QSSH Error: Command not recognised.\n";
        exit(0);
    }
} else if (count($argv) == 4) {
    if ($argv[1] === "set") {
        $connection = parseConnectionName($argv[3]);
        $user = $connection[0];
        $host = $connection[1];

        if (!checkNamedServerExists($argv[2], $servers)) {
            setServer($argv[2], $user, $host, $servers);
        } else {
            echo "QSSH Error: Server already exists.\n";
            exit(0);
        }
    } else {
        echo "Error";
    }
}