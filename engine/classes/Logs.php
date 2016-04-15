<?php

class Logs
{
    private $start;
    private $createClasses;
    private $end;
    private $info;
    private $referer;
    private $clientIp;
    private $userId;
    private $time;
    private $action;
    private $url;

    public function __construct()
    {
        $temp = explode(" ", microtime());
        $this->start = $temp[1] + $temp[0];
        $this->referer = $_SERVER['HTTP_REFERER'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $this->clientIp = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $this->clientIp = $_SERVER['REMOTE_ADDR'];
        }
        $this->time = time();
        $this->userId = $_SESSION['id'];
        $this->url = $_SERVER['REQUEST_URI'];
    }

    public function setCreateClasses()
    {
        $temp = explode(" ", microtime());
        $this->createClasses = $temp[1] + $temp[0];
    }

    public function setEnd()
    {
        $temp = explode(" ", microtime());
        $this->end = $temp[1] + $temp[0];
    }

    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }


    public function writeToDb($mysql)
    {
        if (!isset($this->referer))
            $this->referer = 'unknown';
        if (!isset($this->userId))
            $this->userId = 0;
        if (!isset($this->action))
            $this->action = 'unknown';
        if (!isset($this->info))
            $this->info = 'empty';
        if (!isset($this->url))
            $this->url = 'unknown';
        $query = "INSERT INTO `logs` (`createClasses`, `end`, `info`, `url`, `referer`, `clientIp`, `userId`, `time`, `action`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysql->connection->prepare($query);
        $temp = $this->createClasses - $this->start;
        $temp2 = $this->end - $this->createClasses;
        $stmt->bind_param("sssssssss", $temp, $temp2, $this->info, $this->url, $this->referer, $this->clientIp, $this->userId, $this->time, $this->action);
        $stmt->execute();
        $stmt->close();
    }
}