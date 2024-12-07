<?php 
    session_start();
    include('connect.php');
    if(isset($_POST['remove'])){
        $doctor_id = $_POST['remove'];
        // Xử lý yêu cầu xóa dòng dữ liệu từ cơ sở dữ liệu ở đây
        $delete_query = "DELETE FROM doctor WHERE id = '$doctor_id'";
        $delete_result = mysqli_query($connect, $delete_query);
        if($delete_result){
        //    echo "Record deleted successfully!";
             header("Location: doctor.php");
             exit(); // Đảm bảo chương trình dừng sau khi chuyển hướng
        } else {
            echo "Error deleting record!";
        }
        // Sau khi xóa thành công, chuyển hướng người dùng đến trang hiện tại
       
        
    }
    $show = "";
    $hoten = "";
    $id = "";
    $chuyenkhoa = "";
    $gioitinh = "";
    $ngaysinh = "";
    $sdt = "";
    $diachi = "";
    $sername = "";
    if(isset($_POST['add'])){
        $id = $_POST['id'];
        $hoten = $_POST['hoten'];
        if($_POST['chuyenkhoa']=='ck1'){
            $chuyenkhoa = "Răng hàm mặt";
        }
        elseif($_POST['chuyenkhoa']=='ck2'){
            $chuyenkhoa = "Bệnh truyền nhiễm";
        }
        elseif($_POST['chuyenkhoa']=='ck3'){
            $chuyenkhoa = "Huyết học";
        }
        elseif($_POST['chuyenkhoa']=='ck4'){
            $chuyenkhoa = "Nội tiết";
        }
        elseif($_POST['chuyenkhoa']=='ck5'){
            $chuyenkhoa = "Tai mũi họng(ENT)";
        }
        elseif($_POST['chuyenkhoa']=='ck6'){
            $chuyenkhoa = "Thần kinh(Não & Dây thần kinh)";
        }
        elseif($_POST['chuyenkhoa']=='ck7'){
            $chuyenkhoa = "Tim mạch";
        }
        $ngaysinh = $_POST['ngaysinh'];
        $ngaysinh_formatted = date('Y-m-d', strtotime($ngaysinh));
        $current_date = date('Y-m-d');
        if(isset($_POST['gioitinh'])=="nam"){
            $gioitinh = "Nam";
        }
        elseif(isset($_POST['gioitinh'])=='nu'){
            $gioitinh = "Nữ";
        }
        $sdt = $_POST['sdt'];
        $diachi = $_POST['diachi'];
        $error = array();
        if (empty($hoten)) {
            $error['u'] = "Vui lòng nhập họ tên!";
        }
        elseif (empty($chuyenkhoa)) {
            $error['u'] = "Vui lòng chọn chuyên khoa!";
        }
        elseif (empty($ngaysinh)) {
            $error['u'] = "Vui lòng nhập ngày sinh!";
        }
        elseif (empty($gioitinh)) {
            $error['u'] = "Vui lòng chọn giới tính!";
        }
        elseif (empty($sdt)) {
            $error['u'] = "Vui lòng nhập số điện thoại!";
        }
        elseif (empty($diachi)) {
            $error['u'] = "Vui lòng nhập địa chỉ!";
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
        if (count($error) == 0) {
            if (empty($id)) {
                $q = "INSERT INTO doctor(hoten, chuyenkhoa, ngaysinh, gioitinh, sdt, diachi) VALUES ('$hoten', '$chuyenkhoa', '$ngaysinh', '$gioitinh', '$sdt', '$diachi')";
            } else {
                $q = "INSERT INTO doctor(id, hoten, chuyenkhoa, ngaysinh, gioitinh, sdt, diachi) VALUES ('$id', '$hoten', '$chuyenkhoa', '$ngaysinh', '$gioitinh', '$sdt', '$diachi')";
            }
            $result = mysqli_query($connect, $q);
            if ($result) {
             //   echo "Account added successfully!";
                header("location: doctor.php");
                exit();
            } else {
                echo "Error adding doctor!";
            }
        }
        if (isset($error['u'])) {
            $er = $error['u'];
            $show = "<h5 class='text-center alert alert-danger'>$er</h5>";
        }
    
    }

    // UPDATE
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $hoten = $_POST['hoten'];
        if($_POST['chuyenkhoa']=='ck1'){
            $chuyenkhoa = "Răng hàm mặt";
        }
        elseif($_POST['chuyenkhoa']=='ck2'){
            $chuyenkhoa = "Bệnh truyền nhiễm";
        }
        elseif($_POST['chuyenkhoa']=='ck3'){
            $chuyenkhoa = "Huyết học";
        }
        elseif($_POST['chuyenkhoa']=='ck4'){
            $chuyenkhoa = "Nội tiết";
        }
        elseif($_POST['chuyenkhoa']=='ck5'){
            $chuyenkhoa = "Tai mũi họng(ENT)";
        }
        elseif($_POST['chuyenkhoa']=='ck6'){
            $chuyenkhoa = "Thần kinh(Não & Dây thần kinh)";
        }
        elseif($_POST['chuyenkhoa']=='ck7'){
            $chuyenkhoa = "Tim mạch";
        }
        $ngaysinh = $_POST['ngaysinh'];
        $ngaysinh_formatted = date('Y-m-d', strtotime($ngaysinh));
        $current_date = date('Y-m-d');
        if(isset($_POST['gioitinh'])=='nam'){
            $gioitinh = "Nam";
        }
        elseif(isset($_POST['gioitinh'])=='nu'){
            $gioitinh = "Nữ";
        }
        $sdt = $_POST['sdt'];
        $diachi = $_POST['diachi'];
    $error = array();
    if (empty($id)) {
        $error['u'] = "Vui lòng nhập id!";
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
    if(count($error)==0){

        $u = "UPDATE doctor SET ";

        if (!empty($hoten)) {
          $u .= "hoten = '$hoten', ";
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
        
        if (!empty($diachi)) {
          $u .= "diachi = '$diachi', ";
        }
        
        $u = rtrim($u, ', '); // Xóa dấu ',' cuối cùng trong câu lệnh UPDATE
        
        $u .= " WHERE id = $id"; // Thêm điều kiện WHERE để chỉ cập nhật dòng có id tương ứng
    
    $up = mysqli_query($connect, $u);
    if($up){
        header("location: doctor.php");
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
    include('header2.php');
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="margin-left: -30px">
                <?php
                include('sidenav.php');
                ?>
            </div>
            <div class="col-md-10">
                <div class="col-md-13">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="text-center">Tất cả bác sĩ</h5>
                            <?php
                            $ad = $_SESSION['admin'];
                            
                            // SEARCH
                            if(isset($_POST['search'])){
                                $sername = $_POST['sername'];
                                $sr = "SELECT * FROM doctor WHERE hoten LIKE '%$sername%' OR CAST(id AS CHAR) LIKE '$sername'";
                                
                            }
                            else{
                                $sr = "SELECT * FROM doctor";   
                            }
                            $res = mysqli_query($connect, $sr);
                            $output = "
                                <table class='table table-bordered'>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ Tên</th>
                                        <th>Chuyên khoa</th>
                                        <th>Ngày sinh</th>
                                        <th>Giới tính</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th style='width:10%;'>Hoạt động</th>
                                    </tr>
                                ";
                            if (mysqli_num_rows($res) < 1) {
                                $output .= "<tr><td  colspan='8' class='text-center'>Không có bác sĩ</td></tr>";
                            }
                            while ($row = mysqli_fetch_array($res)) {
                                $id = $row['id'];
                                $hoten = $row['hoten'];
                                $chuyenkhoa = $row['chuyenkhoa'];
                                $ngaysinh = $row['ngaysinh'];
                                $gioitinh = $row['gioitinh'];
                                $sdt = $row['sdt'];
                                $diachi = $row['diachi'];
                                $output .= "
                                    <tr>
                                        <td>$id</td>
                                        <td>$hoten</td>
                                        <td>$chuyenkhoa</td>
                                        <td>$ngaysinh</td>
                                        <td>$gioitinh</td>
                                        <td>$sdt</td>
                                        <td>$diachi</td>
                                        <td>
                                        <form method='post'>
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
                        <div class="col-md-3">
                            <h5 class="text-center">Thông tin bác sĩ</h5>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div>
                                        <?php echo $show; ?>
                                    </div>
                                    <label>Tìm kiếm tên</label>
                                    <input type="text" name="sername" class="form-control" autocomplete="off">
                                    
                                </div>
                                <input type="submit" name="search" class="btn btn-success" value="Tìm kiếm">
                                <div class="from-group">
                                    <label>ID</label>
                                    <input type="text" name="id" class="form-control" placeholder="Chỉ nhập số">
                                    <label>Họ tên</label>
                                    <input type="text" name="hoten" class="form-control" style="margin-bottom: 0.6rem;">
                                    <label>Chuyên khoa: </label>
                                    <select name="chuyenkhoa">
                                    <option value="ck1" selected>Răng hàm mặt</option>
                                    <option value="ck2">Bệnh truyền nhiễm</option>
                                    <option value="ck3">Huyết học</option>
                                    <option value="ck4">Nội tiết</option>
                                    <option value="ck5">Tai mũi họng(ENT)</option>
                                    <option value="ck6">Thần kinh(Não & Dây thần kinh)</option>
                                    <option value="ck7">Tim mạch</option>
                                    </select>
                                    <label>Ngày sinh</label>
                                    <input type="date" name="ngaysinh" class="form-control" style="margin-bottom: 0.6rem;">
                                    <label>Giới tính: </label>
                                    <select name="gioitinh">
                                        <option value="nam" selected>Nam</option>
                                        <option value="nu">Nữ</option>
                                    </select> <br>
                                    <label>Số điện thoại</label>
                                    <input type="text" name="sdt" class="form-control">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="diachi" class="form-control">
                                </div><br>
                                <input type="submit" name="add" value="Thêm mới" class="btn btn-success">
                                <input type="submit" name="update" value="Cập nhật" class="btn btn-success">
                                <button name="clear" class="btn btn-success">Làm mới</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>