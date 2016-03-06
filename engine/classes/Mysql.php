<?php

class Mysql
{
    public $connection;

    public function connect($host, $username, $password, $db_name, $debug_level)
    {
        $this->connection = new mysqli($host, $username, $password, $db_name);
        if (mysqli_connect_errno()) {
            if ($debug_level == 1)
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }
        if (!$this->connection->set_charset("utf8"))
            printf("error while loading utf8 %s", $this->connection->error);
        return $this->connection;
    }


}