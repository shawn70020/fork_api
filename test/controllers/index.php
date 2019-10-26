<?php
require_once("../models/product_class.php");
require_once("../libs/Smarty.class.php");
session_start();
$smarty = new Smarty;
$user = '';

if (isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"] != "")) {
    $user = $_SESSION["loginMember"];
}
if (isset($_SESSION["memberLevel"]) && ($_SESSION["memberLevel"] == 1)) {
    $user = "管理員";
}
$page_start = 6;
$num_page = 1;
$search = 0;
$search_value = '';
$flag = '';
if (isset($_GET['page'])) {
    $num_page = $_GET['page'];
    if (preg_match("^[A-Za-z]+$^", $num_page)) {
        header("Location: admin.php");
    };
    if ($num_page < 1) {
        header("Location: admin.php");
    }
}
$start_record = ($num_page - 1) * $page_start;
$limit = "$start_record,$page_start";
if (isset($_GET["search"])) {
    $search = 1;
    $product_search = new product();
    $search_value = $_GET["search"];
    $condition = "name LIKE '%$search_value%'";
    $result = $product_search->p_show($condition, $limit);
    $flag = $result === false ? "無搜尋結果" : '';
    $page_result = $product_search->p_page($page_start, $condition);
    $totals  = $page_result[0];
    $total_pages  = $page_result[1];
} else {
    $index_show = new product();
    $condition = 1;
    $result = $index_show->p_show($condition, $limit);
    $page_result = $index_show->p_page($page_start, $condition);
    $totals  = $page_result[0];
    $total_pages  = $page_result[1];
}


$smarty->assign("user", $user);
$smarty->assign("flag", $flag);
$smarty->assign("search", $search);
$smarty->assign("search_value", $search_value);
$smarty->assign("arr", $result);
$smarty->assign("num_page", $num_page);
$smarty->assign("total_pages", $total_pages);
$smarty->assign("totals", $totals);
$smarty->display("../index.html");
