<?php

class Page
{
    private $isClosed;
    private $closedText;
    private $mysqlHost;
    private $mysqlLogin;
    private $mysqlPassword;
    private $mysqlDb;
    public $debugLevel;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->getConfig();
    }


    public function getConfig()
    {
        require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
        $this->isClosed = $config['isClosed'];
        $this->closedText = $config['closedText'];
        $this->mysqlHost = $config['mysqlHost'];
        $this->mysqlLogin = $config['mysqlLogin'];
        $this->mysqlPassword = $config['mysqlPassword'];
        $this->mysqlDb = $config['mysqlDb'];
    }

    /**
     * @return mixed
     */
    public function getMysqlHost()
    {
        return $this->mysqlHost;
    }

    /**
     * @return mixed
     */
    public function getMysqlLogin()
    {
        return $this->mysqlLogin;
    }

    /**
     * @return mixed
     */
    public function getMysqlPassword()
    {
        return $this->mysqlPassword;
    }

    /**
     * @return mixed
     */
    public function getMysqlDb()
    {
        return $this->mysqlDb;
    }

    public function printPage($content, $pathToDesign, $title)
    {
        global $user, $mysql, $page, $data, $logs;
        require_once($pathToDesign);
    }
}