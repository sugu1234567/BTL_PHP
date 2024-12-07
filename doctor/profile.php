<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../connect.php");
$show = "";
$mess = isset($_GET['mess'])?$_GET['mess']:"";

$photo = isset($_SESSION['img']) ? $_SESSION['img'] : "";
$idstaff = isset($_SESSION['idstaff']) ? $_SESSION['idstaff'] : "";
// Hàm này giúp bảo vệ truy vấn SQL khỏi các cuộc tấn công SQL Injection bằng cách các ký tự đặc biệt trong chuỗi để tránh xảy ra lỗi cú pháp SQL.
$escapedId = mysqli_real_escape_string($connect, $idstaff);
$qr = mysqli_query($connect, "SELECT * FROM doctor WHERE id = '$escapedId'");
$row = mysqli_fetch_array($qr);
$id = isset($row['id']) ? $row['id'] : "";
$hoten = isset($row['hoten']) ? $row['hoten'] : "";
$ngaysinh = isset($row['ngaysinh']) ? $row['ngaysinh'] : "";
$sdt = isset($row['sdt']) ? $row['sdt'] : "";
$gioitinh = isset($row['gioitinh']) ? $row['gioitinh'] : "";
$chuyenkhoa = isset($row['chuyenkhoa']) ? $row['chuyenkhoa'] : "";
$diachi = isset($row['diachi']) ? $row['diachi'] : "";

function uploadAvatar($file)
{
    $targetDir = "avatar_doctor/"; // Đường dẫn tới thư mục "avatar"
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
            $_SESSION['img'] = $uploadedFilePath;
            // Cập nhật đường dẫn ảnh lên cơ sở dữ liệu
            mysqli_query($connect, "UPDATE doctor SET photo = '$uploadedFilePath' WHERE id = '$id'");
            header("location: profile.php");
            echo "Thêm/Sửa ảnh thành công.";
        
        }
        
    }
}


// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['idbacsi'];
    $ten = $_POST['tenbacsi'];
    $sdt = $_POST['sdt'];
    $ngaysinh = $_POST['ns'];
    $ngaysinh_formatted = date('Y-m-d', strtotime($ngaysinh));
    $current_date = date('Y-m-d');
    $gioitinh = $_POST['gt'];
    $dc = $_POST['dc'];
    $error = array();
    $chuyenkhoa = $_POST['chuyenkhoa'];
    if (empty($ten)) {
        $error['u'] = "Vui lòng nhập họ tên!";
    } elseif (empty($sdt)) {
        $error['u'] = "Vui lòng nhập số điện thoại!";
    } elseif (empty($ngaysinh)) {
        $error['u'] = "Vui lòng nhập ngày sinh!";
    } elseif ($gioitinh != "Nam" && $gioitinh != "Nữ" && $gioitinh != "Khác") {
        $error['u'] = "Giới tính chỉ có: Nam/Nữ/Khác";
    } elseif (empty($dc)) {
        $error['u'] = "Vui lòng nhập địa chỉ!";
    } elseif (empty($chuyenkhoa)) {
        $error['u'] = "Vui lòng nhập chuyên khoa!";
    }
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

        $u = "UPDATE doctor SET ";

        if (!empty($ten)) {
          $u .= "hoten = '$ten', ";
        }
        
        if (!empty($chuyenkhoa)) {
          $u .= "chuyenkhoa = '$chuyenkhoa', ";
        }
        
        if (!empty($ngaysinh)) {
          $u .= "ngaysinh = '$ngaysinh', ";
        }
        
        if (!empty($gioitinh)) {
          $u .= "gioitinh = '$gioitinh', ";
        }
        
        if (!empty($sdt)) {
          $u .= "sdt = '$sdt', ";
        }
        
        if (!empty($dc)) {
          $u .= "diachi = '$dc', ";
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
        $show = "<h5 class='text-center alert alert-danger'>$er</h5>";
    }
}

    //CANCEL
    if(isset($_POST['cancel'])){
        header("location: profile.php?mess=".""."");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile-doctor</title>
</head>

<body>
    <?php
    include('headerdoctor.php');
    ?>
    <div class="container-fluid">
        <div class=" col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php
                    include('sidenavdoctor.php');
                    ?>
                </div>
                <div class="col-md-10">
                    <div div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="text-center my-3">
                                    Thông tin của tôi
                                </h5>
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
                                    <table cellpadding="20px"> 

                                        <tr>
                                            <td rowspan="4">
                                                <img src="<?php echo $photo ?>" alt="Có thể là ảnh của bác sĩ" style="width: 200px;" id="avatar-img">
                                            </td>
                                            <td>ID Bác sĩ: <?php echo $id; ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Họ và Tên: <?php echo $hoten; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Chuyên khoa: <?php echo $chuyenkhoa; ?></td>
                                        </tr>
                                        <tr>

                                            <td>Ngày sinh: <?php echo $ngaysinh; ?></td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" id="avatar-input" accept="image/*" style="display: none;" name="avatar" onchange="displayImage(this)">
                                                <button  type="button" name="add_img" onclick="openFilePicker()">Thêm/Sửa</button>
                                                <button type="submit"  name="save_img">Lưu</button>
                                                <button type="submit"  name="cancel">Huỷ</button>
                                              
                                            </td>
                                            <td>Giới tính: <?php echo $gioitinh; ?></td>
                                        </tr>
                                        <tr rowspan="2">
                                            <td></td>
                                            <td>Địa chỉ: <?php echo $diachi; ?></td>
                                        </tr>
                                        <tr rowspan="2">
                                            <td></td>
                                            <td>Số điện thoại: <?php echo $sdt; ?></td>
                                        </tr>


                                    </table>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="from-group">
                                        <div>
                                            <?php echo $show; ?>
                                        </div>
                                        <label>ID bác sĩ</label>
                                        <input type="text" name="idbacsi" class="form-control" value="<?php echo isset($id) ? $id : ""; ?>" readonly>
                                        <label>Họ và tên</label>
                                        <input type="text" name="tenbacsi" class="form-control" value="<?php echo isset($hoten) ? $hoten : ""; ?>">
                                        <label>Chuyên khoa</label>
                                        <input type="text" name="chuyenkhoa" class="form-control" value="<?php echo isset($chuyenkhoa) ? $chuyenkhoa : ""; ?>" readonly>
                                        <label>Ngày sinh</label>
                                        <input type="date" name="ns" class="form-control" value="<?php echo isset($ngaysinh) ? $ngaysinh : ""; ?>">
                                        <label>Giới tính</label>
                                        <input type="text" name="gt" class="form-control" value="<?php echo isset($gioitinh) ? $gioitinh : ""; ?>">
                                        <label>Địa chỉ</label>
                                        <input type="text" name="dc" class="form-control" value="<?php echo isset($diachi) ? $diachi : ""; ?>">
                                        <label>Số điện thoại</label>
                                        <input type="number" name="sdt" class="form-control" value="<?php echo isset($sdt) ? $sdt : ""; ?>">

                                    </div><br>
                                    <input type="submit" name="update" value="Cập nhật" class="btn btn-success">
                                    <button class="btn btn-danger"> <a href="profile.php" style="text-decoration: none; color: white;">Hủy</a></button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>