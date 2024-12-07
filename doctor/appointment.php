<?php
    session_start();
    include('../connect.php');  
    $show = "";
    $id = "";   
    if(isset($_POST['remove'])){
        $appo_id = $_POST['remove'];
        // Xử lý yêu cầu xóa dòng dữ liệu từ cơ sở dữ liệu ở đây
        $delete_query = "DELETE FROM appointment WHERE id = '$appo_id'";
        $delete_result = mysqli_query($connect, $delete_query);
        if($delete_result){
        //    echo "Record deleted successfully!";
             header("Location: appointment.php");
             exit(); // Đảm bảo chương trình dừng sau khi chuyển hướng
        } else {
            echo "Error deleting record!";
        }
        // Sau khi xóa thành công, chuyển hướng người dùng đến trang hiện tại
           
    }

    //ADD
    if(isset($_POST['add'])){
        $id = $_POST['idlichhen'];
        $hoten = $_POST['hoten'];
        $ngaysinh = $_POST['ngaysinh'];
        $ngaysinh_formatted = date('Y-m-d', strtotime($ngaysinh));
        $current_date = date('Y-m-d');
        $error = array();

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
        $diachi = $_POST['diachi'];
        $sdt = $_POST['sdt'];
        $trieuchung = $_POST['trieuchung'];
        if(isset($_POST['dichvuyte'])=="dv1"){
            $dichvuyte = "Khám tổng quát";
        }
        elseif(isset($_POST['dichvuyte'])=='dv2'){
            $dichvuyte = "Xét Nghiệm dị ứng";
        }
        elseif(isset($_POST['dichvuyte'])=='dv3'){
            $dichvuyte = "Xét nghiệm gan";
        }
        $ngaykham = $_POST['ngaykham'];
        if (empty($hoten)) {
            $error['u'] = "Vui lòng nhập họ tên!";
        }
        elseif (empty($ngaysinh)) {
            $error['u'] = "Vui lòng nhập ngày sinh!";
        }
        elseif (empty($diachi)) {
            $error['u'] = "Vui lòng nhập địa chỉ!";
        }
        elseif (empty($sdt)) {
            $error['u'] = "Vui lòng nhập số điện thoại!";
        }
        elseif (empty($trieuchung)) {
            $error['u'] = "Vui lòng nhập triệu chứng!";
        }
        elseif (empty($dichvuyte)) {
            $error['u'] = "Vui lòng chọn dịch vụ y tế!";
        }
        elseif (empty($ngaykham)) {
            $error['u'] = "Vui lòng nhập ngày khám!";
        }
        $ngaysinh_formatted = date('Y-m-d', strtotime($ngaykham));
        // Kiểm tra ngày sinh có hợp lệ hay không
        $date_parts = explode('-', $ngaysinh_formatted);
        if (count($date_parts) !== 3 || !checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
            $error['u'] = "Vui lòng nhập ngày khám hợp lệ!";
        }

        // Kiểm tra ngày sinh không nằm trong tương lai
        if ($ngaysinh_formatted > $current_date) {
            $error['u'] = "Vui lòng nhập ngày khám hợp lệ!";
        }
        if (count($error) == 0) {
            if (empty($id)) {
                $q = "INSERT INTO appointment(hotenbenhnhan, ngaysinh, gioitinh, diachi, sdt, trieuchung, dichvuyte, ngayhenkham) VALUES ('$hoten', '$ngaysinh', '$gioitinh', '$diachi', '$sdt', '$trieuchung', '$dichvuyte', '$ngaykham')";
            } else {
                $q = "INSERT INTO appointment(id, hotenbenhnhan, ngaysinh, gioitinh, diachi, sdt, trieuchung, dichvuyte, ngayhenkham) VALUES ('$id', '$hoten', '$ngaysinh', '$gioitinh', '$diachi', '$sdt', '$trieuchung', '$dichvuyte', '$ngaykham')";
            }
            $result = mysqli_query($connect, $q);
            if ($result) {
             //   echo "Account added successfully!";
                header("location: appointment.php");
                exit();
            } else {
                echo "Lỗi thêm lịch hẹn!";
            }
        }
        if (isset($error['u'])) {
            $er = $error['u'];
            $show = "<h5 class='text-center alert alert-danger'>$er</h5>";
        }
    
    }

    // UPDATE
    if(isset($_POST['update'])){
        $id = $_POST['idlichhen'];
        $hoten = $_POST['hoten'];
        $ngaysinh = $_POST['ngaysinh'];
        $ngaysinh_formatted = date('Y-m-d', strtotime($ngaysinh));
        $current_date = date('Y-m-d');
        $error = array();

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
        $diachi = $_POST['diachi'];
        $sdt = $_POST['sdt'];
        $trieuchung = $_POST['trieuchung'];
        if(isset($_POST['dichvuyte'])=="dv1"){
            $dichvuyte = "Khám tổng quát";
        }
        elseif(isset($_POST['dichvuyte'])=='dv2'){
            $dichvuyte = "Xét Nghiệm dị ứng";
        }
        elseif(isset($_POST['dichvuyte'])=='dv3'){
            $dichvuyte = "Xét nghiệm gan";
        }
        $ngaykham = $_POST['ngaykham'];
        if (empty($hoten)) {
            $error['u'] = "Vui lòng nhập họ tên!";
        }
        elseif (empty($ngaysinh)) {
            $error['u'] = "Vui lòng nhập ngày sinh!";
        }
        elseif (empty($diachi)) {
            $error['u'] = "Vui lòng nhập địa chỉ!";
        }
        elseif (empty($sdt)) {
            $error['u'] = "Vui lòng nhập số điện thoại!";
        }
        elseif (empty($trieuchung)) {
            $error['u'] = "Vui lòng nhập triệu chứng!";
        }
        elseif (empty($dichvuyte)) {
            $error['u'] = "Vui lòng chọn dịch vụ y tế!";
        }
        elseif (empty($ngaykham)) {
            $error['u'] = "Vui lòng nhập ngày khám!";
        }
        $ngaysinh_formatted = date('Y-m-d', strtotime($ngaykham));
        // Kiểm tra ngày sinh có hợp lệ hay không
        $date_parts = explode('-', $ngaysinh_formatted);
        if (count($date_parts) !== 3 || !checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
            $error['u'] = "Vui lòng nhập ngày khám hợp lệ!";
        }

        // Kiểm tra ngày sinh không nằm trong tương lai
        if ($ngaysinh_formatted > $current_date) {
            $error['u'] = "Vui lòng nhập ngày khám hợp lệ!";
        }
        if(count($error)==0){
    
            $u = "UPDATE appointment SET ";
    
            if (!empty($hoten)) {
              $u .= "hotenbenhnhan = '$hoten', ";
            }
            
            if (!empty($ngaysinh)) {
              $u .= "ngaysinh = '$ngaysinh', ";
            }
            
            if (!empty($gioitinh)) {
              $u .= "gioitinh = '$gioitinh', ";
            }
            
            if (!empty($diachi)) {
              $u .= "diachi = '$diachi', ";
            }
            
            if (!empty($sdt)) {
              $u .= "sdt = '$sdt', ";
            }
            
            if (!empty($trieuchung)) {
              $u .= "trieuchung = '$trieuchung', ";
            }
            
            if (!empty($dichvuyte)) {
                $u .= "dichvuyte = '$ndichvuytedk', ";
            }

            if (!empty($ngaykham)) {
                $u .= "ngayhenkham = '$ngaykham', ";
            }

            $u = rtrim($u, ', '); // Xóa dấu ',' cuối cùng trong câu lệnh UPDATE
            
            $u .= " WHERE id = $id"; // Thêm điều kiện WHERE để chỉ cập nhật dòng có id tương ứng
        
        $up = mysqli_query($connect, $u);
        if($up){
            header("location: appointment.php");
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>appointment</title>
    <style>
        form input{
            margin-bottom: 0.6rem;
        }
    </style>
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
                            <div class="col-md-9">
                                <h5 class="text-center my-2 ">Tất cả lịch hẹn</h5>
                                <?php
                                $ad = $_SESSION['staff'];
                            
                                // SEARCH
                                if(isset($_POST['search'])){
                                    $sername = $_POST['sername'];
                                    $query = "SELECT * FROM appointment WHERE hotenbenhnhan LIKE '%$sername%' OR CAST(id AS CHAR) LIKE '$sername'";
                                    
                                }
                                else{
                                    $query = "SELECT * FROM appointment";   
                                }
                                $res = mysqli_query($connect, $query);
                                $output = "";
                                $output .= "
                                <table class = 'table table-bordered'>
                                    <tr>
                                        <td>ID Lịch hẹn</td>
                                        <td>Họ và tên bệnh nhân</td>
                                        <td>Ngày sinh</td>
                                        <td>Giới tính</td>
                                        <td>Địa chỉ</td>
                                        <td>Số điện thoại</td>
                                        <td>Triệu chứng</td>
                                        <td>Dịch vụ y tế</td>
                                        <td>Ngày hẹn khám</td>
                                        <td style='width:10%;'>Hoạt động</td>
                                    </tr>
                    
                    
                                ";
                                if (mysqli_num_rows($res) < 1) {
                                    $output .= "
                                    <tr>
                                    <td class='text-center' colspan='10'>
                                    Không có lịch hẹn
                                    </td>
                                </tr>
                                ";
                                }
                                while ($row = mysqli_fetch_array($res)) {
                                   $id = $row['id'];
                                    $output .= "
                                        <tr>
                                            <td>" . $row['id'] . "</td>
                                            <td>" . $row['hotenbenhnhan'] . "</td>
                                            <td>" . $row['ngaysinh'] . "</td>
                                            <td>" . $row['gioitinh'] . "</td>
                                            <td>" . $row['diachi'] . "</td>
                                            <td>" . $row['sdt'] . "</td>
                                            <td>" . $row['trieuchung'] . "</td>
                                            <td>" . $row['dichvuyte'] . "</td>
                                            <td>" . $row['ngayhenkham'] . "</td>
                                            <td>
                                            <form method='post'>
                                            <button class='btn btn-danger remove' name='remove' value='$id'>Xóa</button>
                                            </form>
                                            </td>
                                        ";
                                }
                                $output .= "</tr> </table>";
                                echo $output;
                                
                                ?>
                            </div>
                            <div class="col-md-3">
                            <h5 class="text-center">Thông tin lịch hẹn</h5>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div>
                                        <?php echo $show; ?>
                                    </div>
                                    <label>Tìm kiếm lịch hẹn</label>
                                    <input type="text" name="sername" class="form-control" autocomplete="off">
                                    
                                </div>
                                <input type="submit" name="search" class="btn btn-success" value="Tìm kiếm">
                                <div class="from-group">
                                    <label>ID lịch hẹn</label>
                                    <input type="text" name="idlichhen" class="form-control">
                                    <label>Họ và Tên</label>
                                    <input type="text" name="hoten" class="form-control">
                                    <label>Ngày sinh</label>
                                    <input type="date" name="ngaysinh" class="form-control"> 
                                    <label>Giới tính</label>
                                    <select name="gioitinh" style="margin-left: 2px;">
                                        <option value="nam" selected>Nam</option> 
                                        <option value="nu">Nữ</option>
                                        <option value="other">Khác</option>
                                    </select><br>
                                    <label>Địa chỉ</label>
                                    <input type="text" name="diachi" class="form-control"> 
                                    <label>Số Điện thoại</label>
                                    <input type="number" name="sdt" class="form-control"> 
                                    <label>Triệu chứng</label>  
                                    <input type="text" name="trieuchung" class="form-control"> 
                                    <label for="">Dịch vụ y tế: </label>
                                    <select name="dichvuyte" style="margin-left: 2px;">
                                        <option value="dv1">Khám tổng quát</option> 
                                        <option value="dv2">Xét Nghiệm dị ứng</option>
                                        <option value="dv3">Xét nghiệm gan</option>
                                        <option></option>
                                    </select><br>
                                    <label>Ngày hẹn khám</label>
                                    <input type="date" name="ngaykham" class="form-control"> 
                                </div>
                               
                                <input type="submit" name="add" value="Thêm" class="btn btn-success">
                                <input type="submit" name="update" value="Cập nhật" class="btn btn-success">
                                <input type="submit" name="clear" value="Làm mới" class="btn btn-success">
                               
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