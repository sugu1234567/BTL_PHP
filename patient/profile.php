<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../connect.php");
$show = "";
$photo = isset($_SESSION['photo']) ? $_SESSION['photo'] : "";
$iduser = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : "";
// Hàm này giúp bảo vệ truy vấn SQL khỏi các cuộc tấn công SQL Injection bằng cách các ký tự đặc biệt trong chuỗi để tránh xảy ra lỗi cú pháp SQL.
$escapedId = mysqli_real_escape_string($connect, $iduser);
$qr = mysqli_query($connect, "SELECT * FROM user WHERE id = '$escapedId'");
$row = mysqli_fetch_array($qr);
$id = isset($row['id']) ? $row['id'] : "";
$hoten = isset($row['hoten']) ? $row['hoten'] : "";
$ngaysinh = isset($row['ngaysinh']) ? $row['ngaysinh'] : "";
$sdt = isset($row['sdt']) ? $row['sdt'] : "";
$gioitinh = isset($row['gioitinh']) ? $row['gioitinh'] : "";
$email = isset($row['email']) ? $row['email'] : "";

function uploadAvatar($file)
{
    $targetDir = "avatar/"; // Đường dẫn tới thư mục "avatar"
    $targetFile = $targetDir . basename($file['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Kiểm tra nếu file đã tồn tại
    // if (file_exists($targetFile)) {
    //     echo "File đã tồn tại.";
    //     $uploadOk = 0;
    // }

    // Kiểm tra kích thước file (giới hạn kích thước ảnh là 2MB)
    if ($file['size'] > 2 * 1024 * 1024) {
        echo "Kích thước file quá lớn. Vui lòng chọn file khác.";
        $uploadOk = 0;
    }

    // Kiểm tra định dạng file (chỉ cho phép các định dạng ảnh: jpg, jpeg, png, gif)
    if (
        $imageFileType != "jpg" && $imageFileType != "jpeg"
        && $imageFileType != "png" && $imageFileType != "gif"
    ) {
        echo "Chỉ cho phép upload các file ảnh có định dạng JPG, JPEG, PNG và GIF.";
        $uploadOk = 0;
    }

    // Kiểm tra nếu $uploadOk = 0, tức là có lỗi xảy ra
    if ($uploadOk == 0) {
        echo "Không thể upload file.";
        return false;
    } else {
        // Di chuyển file đã chọn vào thư mục "avatar"
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $targetFile; // Trả về đường dẫn tới file ảnh đã upload
        } else {
            echo "Có lỗi xảy ra khi upload file.";
            return false;
        }
    }
}

if (isset($_POST['save_img'])) {
    if (isset($_FILES['avatar'])) {
        $uploadedFile = $_FILES['avatar'];
        $uploadedFilePath = uploadAvatar($uploadedFile);
        if ($uploadedFilePath) {
            // Lưu đường dẫn ảnh vào session và cơ sở dữ liệu
            $_SESSION['photo'] = $uploadedFilePath;
            // Cập nhật đường dẫn ảnh lên cơ sở dữ liệu
            mysqli_query($connect, "UPDATE user SET photo = '$uploadedFilePath' WHERE id = '$id'");
            echo "Thêm/Sửa ảnh thành công.";
        }
    }
}

if (isset($_POST['update'])) {
    $hoten = $_POST['tenbenhnhan'];
    $sdt = $_POST['sdt'];
    $ngaysinh = $_POST['ns'];
    $gioitinh = $_POST['gt'];
    $email = $_POST['email'];

    $error = array();
    $ngaysinh_formatted = date('Y-m-d', strtotime($ngaysinh));
    $current_date = date('Y-m-d');
    // Kiểm tra ngày sinh có hợp lệ hay không
    $date_parts = explode('-', $ngaysinh_formatted);
    if (count($date_parts) !== 3 || !checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
        $error['u'] = "Vui lòng nhập ngày sinh hợp lệ!";
    }

    // Kiểm tra ngày sinh không nằm trong tương lai
    if ($ngaysinh_formatted > $current_date) {
        $error['u'] = "Vui lòng nhập ngày sinh hợp lệ!";
    }
    if (empty($hoten)) {
        $error['u'] = "Vui lòng nhập họ tên!";
    } 
    elseif ($gioitinh!= "Nam" && $gioitinh!= "Nữ" && $gioitinh!= "Khác") {
        $error['u'] = "Giới tính chỉ có: Nam/Nữ/Khác";
    } elseif (empty($sdt)) {
        $error['u'] = "Vui lòng nhập số điện thoại!";
    } elseif (empty($email)) {
        $error['u'] = "Vui lòng nhập email!";
    }

    if (count($error) == 0) {

        $u = "UPDATE user SET ";

        if (!empty($hoten)) {
            $u .= "hoten = '$hoten', ";
        }

        if (!empty($ngaysinh)) {
            $u .= "ngaysinh = '$ngaysinh', ";
        }

        if (!empty($sdt)) {
            $u .= "sdt = '$sdt', ";
        }

        if (!empty($gioitinh)) {
            $u .= "gioitinh = '$gioitinh', ";
        }

        if (!empty($email)) {
            $u .= "email = '$email', ";
        }

        $u = rtrim($u, ', '); // Xóa dấu ',' cuối cùng trong câu lệnh UPDATE

        $u .= " WHERE id = $id"; // Thêm điều kiện WHERE để chỉ cập nhật dòng có id tương ứng

        $up = mysqli_query($connect, $u);
        if ($up) {
            header("location: profile.php");
            exit();
        } else {
            $error['u'] = "Sửa thất bại!";
        }
    }
    if (isset($error['u'])) {
        $er = $error['u'];
        $show = "<h2 style='color:red; text-align:center;'>$er</h2>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            background-color: rgb(229, 255, 255);
        }

        .ttnguoidung {
            position: fixed;
            top: 100px;
            font-size: medium;
            left: 14rem;
        }

        .ttnguoidung h3 {
            font-size: medium;
            text-align: center;
        }


        table {
            margin: 0 auto;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
        }

        img {
            width: 200px;
        }

        .form-contro {
            width: 300px;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid;
            border-radius: 50px;
        }

        .btn {
            padding: 10px 20px;
            margin-right: 10px;
        }

        .suathongtin form {
            position: fixed;
            left: 90rem;
            top: 15rem;
            font-size: medium;
            flex: 1 1 45rem;
            border: var(--border);
            box-shadow: var(--box-shadow);
            padding: 2rem;
            border-radius: .5rem;

        }
    </style>
</head>

<body>
    <div>
        <?php
        include('hearderpatient3.php');
        ?>
    </div>
    <div>
        <div class="ttnguoidung">
            <h2 class="">
                Thông tin người dùng
            </h2>

            <script>
                function openFilePicker() {
                    document.getElementById('avatar-input').click();
                }

                function displayImage(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            document.getElementById('avatar-img').src = e.target.result;
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>

            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td rowspan="3"><img src="<?php echo $photo; ?>" alt="Có thể là ảnh của người dùng" style="width: 200px;" id="avatar-img"></td>
                        <td>Họ và tên: <?php echo $hoten; ?></td>
                    </tr>
                    <tr>
                        <td>Số điện Thoại: <?php echo $sdt; ?></td>
                    </tr>
                    <tr>
                        <td>Ngày sinh: <?php echo $ngaysinh; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="file" id="avatar-input" accept="image/*" style="display: none;" name="avatar" onchange="displayImage(this)">
                            <button class="btn" type="button" name="add_img" onclick="openFilePicker()">Thêm/Sửa</button>
                            <button type="submit" class="btn" name="save_img">Lưu</button>
                            <button type="submit" class="btn" name="cancel">Huỷ</button>
                        </td>
                        <td>Giới tính: <?php echo $gioitinh; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Email: <?php echo $email; ?></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="suathongtin">
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <?php
                echo $show;
                ?>
            </div>
            <table class="suathongtin">
                <tr>
                    <td><label>Họ Và Tên</label></td>
                    <td><input type="text" name="tenbenhnhan" class="form-contro" value="<?php echo isset($hoten) ? $hoten : ""; ?>"><br></td>
                </tr>
                <tr>
                    <td><label>Số điện thoai</label></td>
                    <td><input type="number" name="sdt" class="form-contro" value="<?php echo $sdt ?>"><br></td>
                </tr>
                <tr>
                    <td>
                        <label>Ngày sinh</label>
                    </td>
                    <td>
                        <input type="date" name="ns" class="form-contro" value="<?php echo isset($ngaysinh) ? $ngaysinh : ""; ?>"><br>
                    </td>
                </tr>
                <tr>
                    <td> <label>Giới tính</label></td>
                    <td><input type="text" name="gt" class="form-contro" value="<?php echo isset($gioitinh) ? $gioitinh : ""; ?>"><br></td>
                </tr>
                <tr>
                    <td>
                        <label>Email</label>
                    </td>
                    <td>
                        <input type="text" name="email" class="form-contro" value="<?php echo isset($email) ? $email : ""; ?>"><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="btn" type="submit" name="update" value="Cập nhật">Cập nhật</button>

                    </td>
                    <td><button class="btn" type="submit" name="clear" value="Làm mới">Làm mới</button></td>
                </tr>
            </table>
    </div><br>

    </form>
    </div>

</body>

</html>