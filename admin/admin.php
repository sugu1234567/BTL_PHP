<?php
session_start();
include('connect.php');

if(isset($_POST['remove'])){
    $admin_id = $_POST['remove'];
    // Xử lý yêu cầu xóa dòng dữ liệu từ cơ sở dữ liệu ở đây
    $delete_query = "DELETE FROM Login WHERE id = '$admin_id'";
    $delete_result = mysqli_query($connect, $delete_query);
    if($delete_result){
    //    echo "Record deleted successfully!";
         header("Location: admin.php");
         exit(); // Đảm bảo chương trình dừng sau khi chuyển hướng
    } else {
        echo "Error deleting record!";
    }
    // Sau khi xóa thành công, chuyển hướng người dùng đến trang hiện tại
   
    
}

$show = "";
$count_query = "SELECT COUNT(id) AS total FROM Login";
$count_result = mysqli_query($connect, $count_query);
$count_row = mysqli_fetch_array($count_result);
$i = $count_row['total'];
if (isset($_POST['add'])) {
    $id = $i+1;
    $username = $_POST['uname'];
    $password = $_POST['pass'];
    if($_POST['positions']=='admin'){
        $position = "Admin";
    }
    elseif($_POST['positions']=='staff'){
        $position = "Nhân viên";
    }
    elseif($_POST['positions']=='user'){
        $position = "Người dùng";
    }
    
    $error = array();
    if (empty($username)) {
        $error['u'] = "Vui lòng nhập tài khoản!";
    } elseif (empty($password)) {
        $error['u'] = "Vui lòng nhập mật khẩu!";
    }
    if (count($error) == 0) {
        $q = "INSERT INTO Login(username, password, id, chucvu) VALUES ('$username', '$password', '$id', '$position')";
        $result = mysqli_query($connect, $q);
        if ($result) {
         //   echo "Account added successfully!";
            header("location: admin.php");
            exit();
        } else {
            echo "Error adding account!";
        }
    }
    if (isset($error['u'])) {
        $er = $error['u'];
        $show = "<h5 class='text-center alert alert-danger'>$er</h5>";
    }
}
// UPDATE
if(isset($_POST['update'])){
    $username = $_POST['uname'];
    $password = $_POST['pass'];
    $error = array();
    if (empty($username)) {
        $error['u'] = "Vui lòng nhập tài khoản!";
    }
    if(count($error)==0){
    if($_POST['positions']=='admin'){
        $position = "Admin";
    }
    elseif($_POST['positions']=='staff'){
        $position = "Nhân viên";
    }
    elseif($_POST['positions']=='user'){
        $position = "Người dùng";
    }
    if(empty($password)){
        $u = "update Login set chucvu='$position' Where username='$username'";
    }
    else $u = "update Login set password = '$password', chucvu='$position' Where username='$username'";
    
    $up = mysqli_query($connect, $u);
    if($up){
        header("location: admin.php");
        exit();
    }
    else{
        echo "Thêm thất bại!";
    }
    }
    if (isset($error['u'])) {
        $er = $error['u'];
        $show = "<h5 class='text-center alert alert-danger'>$er</h5>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="margin-left: -30px">
                <?php
                include('sidenav.php');
                include('connect.php');
                ?>
            </div>
            
            <div class="col-md-10">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-center">Tất cả tài khoản</h5>
                            <?php
                            $ad = $_SESSION['admin'];
                            $query = "SELECT * FROM Login WHERE username != '$ad'";
                            $res = mysqli_query($connect, $query);
                            $output = "
                                <table class='table table-bordered'>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tài khoản</th>
                                        <th>Mật khẩu</th>
                                        <th>Chức vụ</th>
                                        <th style='width:10%;'>Hoạt động</th>
                                    </tr>
                                ";
                            if (mysqli_num_rows($res) < 1) {
                                $output .= "<tr><td  colspan='5' class='text-center'>No New Admin</td></tr>";
                            }
                            while ($row = mysqli_fetch_array($res)) {
                                $id = $row['id'];
                                $username = $row['username'];
                                $password = $row['password'];
                                $chucvu = $row['chucvu'];   
                                $output .= "
                                    <tr>
                                        <td>$id</td>
                                        <td>$username</td>
                                        <td>$password</td>
                                        <td>$chucvu</td>
                                        <td>
                                        <form method='POST' action=''>
                                            <button class='btn btn-danger remove' name='remove' value='$id'>Xóa</button>
                                        </form>
                                        </td>
                                    </tr>
                                ";
                            }
                            $output .= "
                                </table>
                            ";
                            echo $output;
                            ?>
                            
                        </div>
                        <div class="col-md-6">
                            
                            <h5 class="text-center">Thêm tài khoản</h5>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div>
                                        <?php echo $show; ?>
                                    </div>
                                    <label>Tài khoản</label>
                                    <input type="text" name="uname" class="form-control" autocomplete="off">
                                </div>
                                <div class="from-group" style="margin-bottom: 1rem;">
                                    <label>Mật khẩu</label>
                                    <input type="password" name="pass" class="form-control">
                                </div>
                                <div class="from-group">
                                    <label>Chức vụ</label>
                                    <select name="positions">
                                    <option value="admin" selected>Admin</option>
                                    <option value="staff">Nhân Viên</option>
                                    <option value="user">Người dùng</option>
                                    </select>
                                </div><br>
                                <input type="submit" name="add" value="Thêm tài khoản" class="btn btn-success">
                                <input type="submit" name="update" value="Sửa tài khoản" class="btn btn-success">
                                <input type="button" name="clear" value="Làm mới" class="btn btn-success">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>