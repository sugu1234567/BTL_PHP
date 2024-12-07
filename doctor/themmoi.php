<?php
    include_once("../connect.php");
    $show = "";
    
    if(isset($_POST['add'])){
        $id = $_POST['idbenhnhan'];
        $ten = $_POST['tenbenhnhan'];
        $idbacsi = $_POST['idbacsi'];
        $sdt = $_POST['sdt'];
        $ngaysinh = $_POST['ns'];
        $ngaysinh_formatted = date('Y-m-d', strtotime($ngaysinh));
        $current_date = date('Y-m-d');
        $error = array();

        $res = mysqli_query($connect, "SELECT id FROM doctor WHERE id = '$idbacsi'");
        
        if(mysqli_num_rows($res)==0){
            $error['u'] = "ID bác sĩ không tồn tại!";
        }
        // Kiểm tra ngày sinh có hợp lệ hay không
        $date_parts = explode('-', $ngaysinh_formatted);
        if (count($date_parts) !== 3 || !checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
            $error['u'] = "Vui lòng nhập ngày sinh hợp lệ!";
        }

        // Kiểm tra ngày sinh không nằm trong tương lai
        if ($ngaysinh_formatted > $current_date) {
            $error['u'] = "Vui lòng nhập ngày sinh hợp lệ!";
        }
        if(isset($_POST['gioitinh'])=="nam"){
            $gioitinh = "Nam";
        }
        elseif(isset($_POST['gioitinh'])=='nu'){
            $gioitinh = "Nữ";
        }
        elseif(isset($_POST['gioitinh'])=='other'){
            $gioitinh = "Khác";
        }
        
        $dc = $_POST['dc'];
        $email = $_POST['email'];
        $ndk = $_POST['ngaydangki'];
        if (empty($ten)) {
            $error['u'] = "Vui lòng nhập họ tên!";
        }
        elseif (empty($idbacsi)) {
            $error['u'] = "Vui lòng nhập id bác sĩ!";
        }
        elseif (empty($sdt)) {
            $error['u'] = "Vui lòng nhập số điện thoại!";
        }
        elseif (empty($ngaysinh)) {
            $error['u'] = "Vui lòng nhập ngày sinh!";
        }
        elseif (empty($gioitinh)) {
            $error['u'] = "Vui lòng chọn giới tính!";
        }elseif (empty($dc)) {
            $error['u'] = "Vui lòng nhập địa chỉ!";
        }
        elseif (empty($email)) {
            $error['u'] = "Vui lòng nhập email!";
        }
        elseif (empty($ndk)) {
            $error['u'] = "Vui lòng nhập ngày đăng kí!";
        }
        $ngaysinh_formatted = date('Y-m-d', strtotime($ndk));
        // Kiểm tra ngày sinh có hợp lệ hay không
        $date_parts = explode('-', $ngaysinh_formatted);
        if (count($date_parts) !== 3 || !checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
            $error['u'] = "Vui lòng nhập ngày đăng kí hợp lệ!";
        }

        // Kiểm tra ngày sinh không nằm trong tương lai
        if ($ngaysinh_formatted > $current_date) {
            $error['u'] = "Vui lòng nhập ngày đăng kí hợp lệ!";
        }
        if (count($error) == 0) {
            if (empty($id)) {
                $q = "INSERT INTO patient(tenbenhnhan, idbacsi, sdt, ngaysinh, gioitinh, diachi, email, ngaydangki) VALUES ('$ten', '$idbacsi', '$sdt', '$ngaysinh', '$gioitinh', '$dc', '$email', '$ndk')";
            } else {
                $q = "INSERT INTO patient(id, tenbenhnhan, idbacsi, sdt, ngaysinh, gioitinh, diachi, email, ngaydangki) VALUES ('$id', '$ten', '$idbacsi', '$sdt', '$ngaysinh', '$gioitinh', '$dc', '$email', '$ndk')";
            }
            $result = mysqli_query($connect, $q);
            if ($result) {
             //   echo "Account added successfully!";

                echo "<script>";
                echo "window.opener.location.reload();"; // Làm mới trang patient.php
                echo "window.close();"; // Đóng cửa sổ trang themmoi_benhnhan.php
                echo "</script>";
            } else {
                echo "Lỗi thêm bệnh nhân!";
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
    <title>Them moi benh nhan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <div>
                <?php echo $show; ?>
            </div>
            <label>ID bệnh nhân</label>
            <input type="text" name="idbenhnhan" class="form-control">
        </div>
        <div class="form-group">
            <label>Tên bệnh nhân</label>
            <input type="text" name="tenbenhnhan" class="form-control">
        </div>
        <div class="form-group">
            <label>ID bác sĩ</label>
            <input type="text" name="idbacsi" class="form-control">
        </div>
        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="sdt" class="form-control">
        </div>
        <div class="form-group">
            <label>Ngày sinh</label>
            <input type="date" name="ns" class="form-control">
        </div>
        <div class="form-group">
            <label>Giới tính</label>
            <select name="gioitinh">
                <option value="nam" selected>Nam</option>
                <option value="nu">Nữ</option>
                <option value="other">Khác</option>
            </select> <br>
        </div>
        <div class="form-group">
            <label>Địa chỉ</label>
            <input type="text" name="dc" class="form-control">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label>Ngày đăng kí</label>
            <input type="date" name="ngaydangki" class="form-control">
        </div>
        <input type="submit" name="add" value="Thêm Mới" class="btn btn-success">
    </form>

    <script>
    function closeWindowAndRefreshParent() {
        window.opener.location.reload(); // Làm mới trang patient
        window.close(); // Đóng cửa sổ trang themmoi_benhnhan
    }
    </script>
</body>
</html>