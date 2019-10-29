<?php
require_once("../models/member_class.php");
header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if ($_POST["action"] == 'join') {
        $msg = [];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $realname = $_POST["realname"];
        $email = $_POST["email"];
        $data = array("username" => $username, "password" => $password, "realname" => $realname, "email" => $email);
        $mem_join = new member();
        $u_result = $mem_join->user_check($data);
        if ($u_result === false) {
            $array["used"] = "此帳號已有人使用！";
        } else {
            $e_result = $mem_join->email_check($data);
            if($e_result === false){
            $array["used"] = "此信箱已有人使用！";
            }
            $result1 = $mem_join->mem_join($data);
            if ($result1 == true) {
                $array["join"] = "註冊成功！請重新登入";
            } else {
                $array["fail"] = "註冊失敗！";
            }
        }
    }
    echo json_encode($array);
    exit;
}
