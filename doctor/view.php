<?php
session_start();
include('../connect.php');
$show = "";
$id = isset($_GET['id'])?$_GET['id']:"";
$query = "SELECT * FROM patient WHERE id='$id'";
$res = mysqli_query($connect, $query);
$row = mysqli_fetch_array($res);
function uploadAvatar($file)
{
    $targetDir = "img_patient/"; // Đường dẫn tới thư mục "img"
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
            $_SESSION['img_patient'] = $uploadedFilePath;
            // Cập nhật đường dẫn ảnh lên cơ sở dữ liệu
            mysqli_query($connect, "UPDATE patient SET photo = '$uploadedFilePath' WHERE id = '$id'");
                        header("location: view.php?id=".$id."");

            echo "Thêm/Sửa ảnh thành công.";
        
        }
        
    }
}
    // UPDATE
    if(isset($_POST['update'])){
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
        $gioitinh = $_POST['gt'];
        $dc = $_POST['dc'];
        $email = $_POST['email'];
        $ndk = $_POST['ndk'];
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
        elseif ($gioitinh!= "Nam" && $gioitinh!= "Nữ" && $gioitinh!= "Khác") {
            $error['u'] = "Giới tính chỉ có: Nam/Nữ/Khác";
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
        if(count($error)==0){
    
            $u = "UPDATE patient SET ";
    
            if (!empty($ten)) {
              $u .= "tenbenhnhan = '$ten', ";
            }
            
            if (!empty($idbacsi)) {
                $u .= "idbacsi = '$idbacsi', ";
            }

            if (!empty($sdt)) {
              $u .= "sdt = '$sdt', ";
            }
            
            if (!empty($ngaysinh)) {
              $u .= "ngaysinh = '$ngaysinh', ";
            }
            
            if (!empty($gioitinh)) {
              $u .= "gioitinh = '$gioitinh', ";
            }
            
            if (!empty($dc)) {
              $u .= "diachi = '$dc', ";
            }
            
            if (!empty($email)) {
              $u .= "email = '$email', ";
            }
            
            if (!empty($ndk)) {
                $u .= "ngaydangki = '$ndk', ";
            }

            $u = rtrim($u, ', '); // Xóa dấu ',' cuối cùng trong câu lệnh UPDATE
            
            $u .= " WHERE id = $id"; // Thêm điều kiện WHERE để chỉ cập nhật dòng có id tương ứng
        
        $up = mysqli_query($connect, $u);
        if($up){
            header("location: view.php?id=".$id."");
            exit();
        }
        else{
            echo "Sửa thất bại!";
        }
        }
        if (isset($error['u'])) {
            $er = $error['u'];
            $show = "<h5 class='text-center alert alert-danger'>$er</h5>";
        }
    }

    //DELETE
    if(isset($_POST['delete'])){
        // Xử lý yêu cầu xóa dòng dữ liệu từ cơ sở dữ liệu ở đây
        $delete_query = "DELETE FROM patient WHERE id = '$id'";
        $delete_result = mysqli_query($connect, $delete_query);
        if($delete_result){
        //    echo "Record deleted successfully!";
             header("Location: patient.php");
             exit(); // Đảm bảo chương trình dừng sau khi chuyển hướng
        } else {
            echo "Error deleting record!";
        }
        // Sau khi xóa thành công, chuyển hướng người dùng đến trang hiện tại
       
        
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info-patient</title>
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
                                    Thông tin bệnh nhân
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
                                <table cellpadding = "20px">
                                       
                                    <tr>
                                        <td rowspan="4"><img src="<?php echo $row['photo']; ?>" alt="Có thể là ảnh của bệnh nhân" style="width: 200px;" id="avatar-img"></td>
                                        
                                        <td >ID Bệnh nhân: <?php echo $row['id'] ; ?> </td>
                                    </tr>
                                    <tr>
                                        <td>Tên bệnh nhân: <?php echo $row['tenbenhnhan'] ; ?></td>
                                    </tr>
                                    <tr>
                                        <td>ID bác sĩ: <?php echo $row['idbacsi'] ; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Số điện Thoại: <?php echo $row['sdt'] ; ?></td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <input type="file" id="avatar-input" accept="image/*" style="display: none;" name="avatar" onchange="displayImage(this)">
                                                <button  type="button" name="add_img" onclick="openFilePicker()">Thêm/Sửa</button>
                                                <button type="submit"  name="save_img">Lưu</button>
                                                <button type="submit"  name="cancel">Huỷ</button>
                                    </td>
                                        <td>Email: <?php echo $row['email'] ; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ngày sinh: <?php echo $row['ngaysinh'] ; ?></td>
                                        <td>Địa chỉ: <?php echo $row['diachi'] ; ?></td>
                                    </tr>
                                    <tr rowspan="2">
                                        <td>Giới tính: <?php echo $row['gioitinh'] ; ?></td>
                                        <td>Ngày đăng kí: <?php echo $row['ngaydangki'] ; ?></td>
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
                                        <label>ID Bệnh nhân</label>
                                        <input type="text" name="idbenhnhan" class="form-control" value="<?php echo $id ?>" readonly>
                                        <label>Tên bênh nhân</label>
                                        <input type="text" name="tenbenhnhan" class="form-control" value="<?php echo isset($row['tenbenhnhan'])? $row['tenbenhnhan']:""; ?>">
                                        <label>ID bác sĩ</label>
                                        <input type="text" name="idbacsi" class="form-control" value="<?php echo isset($row['idbacsi'])? $row['idbacsi']:""; ?>">                    
                                        <label>Só điện thoai</label>
                                        <input type="number" name="sdt" class="form-control" value="<?php echo isset($row['sdt'])? $row['sdt']:""; ?>">
                                        <label>Ngày sinh</label>
                                        <input type="date" name="ns" class="form-control" value="<?php echo isset($row['ngaysinh'])? $row['ngaysinh']:""; ?>">
                                        <label>Giới tính</label>
                                        <input type="text" name="gt" class="form-control" value="<?php echo isset($row['gioitinh'])? $row['gioitinh']:""; ?>">
                                        <label>Địa chỉ</label>
                                        <input type="text" name="dc" class="form-control" value="<?php echo isset($row['diachi'])? $row['diachi']:""; ?>">
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control" value="<?php echo isset($row['email'])? $row['email']:""; ?>"> 
                                        <label>Ngày đăng kí</label>
                                        <input type="date" name="ndk" class="form-control" value="<?php echo isset($row['ngaydangki'])? $row['ngaydangki']:""; ?>">

                                    </div><br>
                                    <input type="submit" name="update" value="Cập nhật" class="btn btn-success">
                                    <input type="submit" name="delete" value="Xóa Bỏ" class="btn btn-danger">
                                    <button class="btn btn-danger"> <a href="patient.php" style="text-decoration: none; color: white;">Hủy</a></button>
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