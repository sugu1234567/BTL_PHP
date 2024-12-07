<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income</title>
</head>

<body>
    <?php
    include('header.php');
    include('connect.php');
    ?>
    <div class="container-fluid">
        <div class=" col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php
                    include('sidenav.php');
                    ?>
                </div>
                <div class="col-md-10">
                    <div div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="text-center my-2 ">Tất cả thu nhập</h5>
                                <?php
                                $query = "SELECT * FROM income";
                                $res = mysqli_query($connect, $query);
                                $output = "";
                                $output .= "
                                <table class = 'table table-bordered'>
                                    <tr>
                                        <td>ID Thu nhập</td>
                                        <td>ID Bệnh nhân</td>
                                        <td>Bác sĩ</td>
                                        <td>Bệnh nhân</td>
                                        <td>Ngày trả tiền</td>
                                        <td>Số tiền trả</td>
                                        <td style='width:10%;'>Hoạt động</td>
                                    </tr>
                    
                    
                                ";
                                if (mysqli_num_rows($res) < 1) {
                                    $output .= "
                                    <tr>
                                    <td class='text-center' colspan='6'>
                                    Không có thu nhập
                                    </td>
                                </tr>
                                ";
                                }
                                while ($row = mysqli_fetch_array($res)) {
                                    $output .= "
                                        <tr>
                                            <td>" . $row['idthunhap'] . "</td>
                                            <td>" . $row['idbenhnhan'] . "</td>
                                            <td>" . $row['bacsiphutrach'] . "</td>
                                            <td>" . $row['tenbenhnhan'] . "</td>
                                            <td>" . $row['ngaytratien'] . "</td>
                                            <td>" . $row['sotientra'] . "</td>
                                            <td>
                                            <button  class='btn btn-danger 
                                            remove'>Xóa</button>
                                            </td>
                                        ";
                                }
                                $output .= "</tr> </table>";
                                echo $output;
                                
                                ?>
                            </div>
                            <div class="col-md-3">
                            <h5 class="text-center">Thông tin thu nhập</h5>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Tìm kiếm theo ngày</label>
                                    <input type="search" name="uname" class="form-control" autocomplete="off">
                                    
                                </div>
                                <input type="submit" name="change" class="btn btn-success" value="Tìm kiếm">
                                <div class="from-group">
                                    <label>ID thu nhập</label>
                                    <input type="text" name="idthunhap" class="form-control">
                                    <label>Id bệnh nhân</label>
                                    <input type="text" name="idbenhnhan" class="form-control">
                                    <label>Tên bệnh nhân</label>
                                    <input type="text" name="benhnhan" class="form-control">
                                    <label>Bác sĩ phụ trách</label>
                                    <input type="text" name="bacsi" class="form-control" style="margin-bottom: 1rem;">                        
                                    <label>Ngày trả tiền</label>
                                    <input type="text" name="ngaysinh" class="" style="width : 40px; text-align: center;"> /
                                    <input type="text" name="ngaysinh" class="" style="width : 40px; text-align: center;"> /
                                    <input type="text" name="ngaysinh" class="" style="width : 45px; text-align: center;"><br>
                                   
                                    <label style="margin-top: 1rem;">Số tiền trả</label>
                                    <input type="text" name="sdt" class="form-control">
                                    
                                </div><br>
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