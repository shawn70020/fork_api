<?php
require_once("../models/order_class.php");
require_once("../controllers/admin_check.php");
require_once("../libs/Smarty.class.php");
$smarty = new Smarty;
$uid = $_SESSION["uid"];

##撈出點擊訂單詳細資料
$total_price = 0;
$id = $_GET["id"];
$order = new order();
$result = $order->order_select($id);
foreach ($result as $keys => $values) {
	$orderid = $values["orderid"];
	$total_price = $total_price + ($values["num"] * $values["price"]);
}

$smarty->assign("arr", $result);
$smarty->assign("orderid", $orderid);
$smarty->assign("total", $total_price);
$smarty->display("../views/admin_order.html");
