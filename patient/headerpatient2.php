<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .header .login .dangnhap:hover {
            color: #fff;
            text-decoration: underline;
            
        }
        .header .login .abc:hover {
            color: #fff;
            text-decoration: underline;
        }
        .login a{
            color: black;  
           
        }
    </style>
</head>
<body>
<header class="header">
        <a href="../index.php" class="logo"> <i class="fas fa-heartbeat"></i> <strong>Healthy</strong>service </a>

        <nav class="navbar" style="right: 225px; position: fixed;">
            <a href="#home">Trang chủ</a>
            <a href="#about">về chúng tôi</a>
            <a href="#services">Dịch vụ</a>
            <a href="#doctors">Bác sĩ</a>
            <a href="#appointment">Đặt lịch hẹn</a>
            <a href="#review">Đánh giá</a>
            <a href="#blogs">Bài viết</a>
        </nav>
        <div class="login" style="font-size: 1.65rem; position: fixed;  right: 20px; top: 25px;">
            <a class="dangnhap" href="../login.php">Đăng nhập</a>   |     
            <a  class="abc" href="../signup.php">Đăng kí</a>
        </div>  
    </header>
</body>
</html>