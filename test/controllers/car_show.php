<?php
require_once("../models/shopping_class.php");
session_start();
$uid = $_SESSION["uid"];
$total_price = 0;
$total_item = 0;
$output = '
<div class="table-responsive" id="order_table">
	<table class="table table-bordered table-striped">
		<tr>
            <th width="20%">商品名</th>
            <th width="5%">數量</th>
            <th width="10%">價錢</th>
            <th width="10%">總額</th>
            <th width="5%">刪除</th>
        </tr>
';
$car = new shopping();
$result = $car->fetch_car($uid);
if ($result > 0) {
    $result = $car->car_result($uid);
    foreach ($result as $keys => $values) {
        $output .= '
    <tr>
        <td>' . $values["pname"] . '</td>
        <td>' . $values["num"] . '</td>
        <td align="right"> ' . $values["price"] . '</td>
        <td align="right">NT$ ' . $values["num"] * $values["price"] . '</td>
        <td><button name="delete" class="btn btn-danger btn-xs delete" id="' . $values["pid"] . '">移除</button></td>
    </tr>
    ';
        $total_price = $total_price + ($values["num"] * $values["price"]);
        $total_item = $total_item + 1;
    }
    $output .= '
<tr>
    <td colspan="3" align="right"</td>
    <td align="right">NT$ ' . $total_price . '</td>
    <td></td>
</tr>
';
} else {
    $output .= '
    <tr>
    	<td colspan="5" align="center">
    		購物車目前為空
    	</td>
    </tr>
    ';
}
$output .= '</table></div>';
$data = array(
    'cart_details'        =>    $output,
    'total_price'        =>    '$' . number_format($total_price, 2),
    'total_item'        =>    $total_item
);

echo json_encode($data);
exit;
