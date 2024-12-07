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
                            <div class="col-md-8">
                            <h5 class="text-center my-3">
                                Thông tin bệnh nhân
                            </h5>
                            
                            <?php
                            if(isset($_GET['idbenhnhhanh'])){
                                $idbenhnhan = $_GET['idbenhnhhanh'];
                                $query = "SELECT * FROM patient WHERE idbenhnhan = '$idbenhnhan'";
                                $res = mysqli_query($connect, $query);
                                $row = mysqli_fetch_array($res);
                            }
                            ?>
                            </div>
                            <div class="col-md-4">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="from-group">
                                    <label>ID Bệnh nhân</label>
                                    <input type="text" name="idthunhap" class="form-control">
                                    <label>Tên bênh nhân</label>
                                    <input type="text" name="idbenhnhan" class="form-control">
                                    <label>Só điện thoai</label>
                                    <input type="text" name="benhnhan" class="form-control">
                                    <label>Ngày sinh</label>
                                    <input type="text" name="benhnhan" class="form-control"> 
                                    <label>Giới tính</label>
                                    <input type="text" name="benhnhan" class="form-control">   
                                    <label>Địa chỉ</label>
                                    <input type="text" name="benhnhan" class="form-control"> 
                                    <label>Email</label>
                                    <input type="text" name="benhnhan" class="form-control"> 
                                    <label>Ngày đăng kí</label>
                                    <input type="text" name="benhnhan" class="form-control">                
                                    
                                </div><br>
                                <input type="submit" name="update" value="Cập nhật" class="btn btn-success">
                                <input type="submit" name="delete" value="Xóa Bỏ" class="btn btn-danger">
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