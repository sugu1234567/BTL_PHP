<?php
    session_start();
    $photo = isset($_SESSION['photo'])? $_SESSION['photo'] : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header class="header">
        <a href="#" class="logo"> <i class="fas fa-heartbeat"></i> <strong>Healthy</strong>service </a>

        <nav class="navbar">
            <a href="#home">Trang chủ</a>
            <a href="#about">về chúng tôi</a>
            <a href="#services">Dịch vụ</a>
            <a href="#doctors">Bác sĩ</a>
            <a href="#appointment">Đặt lịch hẹn</a>
            <a href="#review">Đánh giá</a>
            <a href="#blogs">Bài viết</a>

        </nav>


        <div class="action">
    <div class="profile" onclick="menuToggle();">
        <img src="<?php echo $photo; ?>" alt="">
    </div>

    <div class="menu" id="profileMenu">
        <ul>
            <li><a href="profile.php">Tài khoản của tôi</a></li>
            <li><a href="appointmentpatient.php">Xem lịch hẹn</a></li>
            <li><a href="logoutpatient.php">Đăng xuất</a></li>
        </ul>
    </div>
</div>

<script>
    function menuToggle() {
        var menu = document.getElementById("profileMenu");
        menu.classList.toggle("active");
    }
</script>
    </header>
</body>
</html>