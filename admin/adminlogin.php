<?php
session_start();
include('connect.php');
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $error = array();
    if (empty($username)) {
        $error['admin'] = 'Vui lòng nhập tài khoản!';
    } else if (empty($password)) {
        $error['admin'] = 'Vui lòng nhập mật khẩu!';
    }
    if (count($error) == 0) {
        $query = "SELECT * FROM Login WHERE username = '$username' AND password = '$password' AND chucvu='Admin'";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['admin'] = $username;
            header("location: indexadmin.php");
        } else {
            
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>
</head>

<body background="img/back.jpg">
    <?php
    include("header.php");
    ?>
    <div style="margin-top: 20px;"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 jumbotron">
                <form action="" method="post" class="my-2">
                    <div >
                        <?php
                        if (isset($error['admin'])) {
                            $sh = $error['admin'];
                            $show = "<h4 class='alert alert-danger'>$sh</h4>";
                        } else {
                            $show = "";
                        }

                        echo $show;
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="">Tài khoản</label>
                        <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Nhập tài khoản">
                    </div>
                    <div class="form-group">
                        <label for="">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                    </div>
                    <input type="submit" name="login" class="btn btn-success" value="Đăng nhập">
                </form>
            </div>
        </div>
    </div>
</body>

</html>