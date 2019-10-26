<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="Shortcut Icon" type="image/x-icon" href="https://i.ibb.co/GJKYQYH/favicon.png" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/auto.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css"
    integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
  <title>COMIC SHOP</title>
</head>
<body>
<div class="personal-profile" id="profile">
    <div class="nav">
        <div class="home">
            <a href="#home" class="anchor">漫畫王</a>
            <a href="#profile" class="anchor">最新</a>
            <a href="#resume" class="anchor">熱門</a>
            <a href="#skill" class="anchor">分類</a>&nbsp
            <input type="text" name="search" id="auto_autocomplete" class="search" placeholder="搜尋漫畫..">
            <button type="submit" class="btn btn-default btn-sm"><span
                    class="glyphicon glyphicon-search"></span> </button>
        </div>
        <div class="social">
            <div class="icon">
                <a href="https://www.facebook.com/" target="_blank" class="fb">
                    <i class="fab fa-facebook-square fa-lg"></i>
                </a>
                <a href="https://www.instagram.com/?hl=zh-tw" target="_blank" class="ig">
                    <i class="fab fa-instagram fa-lg"></i>
                </a>
                <a href="https://line.me/zh-hant/" target="_blank" class="line">
                    <i class="fab fa-line fa-lg"></i>
                </a>
            </div>
        </div>
        <div class="user">
            <a href="../views/join.html" target="_self" class="line">
                <i class="fas fa-user-circle fa-lg"></i>
            </a>
            會員管理
            <a href="memberjoin.php" target="_self" class="line">
                <i class="fas fa-shopping-cart fa-lg"></i>
            </a>
            購物車
            <span class="badge"></span>
        </div>
    </div>

</div>
<style type="text/css">
    input {
        padding: 3px;
        background: #fff;
        cursor: auto;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }
    
    .dropdown {
        display: block;
    }
    
    .user :hover .dropdown {
        color: red;
    }
    
    .search {
        height: 30px;
    }
    
    .social i {
        color: white;
        padding-right: 12px;
    }
    
    .social {
        padding-right: 8px;
        border-right: solid;
        border-color: white;
        float: right;
    }
    
    .nav {
        position: relative;
        padding: 0 20px 0 20px;
        width: 100%;
        line-height: 40px;
        border-bottom: 1px solid #ccc;
        overflow: auto;
        box-sizing: border-box;
        text-transform: uppercase;
        background: -webkit-linear-gradient(right, #FFAFBD, #ffc3a0);
        display: flex;
        justify-content: space-between;
    }
    
    .nav .home {
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        float: left;
    }
    
    .nav .home a:first-child {
        font-size: 24px;
    }
    
    .nav a {
        text-decoration: none;
        color: rgb(255, 255, 255);
        padding-left: 10px;
    }
    
    .nav li {
        display: inline-block;
        margin: 0 15px;
        font-size: 15px;
    }
    
    .nav li:hover {
        text-shadow: 5px 5px 10px #000;
    }
    
    .user {
        color: white;
        float: right;
    }
    .badge {
    display: inline-block;
    min-width: 10px;
    padding: 3px 7px;
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    background-color: #777;
    border-radius: 10px;
}
</style>