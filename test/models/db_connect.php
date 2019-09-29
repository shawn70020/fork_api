<?php

class sql
{
    private $mysql_address = "localhost";
    private $mysql_username = "shawnyan";
    private $mysql_password = "3027azsx";
    private $mysql_database = "a";
    public $link;
    private $error_message = "";
    public $passwd;
    public function __construct()
    {
        $this->link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($this->mysql_address, $this->mysql_username, $this->mysql_password));

        if (mysqli_connect_errno()) {
            $this->error_message = "Failed to connect to MySQL: " . mysqli_connect_error();
            echo $this->error_message;
            return false;
        }
        mysqli_query($GLOBALS["___mysqli_ston"], "SET NAMES utf8");
        mysqli_query($this->link, "SET NAMES utf8");
        mysqli_query($this->link, "SET CHARACTER_SET_database= utf8");
        mysqli_query($this->link, "SET CHARACTER_SET_CLIENT= utf8");
        mysqli_query($this->link, "SET CHARACTER_SET_RESULTS= utf8");

        if (!(bool) mysqli_query($this->link, "USE " . $this->mysql_database)) {
            $this->error_message = 'Database ' . $this->mysql_database . ' does not exist!';
        }
    }
    public function fetch($data){
        while ($value = mysqli_fetch_assoc($data)) {
            $arr[] = $value;
        }
        if (isset($arr)) {
            return $arr;
        } else {
            return false;
        }
    }
}
