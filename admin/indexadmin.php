<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>

<body>
    <?php
    include('header2.php');
    include('connect.php');
    ?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php
                    include("sidenav.php");
                    ?>
                </div>
                <div class="col-md-10">
                    <h4 class="my-2">
                        Bảng điều khiển
                    </h4>
                    <div class="col-md-12 my-5">
                        <div class="row">
                            <div class="col-md-3 bg-success mx-2" style="height: 130px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php
                                            $ad = mysqli_query($connect, "SELECT * FROM Login");
                                            $num = mysqli_num_rows($ad);
                                            ?>
                                            <h5 class="my-2 text-white " style="font-size: 20px"><?php echo $num ?></h5>
                                            <h5 class=" text-white" style="font-size: 20px">Quản lý</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Tài khoản</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="admin.php"><i class="fa fa-user-cog fa-3x my-4" style="color:white;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-info mx-2" style="height: 130px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php
                                            $sr = mysqli_query($connect, "SELECT * FROM doctor");
                                            $num = mysqli_num_rows($sr);
                                            ?>
                                            <h5 class="my-2 text-white " style="font-size: 20px"><?php echo $num ?></h5>
                                            <h5 class=" text-white" style="font-size: 20px">Quản lý</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Bác sĩ</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="doctor.php"><i class="fa fa-user-md fa-3x my-4" style="color:white;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-warning mx-2" style="height: 130px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 class="my-2 text-white " style="font-size: 20px">0</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Quản lý</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Bệnh nhân</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="patient.php"><i class="fa fa-procedures fa-3x my-4" style="color:white;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-danger mx-2 my-2" style="height: 130px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 class="my-2 text-white " style="font-size: 20px">0</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Quản lý</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Lịch hẹn</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="#"><i class="fa fa-calendar-check fa-3x my-4" style="color:white;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-warning mx-2 my-2" style="height: 130px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 class="my-2 text-white " style="font-size: 20px">0</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Quản lý </h5>
                                            <h5 class=" text-white" style="font-size: 20px">Dịch vụ</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="#"><i class="fa fa-capsules fa-3x my-4" style="color:white;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-success mx-2 my-2" style="height: 130px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 class="my-2 text-white " style="font-size: 20px">0</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Tổng</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Thu nhập</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="income.php"><i class="fa fa-money-check-alt fa-3x my-4" style="color:white;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-info mx-2 my-2" style="height: 130px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 class="my-2 text-white " style="font-size: 20px">0</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Báo cáo</h5>
                                            <h5 class=" text-white" style="font-size: 20px">Thống kê</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="#"><i class="fa fa-chart-line fa-3x my-4" style="color:white;"></i></a>
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