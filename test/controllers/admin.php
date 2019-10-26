<?php
require_once("../controllers/admin_check.php");
require_once("../libs/Smarty.class.php");
$smarty = new Smarty;
$smarty->display("../views/admin.html");
