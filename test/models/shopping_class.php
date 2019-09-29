<?php
require_once("../models/db_connect.php");
class shopping extends sql
{

    public function __construct()
    {
        parent::__construct();
    }

    ##檢查購物車是否有同商品
    public function car_check($uid, $pid)
    {
        $sql_query = "SELECT * FROM cart WHERE uid= $uid AND pid = $pid";
        $total_record = $this->link->query($sql_query);
        $totals = mysqli_num_rows($total_record);
        return $totals;
    }
    ##新增至購物車
    public function car_push($data, $uid)
    {
        $pid = $data['product_id'];
        $pname = $data['product_name'];
        $num = $data['product_quantity'];
        $now_num = $data['product_num'];
        $price = $data['product_price'];
        $image = $data['product_image'];
        $query_insert = "INSERT INTO cart (uid ,pid ,pname,price,num,now_num,image,join_time) VALUES (?, ?, ?, ?, ?, ?, ?,NOW())";
        $stmt = $this->link->prepare($query_insert);
        $stmt->bind_param(
            "iisiiis",
            $uid,
            $pid,
            $pname,
            $price,
            $num,
            $now_num,
            $image
        );
        $stmt->execute();
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
    ##編輯購物車
    public function car_edit($num, $uid, $pid)
    {
        $sql_query = "SELECT num FROM cart WHERE pid = $pid AND uid = $uid";
        $total_record = $this->link->query($sql_query);
        $total = mysqli_fetch_row($total_record);
        $totals =  $total[0] + $num;
        $query_update = "UPDATE cart SET num=? WHERE pid = $pid AND uid = $uid";
        $stmt = $this->link->prepare($query_update);
        $stmt->bind_param(
            "i",
            $totals,
        );
        $stmt->execute();
    }
    ##刪除購物車
    public function car_delete($pid)
    {
        $sql_query = "DELETE FROM cart WHERE pid= $pid";
        $this->link->query($sql_query);
    }
    ##檢查是否已有此會員購物車
    public function fetch_car($uid)
    {
        $sql_query = "SELECT * FROM cart WHERE uid = $uid ";
        $total_record = $this->link->query($sql_query);
        $totals = mysqli_num_rows($total_record);
        return $totals;
    }
    #撈出購物車資料
    public function car_result($uid)
    {
        $sql_query = "SELECT * FROM cart WHERE uid = $uid ";
        $total_record = $this->link->query($sql_query);
        while ($value = mysqli_fetch_assoc($total_record)) {
            $arr[] = $value;
        }
        if (isset($arr)) {
            return $arr;
        } else {
            return false;
        }
    }
    ##按結帳更新購物車
    public function update_car($num, $pid, $uid)
    {
        for ($i = 0; $i <= count($pid) - 1; $i++) {
            $query_update = "UPDATE cart SET num=? WHERE pid =? AND uid=?";
            $stmt = $this->link->prepare($query_update);
            $stmt->bind_param(
                "iii",
                $num[$i],
                $pid[$i],
                $uid
            );
            $stmt->execute();
        }
    }
    ##撈出購物車商品庫存
    public function get_num($pid)
    {
        $data = [];
        for ($i = 0; $i <= count($pid) - 1; $i++) {
            $total_query = "SELECT num FROM product WHERE id=?";
            $stmt = $this->link->prepare($total_query);
            $stmt->bind_param("i", $pid[$i]);
            $stmt->execute();
            $stmt->bind_result($data[$i]);
            $stmt->fetch();
            $stmt->close();
        }
        return $data;
    }
    ##檢查購物車商品庫存
    public function check_enough($now_num, $num)
    {
        for ($i = 0; $i <= count($now_num) - 1; $i++) {
            if ($now_num[$i] < $num[$i]) {
                return false;
            } else {
                return true;
            }
        }
    }
    ##新增訂單
    public function order($uid)
    {
        $sql_query = "INSERT INTO orders(uid) VALUES($uid)";
        $this->link->query($sql_query);
        $sql = "SELECT orderid FROM orders WHERE uid = $uid ORDER BY orderid DESC LIMIT 1 ";
        $total_record = $this->link->query($sql);
        $totals = mysqli_fetch_row($total_record);
        return $totals;
    }
    ##新增訂單詳細資訊
    public function order_detail($orderid, $uid, $data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $query_insert = "INSERT INTO orders_detail (orderid ,uid ,pname,price,num) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->link->prepare($query_insert);
            $stmt->bind_param(
                "iisii",
                $orderid,
                $uid,
                $data[$i]['pname'],
                $data[$i]['price'],
                $data[$i]['num']
            );
            $stmt->execute();
        }
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
    ##結帳後更新商品庫存
    public function product_num($now_num, $num, $pid)
    {
        $arr = [];
        for ($i = 0; $i < count($num); $i++) {
            array_push($arr, $now_num[$i] - $num[$i]);
        }
        for ($i = 0; $i < count($num); $i++) {
            $query_update = "UPDATE product SET num=? WHERE id =?";
            $stmt = $this->link->prepare($query_update);
            $stmt->bind_param(
                "ii",
                $arr[$i],
                $pid[$i]
            );
            $stmt->execute();
        }
    }
    ##清空此會員購物車
    public function car_empty($uid)
    {
        $sql_query = "DELETE FROM cart WHERE uid= $uid";
        $this->link->query($sql_query);
    }
    ##撈出此會員儲值金
    public function cash_now($uid)
    {
        $sql_select = "SELECT cash FROM member WHERE id = ?";
        $stmt = $this->link->prepare($sql_select);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $stmt->bind_result($num);
        $stmt->fetch();
        return $num;
    }
    ##更新此會員儲值金
    public function cash_update($cash, $uid)
    {
        $query_update = "UPDATE member set cash=? WHERE id =? ";
        $stmt = $this->link->prepare($query_update);
        $stmt->bind_param(
            "ii",
            $cash,
            $uid
        );
        $stmt->execute();
    }
}
