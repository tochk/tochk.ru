<?php

class page_init
{
    public $timer = array(
        'start' => 0,
        'ms_conn' => 0,
        'ms_query' => 0,
        'history' => 0,
        'end' => 0,);
    public $id, $login, $email, $closed, $admin, $ip, $time, $day, $month, $year, $update_text, $url, $reffer;

    public function page_init()
    {
        if (isset($_SESSION['id']))
            $this->id = $_SESSION['id'];
        $this->time = time();
        $this->day = date('d');
        $this->month = date('n');
        $this->year = date('Y');
    }

    public function timer_init()
    {
        $temp = explode(" ", microtime());
        $this->timer["start"] = $temp[1] + $temp[0];
    }

    public function installer_mysql_conn()
    {
        global $config;
        mysql_connect($config['mysql_host'], $config['mysql_login'], $config['mysql_password']) or die(mysql_error());
    }

    public function mysql_conn()
    {
        global $config;
        mysql_connect($config['mysql_host'], $config['mysql_login'], $config['mysql_password']) or die(mysql_error());
        mysql_select_db("{$config['mysql_db']}") or die(mysql_error());
        mysql_query("SET CHARACTER SET utf8");
        header('Content-Type: text/html; charset=utf-8');
        $temp = explode(" ", microtime());
        $this->timer["ms_conn"] = $temp[1] + $temp[0];
    }

    public function user_uri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $this->url = mysql_real_escape_string($_SERVER['REQUEST_URI']);
        } else {
            $this->url = "ERROR";
        }
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $this->reffer = mysql_real_escape_string($_SERVER['HTTP_REFERER']);
        } else {
            $this->reffer = "ERROR";
        }
    }

    public function mysql_userinfo()
    {
        global $config;
        $query = "SELECT * FROM `{$config['table_prefix']}users` WHERE `id`='$this->id' LIMIT 1";
        $sql = mysql_query($query) or die(mysql_error());
        $array = mysql_fetch_assoc($sql);
        $this->login = $array['login'];
        $this->email = $array['email'];
        $this->admin = $array['admin'];
    }

    public function mysql_config()
    {
        global $config;
        $this->closed = $config['closed'];
        $this->update_text = $config['update_text'];
    }

    public function user_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $stat_ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $stat_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $stat_ip = $_SERVER['REMOTE_ADDR'];
        }
        $this->ip = mysql_real_escape_string($stat_ip);
    }

    public function stat()
    {
        global $config;
        $days_query = "SELECT * FROM `{$config['table_prefix']}stat` WHERE `day`='$this->day' AND `mou`='$this->month' AND `year`='$this->year' LIMIT 1";
        $days_sql = mysql_query($days_query) or die(mysql_error());
        $days_arr = mysql_fetch_assoc($days_sql);
        $days_num = mysql_num_rows($days_sql);
        if ($days_num != 1) {
            $query = "INSERT INTO `{$config['table_prefix']}stat` SET `day`='$this->day', `mou`='$this->month' ,`year`='$this->year', `hits` = '1', hosts = '1'";
            $sql = mysql_query($query) or die(mysql_error());
            $query = "TRUNCATE {$config['table_prefix']}temp_stat";
            $sql = mysql_query($query) or die(mysql_error());
            $query = "INSERT INTO `{$config['table_prefix']}temp_stat` SET `time`='$this->time', `hits`=1, `ip`='$this->ip'";
            $sql = mysql_query($query) or die(mysql_error());
        } else {
            $days_arr['hits']++;
            $history2_query = "SELECT * FROM `{$config['table_prefix']}temp_stat` WHERE `ip`='$this->ip' LIMIT 1";
            $history2_sql = mysql_query($history2_query) or die(mysql_error());
            $history2_arr = mysql_fetch_assoc($history2_sql);
            $history2_num = mysql_num_rows($history2_sql);
            if ($history2_num == 0) {
                $days_arr['hosts']++;
                $query = "INSERT INTO `{$config['table_prefix']}temp_stat` SET `time`='$this->time', `hits`=1, `ip`='$this->ip'";
                $sql = mysql_query($query) or die(mysql_error());
            } else {
                $history2_arr['hits']++;
                $query = "UPDATE `{$config['table_prefix']}temp_stat` SET `hits`='{$history2_arr['hits']}' WHERE `ip`='$this->ip' LIMIT 1";
                $sql = mysql_query($query) or die(mysql_error());
            }
            $query = "UPDATE `{$config['table_prefix']}stat` SET `hits`='{$days_arr['hits']}', `hosts`='{$days_arr['hosts']}' WHERE `day`='$this->day' AND `mou`='$this->month' AND `year`='$this->year' LIMIT 1";
            $sql = mysql_query($query) or die(mysql_error());
        }
        $temp = microtime();
        $temp = explode(" ", $temp);
        $this->timer["history"] = $temp[1] + $temp[0];
    }

    public function timer_save()
    {
        global $config;
        $temp = microtime();
        $temp = explode(" ", $temp);
        $this->timer["end"] = $temp[1] + $temp[0];
        $ms_conn = $this->timer["ms_conn"] - $this->timer["start"];
        $ms_query = $this->timer["ms_query"] - $this->timer["ms_conn"];
        $history = $this->timer["history"] - $this->timer["ms_query"];
        $end = $this->timer["end"] - $this->timer["history"];
        mysql_select_db("{$config['table_prefix']}main") or die(mysql_error());
        $query = "INSERT INTO `{$config['table_prefix']}stat_pages` SET `time`='$this->time', `ip`='$this->ip', `page`='$this->url', `ms_conn`='$ms_conn', `ms_query`='$ms_query', `history`='$history', `end`=$end, `reff`='$this->reffer'";
        $sql = mysql_query($query) or die(mysql_error());
    }

    public function user_log()
    {
        //todo: логирование действий юзера
        $temp = microtime();
        $temp = explode(" ", $temp);
        $this->timer["ms_query"] = $temp[1] + $temp[0];
    }

    public function mysql_query_stat()
    {
        $temp = microtime();
        $temp = explode(" ", $temp);
        $this->timer["ms_query"] = $temp[1] + $temp[0];
    }

    public function pjax_init($content, $ds_path, $title)
    {
        global $config;
        if ($config['pjax'] == 1) {
            if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
                echo $content;
                echo "<title>$title - {$config['site_name']}</title>";
            } else {
                include($ds_path);
            }
        }
    }

    public function std_page_init()
    {
        $this->timer_init();
        $this->mysql_conn();
        $this->user_uri();
        $this->mysql_config();
        if ($this->closed == 1) {
            header('Location: /error/closed.php');
            exit();
        }
        $this->user_ip();
        if (isset($_SESSION['id'])) {
            $this->mysql_userinfo();
            $this->user_log();
        } else {
            $this->mysql_query_stat();
        }
        $this->stat();
    }
}
