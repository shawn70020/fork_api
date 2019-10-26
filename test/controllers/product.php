<?php
require_once("../models/product_class.php");
require_once("../models/shopping_class.php");
require_once("../controllers/member_check.php");
require_once("../libs/Smarty.class.php");
$smarty = new Smarty;
$user = $_SESSION["loginMember"];
$id = $_GET["id"];
$p_select = new product();
$result = $p_select->p_select($id);
$id1 = $result['id'];
$name = $result['name'];
$content = $result['content'];
$price = $result['price'];
$num = $result['num'];
$image = $result['image'];
$jointime = $result['jointime'];

$smarty->assign("user", $user);
$smarty->assign("id", $id1);
$smarty->assign("name", $name);
$smarty->assign("content", $content);
$smarty->assign("price", $price);
$smarty->assign("num", $num);
$smarty->assign("image", $image);
$smarty->assign("jointime", $jointime);
$smarty->display("../views/product.html");
