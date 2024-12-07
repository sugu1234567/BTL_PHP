<?php
    session_start();
    include('../connect.php');
    $iduser = isset($_SESSION['iduser'])? $_SESSION['iduser']: "";
            // DELETE
        if(isset($_POST['remove'])){
            $user_id = $_POST['remove'];
            // Xử lý yêu cầu xóa dòng dữ liệu từ cơ sở dữ liệu ở đây
            $delete_query = "DELETE FROM appointment WHERE id = '$user_id'";
            $delete_result = mysqli_query($connect, $delete_query);
            if($delete_result){ 
            //    echo "Record deleted successfully!";
                 header("Location: appointmentpatient.php");
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
    <title>Profile</title>
    <style>
        body {
            background-color: rgb(229, 255, 255);
            font-size: medium;
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

        

        .table {
            border: 1px solid black;
        }

        

        .ttnguoidung {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 15rem;
        }

        h2 {
            position: fixed;
            top: 11rem;
            left: 67rem;
        }
        .table{
            border: 1 solid black;;
        }
        td {
      
      border: 1px solid black;
    }
    .table.table-bordered {
      border-collapse: collapse;
      margin: 0 auto;
      width: 80%; /* Kích thước bảng */
    }
    .text-center{
        text-align: center;
    }
    </style>
</head>

<body>
    <div>
        <?php
        include('hearderpatient3.php');
        ?>
    </div>
    <div class="container">
        <h2 class="">
            Lịch hẹn đã đặt
        </h2>
        <div class="ttnguoidung">

            <?php

            

            $query = "SELECT * FROM appointment WHERE idnguoidung='$iduser'";

            $res = mysqli_query($connect, $query);
            $output = "";
            $output .= "
                                <table class = 'table table-bordered'>
                                    <tr>
                                        <td>ID Lịch hẹn</td>
                                        <td>Họ và tên</td>
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
                                            <td style='text-align:center;'>
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
    </div>


</body>

</html>