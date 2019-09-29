<?php
require_once("../models/db_connect.php");
class order extends sql
{

    public function __construct()
    {
        parent::__construct();
    }
    ##撈出此會員近兩筆訂單
    public function order_fetch($uid)
    {
        $sql_query = "SELECT * FROM orders WHERE uid = $uid ORDER BY orderid DESC LIMIT 2";
        $total_record = $this->link->query($sql_query);
        while ($value = mysqli_fetch_assoc($total_record)) {
            $arr[] = $value;
        }
        return $arr;
    }
    ##撈出選中訂單詳細資料
    public function order_select($id)
    {
        $sql_query = "SELECT * FROM orders_detail WHERE orderid = $id";
        $total_record = $this->link->query($sql_query);
        while ($value = mysqli_fetch_assoc($total_record)) {
            $arr[] = $value;
        }
        return $arr;
    }
    ##選擇該頁訂單
    public function order_show($condition, $limit)
    {
        $total_limit = "SELECT * FROM orders WHERE $condition ORDER BY join_time ASC LIMIT $limit";
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
    ##訂單總量及總頁數
    public function order_page($page_start, $condition)
    {
        $total = "SELECT * FROM orders WHERE $condition ORDER BY join_time ASC";
        $total_record = $this->link->query($total);
        $totals = $total_record->num_rows;
        $total_pages = ceil($totals / $page_start);

        $this->link->close();

        $arr[0]  = $totals;
        $arr[1]  = $total_pages;
        return $arr;
    }
    ##更新訂單狀態
    public function update_order($status, $oid)
    {
        $query_update = "UPDATE orders SET status=? WHERE orderid =?";
        $stmt = $this->link->prepare($query_update);
        $stmt->bind_param(
            "ii",
            $status,
            $oid
        );
        $stmt->execute();
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
}
