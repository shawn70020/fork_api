<?php
class message
{
    private $mysql_address = "localhost";
    private $mysql_username = "shawnyan";
    private $mysql_password = "3027azsx";
    private $mysql_database = "a";
    public $link;
    private $error_message = "";
    public $passwd;
    public function __construct()
    {
        $this->link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($this->mysql_address, $this->mysql_username, $this->mysql_password));

        if (mysqli_connect_errno()) {
            $this->error_message = "Failed to connect to MySQL: " . mysqli_connect_error();
            echo $this->error_message;
            return false;
        }
        mysqli_query($GLOBALS["___mysqli_ston"], "SET NAMES utf8");
        mysqli_query($this->link, "SET NAMES utf8");
        mysqli_query($this->link, "SET CHARACTER_SET_database= utf8");
        mysqli_query($this->link, "SET CHARACTER_SET_CLIENT= utf8");
        mysqli_query($this->link, "SET CHARACTER_SET_RESULTS= utf8");

        if (!(bool) mysqli_query($this->link, "USE " . $this->mysql_database)) $this->error_message = 'Database ' . $this->mysql_database . ' does not exist!';
    }


    public function insert_content($data)
    {
        $topic = $data['topic'];
        $text = $data['text'];
        $topic = htmlspecialchars($topic);
        $text = htmlspecialchars($text);
        $query_insert = "INSERT INTO board (name ,topic ,text ,date) VALUES ('{$_SESSION["loginMember"]}', ?, ?, NOW())";

        $stmt = $this->link->prepare($query_insert);
        $stmt->bind_param(
            "ss",
            $topic,
            $text,
        );
        $stmt->execute();
        if (mysqli_affected_rows($this->link) > 0) {
           return true;
        } else {
           return false;
        }
        $stmt->close();
        $this->link->close();
    }
    public function msg_show($condition, $limit)
    {
        $total_limit = "SELECT * FROM product WHERE $condition ORDER BY jointime ASC LIMIT $limit";
        $limit_record = $this->link->query($total_limit);

        while ($value = mysqli_fetch_array($limit_record)) {
            $arr[] = $value;
        }
        if (isset($arr)) {
            return $arr;
        } else {
            $nomsg = "尚無留言 請先去留言";
            echo $nomsg;
        }
    }
    public function msg_page($page_start, $condition)
    {
        $total = "SELECT * FROM product WHERE $condition ORDER BY jointime ASC";

        $total_record = $this->link->query($total);
        $totals = $total_record->num_rows;
        $total_pages = ceil($totals / $page_start);

        $this->link->close();

        $arr[0]  = $totals;
        $arr[1]  = $total_pages;
        return $arr;
    }
    public function p_select($id)
    {
        $data = [];
        $total_query = "SELECT * FROM product WHERE id=?";
        $stmt = $this->link->prepare($total_query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($data['id'], $data['name'], $data['content'], $data['price'],$data['num'],$data['jointime']);
        $stmt->fetch();
        $stmt->close();
        $this->link->close();
        return $data;
    }

    public function msg_update($data)
    {

        $topic = $data['topic'];
        $text = $data['text'];
        $id = $data['id'];
        $topic = htmlspecialchars($topic);
        $text = htmlspecialchars($text);
        $id = htmlspecialchars($id);
        $query_update = "UPDATE board SET topic=?,text=? WHERE id=?";
        $stmt = $this->link->prepare($query_update);
        $stmt->bind_param(
            "ssi",
            $topic,
            $text,
            $id,
        );
        $stmt->execute();
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        } else {
           return false;
        }
        $stmt->close();
    }

    public function msg_delete($post)
    {
        $sql_query = "DELETE FROM board WHERE id=?";
        $stmt = $this->link->prepare($sql_query);
        $stmt->bind_param("i", $post);
        $stmt->execute();
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
    public function search_show($search, $limit)
    {
        $sql_query = "SELECT * FROM board WHERE text LIKE '%$search%' ORDER BY date DESC LIMIT $limit";
        $search_record = $this->link->query($sql_query);
        while ($value = mysqli_fetch_array($search_record)) {
            $arr[] = $value;
        }
        if (isset($arr)) {
            return $arr;
        } else {
            return false;
        }
    }
    public function search_page($search, $page_start)
    {
        $sql_query = "SELECT * FROM board WHERE text LIKE '%$search%' ORDER BY date DESC";
        $total_record = $this->link->query($sql_query);
        $totals = $total_record->num_rows;
        $total_pages = ceil($totals / $page_start);
        $this->link->close();

        $arr[0]  = $totals;
        $arr[1]  = $total_pages;
        if (isset($arr)) {
            return $arr;
        } else {
            return false;
        }
    }
}
