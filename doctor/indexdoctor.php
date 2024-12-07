<?php
session_start();
include('../connect.php');
$staff = isset($_SESSION['staff'])? $_SESSION['staff']: "";
$x = mysqli_query($connect, "SELECT id FROM Login WHERE username='$staff'");
$r = mysqli_fetch_array($x);
$idlogin_staff = isset($r['id'])? $r['id']:""; 
$x = mysqli_query($connect, "SELECT id, photo FROM doctor WHERE idlogin_staff='$idlogin_staff'");
$r = mysqli_fetch_array($x);
$idstaff = isset($r['id'])?$r['id']:"";
$photo = isset($r['photo'])? $r['photo']:"";

$_SESSION['img'] = $photo;
$_SESSION['idstaff'] = $idstaff;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
</head>

<body>
    <?php
    include('headerdoctor.php');
    ?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php
                    include('sidenavdoctor.php');
                    ?>
                </div>
                <div class="col-md-10">
                    <h4 class="my-2">
                        Bảng điều khiển
                    </h4>
                    <div class="col-md-12 my-5">
                        <div class="row">
                            <div class="col-md-3 bg-info mx-2" style="height: 130px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8" style="margin-top: 20px;">
                                        <h5 class="my-2 text-white " style="font-size: 20px"></h5>
                                            <h5 class=" text-white" style="font-size: 20px">Tài khoản</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Của tôi</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="profile.php"><i class="fa fa-user-md fa-3x my-4" style="color:white;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-warning mx-2" style="height: 130px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php
                                            $p = mysqli_query($connect, "SELECT * FROM patient");
                                            $nummm = mysqli_num_rows($p);
                                            ?>
                                            <h5 class="my-2 text-white " style="font-size: 20px"><?php echo $nummm ?></h5>
                                            <h5 class=" text-white" style="font-size: 20px">Quản lý</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Bệnh nhân</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="patient.php"><i class="fa fa-procedures fa-3x my-4" style="color:white;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-danger mx-2" style="height: 130px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                        <?php
                                            $a = mysqli_query($connect, "SELECT * FROM appointment");
                                            $nummmm = mysqli_num_rows($a);
                                            ?>
                                            <h5 class="my-2 text-white " style="font-size: 20px"><?php echo $nummmm ?></h5>
                                            <h5 class=" text-white" style="font-size: 20px">Quản lý</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Lịch hẹn</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="appointment.php"><i class="fa fa-calendar-check fa-3x my-4" style="color:white;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>