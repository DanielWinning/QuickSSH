<?php

namespace QuickSSH\Server;

class Server
{
    public string $name;
    public string $host;
    public string $user;

    public function __construct(string $name, string $user, string $host)
    {
        $this->name = $name;
        $this->host = $host;
        $this->user = $user;
    }

    public static function __set_state($array)
    {
        return new Server($array["name"], $array["user"], $array["host"]);
    }
}