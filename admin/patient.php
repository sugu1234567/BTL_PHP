<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>patient</title>
</head>

<body>
    <?php
    include('header.php');
    include('connect.php');
    ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php
                    include('sidenav.php');
                    ?>
                </div>
                <div class="col-md-10">
                    <h5 class="text-center my-3">Thông tin bệnh nhân</h5>
                    <form class="form-group" method="POST">
                        <div class="form-group">
                            <label>Tìm kiếm bệnh nhân</label>
                            <input type="search" name="uname" class="form-control" autocomplete="off">
                        </div>
                        <input type="submit" name="change" class="btn btn-success" value="Tìm kiếm">
                        <button class="btn btn-success" onclick="openNewWindow('themmoi.php')">Thêm mới</button>
                    </form>

                    <?php
                    $query = "SELECT * FROM patient";
                    $res = mysqli_query($connect, $query);
                    $output = "";
                    $output .= "<table class='table table-bordered'>
                                        <tr>
                                            <th>ID bệnh nhân</th>
                                            <th>Tên bệnh nhân</th>
                                            <th>Số điện thoại</th>
                                            <th>Ngày sinh</th>
                                            <th>Giới tính</th>
                                            <th>Địa chỉ</th>
                                            <th>Email</th>
                                            <th>Ngày đăng kí</th>
                                            <th>Hoạt động</th>
                                        </tr>";
                    if (mysqli_num_rows($res) < 1) {
                        $output .= "<tr>
                                            <td class='text-center' colspan='9'>
                                                Không có bệnh nhân
                                            </td>
                                        </tr>";
                    } else {
                        while ($row = mysqli_fetch_array($res)) {
                            $output .= "<tr>
                                                <td>" . $row['idbenhnhan'] . "</td>
                                                <td>" . $row['tenbenhnhan'] . "</td>
                                                <td>" . $row['sdt'] . "</td>
                                                <td>" . $row['ngaysinh'] . "</td>
                                                <td>" . $row['gioitinh'] . "</td>
                                                <td>" . $row['diachi'] . "</td>
                                                <td>" . $row['email'] . "</td>
                                                <td>" . $row['ngaydangki'] . "</td>
                                                <td>
                                                <a href='view.php?id=" . $row['idbenhnhan'] . "'>
                                                <button class='btn btn-info'>Xem</button>
                                            </a>
                                                </td>
                                            </tr>";
                        }
                    }
                    $output .= "</table>";
                    echo $output;
                    ?>

                    <script>
                        function openNewWindow(url) {
                            window.open(url, "_blank", "width=800, height=600");
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>