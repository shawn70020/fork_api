<?php
require_once("../models/db_connect.php");
class member extends sql
{

    public function __construct()
    {
        parent::__construct();
    }
    ##過濾
    public function GetSQLValueString($theValue, $theType)
    {
        switch ($theType) {
            case "string":
                $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_MAGIC_QUOTES) : "";
                break;
            case "int":
                $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) : "";
                break;
            case "email":
                $theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_EMAIL) : "";
                break;
        }
        return $theValue;
    }
    ##撈出目前登入會員資料
    public function login_select($fields, $id)
    {
        $data = [];
        $sql_select = "SELECT $fields FROM member WHERE username=?";
        $stmt = $this->link->prepare($sql_select);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($data['id'], $data['username'], $data['passwd'], $data['level'], $data['status']);
        $stmt->fetch();
        $stmt->close();
        return $data;
    }
    ##撈出登入中會員資料
    public function m_select($uid)
    {
        $query_Member = "SELECT * FROM member WHERE id = $uid";
        $RecMember = $this->link->query($query_Member);
        while ($value = mysqli_fetch_assoc($RecMember)) {
            $arr[] = $value;
        }
        return $arr;
    }
    ##更新登入中會員資料
    public function mem_update($uid, $data)
    {
        $username = $data['username'];
        $passwd = $data['passwd'];
        $passwdo = $data['passwdo'];
        $cpasswd = $data['cpasswd'];
        $realname = $data['realname'];
        $email = $data['email'];

        $realname = $this->GetSQLValueString($realname, 'string');
        $email = $this->GetSQLValueString($email, 'string');
        $query_update = "UPDATE member SET username=?, passwd=?, realname=?, email=? WHERE id=?";
        $stmt = $this->link->prepare($query_update);
        ##檢查是否有修改密碼
        $mpass = $passwdo;
        if (($passwd != "") && ($passwd == $cpasswd)) {
            $mpass = password_hash($passwd, PASSWORD_DEFAULT);
        }
        $stmt->bind_param(
            "ssssi",
            $username,
            $mpass,
            $realname,
            $email,
            $uid
        );
        $stmt->execute();
        $stmt->close();
        if (($passwd != "") && ($passwd == $cpasswd)) {
            return false;
        }
    }
    ##檢查是否有同帳號會員
    public function user_check($data)
    {
        $username = $data['username'];
        $query_RecFindUser = "SELECT username FROM member WHERE username='{$username}'";
        $RecFindUser = $this->link->query($query_RecFindUser);
        if ($RecFindUser->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }
    ##檢查是否有同信箱會員
    public function email_check($data)
    {
        $email = $data['email'];
        $query_RecFindUser = "SELECT email FROM member WHERE email='{$email}'";
        $RecFindUser = $this->link->query($query_RecFindUser);
        if ($RecFindUser->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }
    ##新增會員
    public function mem_join($data)
    {
        $realname = $data['realname'];
        $username = $data['username'];
        $email = $data['email'];
        $passwd = $data['password'];
        $realname1 = $this->GetSQLValueString($realname, 'string');
        $username1 = $this->GetSQLValueString($username, 'string');
        $passwd1 =  password_hash($passwd, PASSWORD_DEFAULT);
        $email1 = $this->GetSQLValueString($email, 'string');
        //執行新增的動作
        $query_insert = "INSERT INTO member (realname, username, passwd, email, jointime) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->link->prepare($query_insert);
        $stmt->bind_param(
            "ssss",
            $realname1,
            $username1,
            $passwd1,
            $email1
        );
        $stmt->execute();
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        } else {
            return false;
        }
    }
    ##選擇該頁會員
    public function mem_show($condition, $limit)
    {
        $total_limit = "SELECT * FROM member WHERE $condition ORDER BY jointime ASC LIMIT $limit";
        $limit_record = $this->link->query($total_limit);

        while ($value = mysqli_fetch_array($limit_record)) {
            $arr[] = $value;
        }
        if (isset($arr)) {
            return $arr;
        } else {
            return false;
        }
    }
    ##會員總量及頁數
    public function mem_page($page_start, $condition)
    {
        $total = "SELECT * FROM member WHERE $condition ORDER BY jointime ASC";
        $total_record = $this->link->query($total);
        $totals = $total_record->num_rows;
        $total_pages = ceil($totals / $page_start);

        $arr[0]  = $totals;
        $arr[1]  = $total_pages;
        return $arr;
    }
    ##檢查會員密碼
    public function check_passwd($uid)
    {
        $sql_select = "SELECT passwd FROM member WHERE id = ?";
        $stmt = $this->link->prepare($sql_select);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $stmt->bind_result($passwd);
        $stmt->fetch();
        return $passwd;
    }
    ##更新選中會員狀態
    public function update_member($status, $id)
    {
        $query_update = "UPDATE member SET status=? WHERE id =?";
        $stmt = $this->link->prepare($query_update);
        $stmt->bind_param(
            "ii",
            $status,
            $id
        );
        $stmt->execute();
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
    ##更新登入中會員儲值金
    public function cash_store($now_cash, $value, $uid)
    {
        $num = $now_cash + $value;
        $query_update = "UPDATE member set cash=? WHERE id =? ";
        $stmt = $this->link->prepare($query_update);
        $stmt->bind_param(
            "ii",
            $num,
            $uid
        );
        $stmt->execute();
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
