<?php
require_once("../models/shopping_class.php");
session_start();
$uid = $_SESSION["uid"];
if (isset($_POST["action"])) {
    $car = new shopping();
    if ($_POST["action"] == "add") {
        $data = array(
            'product_id'               =>     $_POST["product_id"],
            'product_name'             =>     $_POST["product_name"],
            'product_price'            =>     $_POST["product_price"],
            'product_quantity'         =>     $_POST["product_quantity"],
            'product_num'              =>     $_POST["product_num"],
            'product_image'            =>     $_POST["product_image"]
        );
        $pid = $data['product_id'];
        $num = $data['product_quantity'];
        $find = $car->car_check($uid, $pid);
        if ($find == 1) {
            $result = $car->car_edit($num, $uid, $pid);
        } else {
            $car->car_push($data, $uid);
        }
    }
    ##刪除購物車商品
    if ($_POST["action"] == 'remove') {
        $pid = $_POST["pid"];
        $car->car_delete($pid);
    }
    ##清空購物車
    if ($_POST["action"] == 'empty') {
        $car->car_empty($uid);
    }
}
