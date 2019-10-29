<?php
session_start();
##檢查是否經過登入
if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
	header("Location: login.php");
}
if (isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"] != "")) {
    ##若帳號等級為 member 則導向會員中心
    if ($_SESSION["memberLevel"] == "0") {
        header("Location: member.php");
    }
}
