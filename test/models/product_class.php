<?php
require_once("../models/db_connect.php");
class product extends sql
{

    public function __construct()
    {
        parent::__construct();
    }


    ##選擇該頁商品
    public function p_show($condition, $limit)
    {
        $total_limit = "SELECT * FROM product WHERE $condition ORDER BY jointime ASC LIMIT $limit";
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

    ##商品總量及頁數
    public function p_page($page_start, $condition)
    {
        $total = "SELECT * FROM product WHERE $condition ORDER BY jointime ASC";
        $total_record = $this->link->query($total);
        $totals = $total_record->num_rows;
        $total_pages = ceil($totals / $page_start);

        $arr[0]  = $totals;
        $arr[1]  = $total_pages;
        return $arr;
    }
    ##選擇單一商品
    public function p_select($id)
    {
        $data = [];
        $total_query = "SELECT * FROM product WHERE id=?";
        $stmt = $this->link->prepare($total_query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($data['id'], $data['name'], $data['content'], $data['price'], $data['num'], $data['image'], $data['sort'], $data['jointime']);
        $stmt->fetch();
        $stmt->close();
        $this->link->close();
        return $data;
    }
    ##選擇分類商品
    public function sort_select($condition, $limit)
    {
        $total_limit = "SELECT * FROM product WHERE $condition ORDER BY jointime ASC LIMIT $limit";
        $limit_record = $this->link->query($total_limit);
        $result = $this->fetch($limit_record);
        return $result;
    }
    ##分類商品頁數
    public function sort_page($page_start, $condition)
    {
        $total = "SELECT * FROM product WHERE $condition ORDER BY jointime ASC";
        $total_record = $this->link->query($total);
        $totals = $total_record->num_rows;
        $total_pages = ceil($totals / $page_start);

        $arr[0]  = $totals;
        $arr[1]  = $total_pages;
        return $arr;
    }
    public function pname_check($data)
    {
        $pname = $data['pname'];
        $query_RecFindUser = "SELECT name FROM product WHERE name = '{$pname}'";
        $RecFindUser = $this->link->query($query_RecFindUser);
        if ($RecFindUser->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }
    ##新增商品
    public function product_create($data)
    {
        $pname = $data['pname'];
        $num = $data['num'];
        $price = $data['price'];
        $content = $data['content'];
        $image = $data['image'];
        $query_insert = "INSERT INTO product (name,content,price,num,image,jointime) VALUES (?,?,?,?,?,NOW())";
        $stmt = $this->link->prepare($query_insert);
        $stmt->bind_param(
            "ssiis",
            $pname,
            $content,
            $price,
            $num,
            $image
        );
        $stmt->execute();
    }
    ##更新商品
    public function product_update($data, $id)
    {
        $name = $data['pname'];
        $num = $data['num'];
        $price = $data['price'];
        $content = $data['content'];
        $image = $data['images'];
        $query_update = "UPDATE product SET name=?,num=?,price=?,content=?,image=? WHERE id=?";
        $stmt = $this->link->prepare($query_update);
        $stmt->bind_param(
            "siissi",
            $name,
            $num,
            $price,
            $content,
            $image,
            $id
        );
        $stmt->execute();
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
    ##刪除商品
    public function product_delete($pid)
    {
        $sql_query = "DELETE FROM product WHERE id= $pid";
        $this->link->query($sql_query);
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
