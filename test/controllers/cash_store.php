<?php
require_once("../models/shopping_class.php");
require_once("../controllers/member_check.php");
require_once("../libs/Smarty.class.php");
$smarty = new Smarty;

$uid = $_SESSION["uid"];
$user = $_SESSION["loginMember"];
$cash = new shopping();
$now_cash = $cash->cash_now($uid);

$smarty->assign("user", $user);
$smarty->assign("now_cash", $now_cash);
$smarty->display("../views/cash_store.html");
