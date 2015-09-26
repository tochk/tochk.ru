<?php

class tochkru_main
{
    var $config = array(
        'mysql_host' => 'localhost',
        'mysql_login' => 'root',
        'mysql_password' => '1234',
        'site_name' => 'tochk.ru',
        'pjax' => '1');
    public $timer = array(
        'start' => 0,
        'ms_conn' => 0,
        'ms_query' => 0,
        'history' => 0,
        'end' => 0,);
    public $id = 0;
    public $login = 'db_error';
    public $email = 'db@error';
    public $files = 0;
    public $filesn = 0;
    public $closed = 0;
    public $admin = 0;
    public $ip = 0;
    public $time = 0;
    public $day = 0;
    public $month = 0;
    public $year = 0;
    public $update_text = 'Технические работы';
    public $url = 0;
    public $reffer = 0;

    public function var_init()
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
        $temp = microtime();
        $temp = explode(" ", $temp);
        $this->timer["start"] = $temp[1] + $temp[0];
        $this->timer["ms_conn"] = $temp[1] + $temp[0];
        $this->timer["ms_query"] = $temp[1] + $temp[0];
        $this->timer["history"] = $temp[1] + $temp[0];
        $this->timer["end"] = $temp[1] + $temp[0];
    }

    public function installer_mysql_conn()
    {
        mysql_connect($this->config['mysql_host'], $this->config['mysql_login'], $this->config['mysql_password']) or die(mysql_error());
    }

    public function mysql_conn()
    {
        mysql_connect($this->config['mysql_host'], $this->config['mysql_login'], $this->config['mysql_password']) or die(mysql_error());
        mysql_select_db("tochkru_main") or die(mysql_error());
        mysql_query("SET CHARACTER SET utf8");
        header('Content-Type: text/html; charset=utf-8');
        $temp = microtime();
        $temp = explode(" ", $temp);
        $this->timer["ms_conn"] = $temp[1] + $temp[0];
    }

    public function user_uri()
    {
        $this->url = mysql_real_escape_string($_SERVER['REQUEST_URI']);
        $this->reffer = mysql_real_escape_string($_SERVER['HTTP_REFERER']);
    }

    public function mysql_userinfo()
    {
        $query = "SELECT * FROM `tochkru_users` WHERE `id`='$this->id' LIMIT 1";
        $sql = mysql_query($query) or die(mysql_error());
        $array = mysql_fetch_assoc($sql);
        $this->login = $array['login'];
        $this->email = $array['email'];
        $this->admin = $array['admin'];
        $this->files = $array['files'];
        $this->filesn = $array['filesn'];
    }

    public function mysql_config()
    {
        $query = "SELECT * FROM `tochkru_config` WHERE `id`='1' LIMIT 1";
        $sql = mysql_query($query) or die(mysql_error());
        $array = mysql_fetch_assoc($sql);
        $this->closed = $array['closed'];
        $this->update_text = $array['update'];
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
        $days_query = "SELECT * FROM `tochkru_stat` WHERE `day`='$this->day' AND `mou`='$this->month' AND `year`='$this->year' LIMIT 1";
        $days_sql = mysql_query($days_query) or die(mysql_error());
        $days_arr = mysql_fetch_assoc($days_sql);
        $days_num = mysql_num_rows($days_sql);
        if ($days_num != 1) {
            $query = "INSERT INTO `tochkru_stat` SET `day`='$this->day', `mou`='$this->month' ,`year`='$this->year', `hits` = '1', hosts = '1'";
            $sql = mysql_query($query) or die(mysql_error());
            $query = "DROP table tochkru_temp_stat";
            $sql = mysql_query($query) or die(mysql_error());
            $query = "CREATE TABLE IF NOT EXISTS `tochkru_temp_stat` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `ip` longtext COLLATE utf8_unicode_ci NOT NULL,
            `time` int(11) NOT NULL,
            `hits` int(11) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            $sql = mysql_query($query) or die(mysql_error());
            $query = "INSERT INTO `tochkru_temp_stat` SET `time`='$this->time', `hits`=1, `ip`='$this->ip'";
            $sql = mysql_query($query) or die(mysql_error());
        } else {
            $days_arr['hits']++;
            $history2_query = "SELECT * FROM `tochkru_temp_stat` WHERE `ip`='$this->ip' LIMIT 1";
            $history2_sql = mysql_query($history2_query) or die(mysql_error());
            $history2_arr = mysql_fetch_assoc($history2_sql);
            $history2_num = mysql_num_rows($history2_sql);
            if ($history2_num == 0) {
                $days_arr['hosts']++;
                $query = "INSERT INTO `tochkru_temp_stat` SET `time`='$this->time', `hits`=1, `ip`='$this->ip'";
                $sql = mysql_query($query) or die(mysql_error());
            } else {
                $history2_arr['hits']++;
                $query = "UPDATE `tochkru_temp_stat` SET `hits`='{$history2_arr['hits']}' WHERE `ip`='$this->ip' LIMIT 1";
                $sql = mysql_query($query) or die(mysql_error());
            }
            $query = "UPDATE `tochkru_stat` SET `hits`='{$days_arr['hits']}', `hosts`='{$days_arr['hosts']}' WHERE `day`='$this->day' AND `mou`='$this->month' AND `year`='$this->year' LIMIT 1";
            $sql = mysql_query($query) or die(mysql_error());
        }
        $temp = microtime();
        $temp = explode(" ", $temp);
        $this->timer["history"] = $temp[1] + $temp[0];
    }

    public function timer_save()
    {
        $temp = microtime();
        $temp = explode(" ", $temp);
        $this->timer["end"] = $temp[1] + $temp[0];
        $ms_conn = $this->timer["ms_conn"] - $this->timer["start"];
        $ms_query = $this->timer["ms_query"] - $this->timer["start"];
        $history = $this->timer["history"] - $this->timer["start"];
        $end = $this->timer["end"] - $this->timer["start"];
        mysql_select_db("tochkru_main") or die(mysql_error());
        $query = "INSERT INTO `tochkru_stat_pages` SET `time`='$this->time', `ip`='$this->ip', `page`='$this->url', `ms_conn`='$ms_conn', `ms_query`='$ms_query', `history`='$history', `end`=$end, `reff`='$this->reffer'";
        $sql = mysql_query($query) or die(mysql_error());
    }

    public function user_log()
    {
        //логирование действий юзера
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
        if ($this->config['pjax'] == 1) {
            if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
                echo $content;
                echo "<title>$title - {$this->config['site_name']}</title>";
            } else {
                include($ds_path);
            }
        }
    }

    public function std_page_init()
    {
        $this->var_init();
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

?>