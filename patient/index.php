<?php
session_start();
include("../connect.php");
    $user = isset($_SESSION['user'])? $_SESSION['user']: "";
    $x = mysqli_query($connect, "SELECT id FROM Login WHERE username='$user'");
    $r = mysqli_fetch_array($x);
    $idlogin = isset($r['id'])? $r['id']:""; 
    $x = mysqli_query($connect, "SELECT id, photo FROM user WHERE idlogin='$idlogin'");
    $r = mysqli_fetch_array($x);
    $iduser = isset($r['id'])?$r['id']:"";
    $photo = isset($r['photo'])? $r['photo']:"";
    $_SESSION['photo'] = $photo;
    $_SESSION['iduser'] = $iduser;
    $show = "";
    $erht = "";
    $erns = "";
    $ersdt = "";
    $erdc = "";
    $ertc = "";
    $ernhk = "";
    // Đặt lịch
    if(isset($_POST['datlich'])){
        if($user==""){
            header("location: ../login.php");
        }
        else{
            $hoten = $_POST['name'];
            $ngaysinh = $_POST['ngaysinh'];
            $sdt = $_POST['sdt'];
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
            $trieuchung = $_POST['trieuchung'];
            if (isset($_POST['dichvuyte'])) {
                $dichvuyte = $_POST['dichvuyte'];
              
            }
            $ngayhenkham = $_POST['ngayhenkham'];
            $truyvan = mysqli_query($connect, "SELECT id FROM service WHERE tendichvu='$dichvuyte'");
            $row = mysqli_fetch_array($truyvan);
            $idnguoidung = $iduser;
            $iddichvu = $row['id'];
            $ngaysinh_formatted = date('Y-m-d', strtotime($ngaysinh));
            $current_date = date('Y-m-d');
            $error = array();

            // Kiểm tra ngày sinh có hợp lệ hay không
            $date_parts = explode('-', $ngaysinh_formatted);
            if (count($date_parts) !== 3 || !checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
                $error['ns'] = "Vui lòng nhập ngày sinh hợp lệ!";
            }

            // Kiểm tra ngày sinh không nằm trong tương lai
            if ($ngaysinh_formatted > $current_date) {
                $error['ns'] = "Vui lòng nhập ngày sinh hợp lệ!";
            }
            if (empty($hoten)) {
                $error['ht'] = "Vui lòng nhập họ tên!";
            }
            elseif (empty($trieuchung)) {
                $error['tc'] = "Vui lòng nhập triệu chứng!";
            }
            elseif (empty($ngaysinh)) {
                $error['ns'] = "Vui lòng nhập ngày sinh!";
            }
            elseif (empty($sdt)) {
                $error['sdt'] = "Vui lòng nhập số điện thoại!";
            }
            elseif (empty($diachi)) {
                $error['dc'] = "Vui lòng nhập địa chỉ!";
            }
            elseif (empty($ngayhenkham)) {
                $error['nhk'] = "Vui lòng chọn ngày hẹn khám!";
            }
            $ngaysinh_formatted = date('Y-m-d', strtotime($ngayhenkham));
            $current_date = date('Y-m-d');

            // Kiểm tra ngày  có hợp lệ hay không
            $date_parts = explode('-', $ngaysinh_formatted);
            if (count($date_parts) !== 3 || !checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
                $error['ns'] = "Vui lòng nhập ngày hợp lệ!";
            }

            if (count($error) == 0) {
              
                    $q = "INSERT INTO appointment(idnguoidung, hotenbenhnhan, ngaysinh, gioitinh, diachi, sdt, trieuchung, iddichvu, dichvuyte, ngayhenkham)
                     VALUES ('$idnguoidung', '$hoten', '$ngaysinh', '$gioitinh', '$diachi', '$sdt', '$trieuchung', '$iddichvu', '$dichvuyte', '$ngayhenkham')";
                                
                $result = mysqli_query($connect, $q);
                if ($result) {
                 //   echo "Account added successfully!";
                    header("location: appointmentpatient.php");
                    exit();
                } else {
                    $show = "Đặt lịch hẹn không thành công!";
                }
            }


            if(isset($error['ht'])){
                $erht = $error['ht'];
            }
            elseif(isset($error['tc'])){
                $ertc = $error['tc'];
            }
            elseif(isset($error['ns'])){
                $erns = $error['ns'];
            }
            elseif(isset($error['sdt'])){
                $ersdt = $error['sdt'];
            }
            elseif(isset($error['dc'])){
                $erdc = $error['dc'];
            }
            elseif(isset($error['nhk'])){
                $ernhk = $error['nhk'];
            }

        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chăm sóc sức khỏe</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <?php

    if (isset($_SESSION['user'])) {
        include('headerpatient.php');
    } else {
        include('headerpatient2.php');
    }
    ?>




    <!-- header section ends -->

    <!-- home section starts  -->

    <section class="home" id="home">

        <div class="image">
            <img src="image/home-img.svg" alt="">
        </div>

        <div class="content">
            <h3>Chúng tôi chăm sóc cuộc sống khỏe mạnh của bạn</h3>
            <p>Một Người Có Sức Khỏe Thể Chất Tốt Thường Có Các Chức Năng Và Quá Trình Hoạt Động Của Cơ Thể Ở Mức Cao Nhất.</p>
            <a href="#appointment" class="btn"> Hẹn chúng tôi <span class="fas fa-chevron-right"></span> </a>
        </div>

    </section>

    <!-- home section ends -->

    <!-- icons section starts  -->

    <section class="icons-container">

        <div class="icons">
            <i class="fas fa-user-md"></i>
            <h3>150+</h3>
            <p>Đội ngũ bác sĩ</p>
        </div>

        <div class="icons">
            <i class="fas fa-users"></i>
            <h3>1030+</h3>
            <p>Bệnh nhân hài lòng</p>
        </div>

        <div class="icons">
            <i class="fas fa-procedures"></i>
            <h3>490+</h3>
            <p>Số giường bệnh</p>
        </div>

        <div class="icons">
            <i class="fas fa-hospital"></i>
            <h3>20+</h3>
            <p>Bệnh viện có sãn</p>
        </div>

    </section>

    <!-- icons section ends -->

    <!-- about section starts  -->

    <section class="about" id="about">

        <h1 class="heading"> <span>Về</span> chúng tôi </h1>

        <div class="row">

            <div class="image">
                <img src="image/about-img.svg" alt="">
            </div>

            <div class="content">
                <h3>Áp Dụng Phương Pháp Điều Trị Chất Lượng Tốt Nhất Thế Giới</h3>
                <p>Chúng tôi tự hào là một đội ngũ chuyên gia y tế và nhân viên có kinh nghiệm, luôn tận tâm và chuyên nghiệp trong việc cung cấp các dịch vụ chăm sóc sức khỏe đa dạng. Chúng tôi cung cấp các phương pháp điều trị y tế, chăm sóc bệnh nhân, và các giải pháp tiên tiến trong lĩnh vực y tế.</p>
                <p>Công ty của chúng tôi cam kết đảm bảo sự an toàn, hiệu quả và tiện lợi cho khách hàng. Chúng tôi luôn áp dụng các tiêu chuẩn cao nhất trong việc quản lý chất lượng, đảm bảo rằng mọi dịch vụ và sản phẩm đều tuân thủ các quy định và tiêu chuẩn y tế quốc tế.</p>
                <a href="#" class="btn"> Tìm hiểu thêm <span class="fas fa-chevron-right"></span> </a>
            </div>

        </div>

    </section>

    <!-- about section ends -->

    <!-- services section starts  -->

    <section class="services" id="services">

        <h1 class="heading"> Dịch vụ <span>của chúng tôi</span> </h1>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-notes-medical"></i>
                <h3>Xét nghiệm mỡ máu</h3>
                <p>Triglyceride,
                    HDL-Cholesterol,
                    LDL-Cholesterol,
                    Cholesterol toàn phần</p>
                <h3>149.000 vnđ</h3>
                <a href="#appointment" class="btn"> Đặt lịch ngay <span class="fas fa-chevron-right"></span> </a>
            </div>
            <div class="box">
                <i class="fas fa-notes-medical"></i>
                <h3>Chuẩn đoán sốt xuất huyết</h3>
                <p>Công thức máu,
                    Dengue NS1,
                    Dengue IgG+IgM</p>
                <h3>339.000 vnđ</h3>
                <a href="#appointment" class="btn"> Đặt lịch ngay <span class="fas fa-chevron-right"></span> </a>
            </div>

            <div class="box">
                <i class="fas fa-ambulance"></i>
                <h3>Xe cứu thương 24/7</h3>
                <p>Dịch vụ đưa đón bằng xe cứu thương tận nhà</p>
                <h3>300.000 vnđ</h3>
                <a href="#appointment" class="btn"> Call: 0854128229 <span class="fas fa-chevron-right"></span> </a>
            </div>

            <div class="box">
                <i class="fas fa-notes-medical"></i>
                <h3>Xét nghiệm men gan</h3>
                <p>Lấy mẫu , AST (GOT) ,
                    ALT (GPT) ,
                    GGT (g-GT) </p>
                <h3>129.000 vnđ</h3>
                <a href="#appointment" class="btn"> Đặt lịch ngay <span class="fas fa-chevron-right"></span> </a>
            </div>
            <div class="box">
                <i class="fas fa-notes-medical"></i>
                <h3>Xét nghiệm thận tổng quát</h3>
                <p>Vì là bộ phận phải hoạt động liên tục và tiếp xúc với chất thải nên thận vô cùng nhạy cảm và dễ dàng bị suy chức năng và mắc bệnh như: suy thận, viêm cầu thận, sỏi thận, ung thư thận.</p>
                <h3>89.000 vnđ</h3>
                <a href="#appointment" class="btn"> Đặt lịch ngay <span class="fas fa-chevron-right"></span> </a>
            </div>
            <div class="box">
                <i class="fas fa-notes-medical"></i>
                <h3>Gói xét nghiệm toàn diện</h3>
                <p>Viêm nhiễm, thiếu máu (Công thức máu),
                    Sàng lọc và chẩn đoán tiểu đường (Glucose, HbA1c),
                    Mỡ máu (Cholesterol, Triglycerid, HDL – Cholesterol,
                    Tổng phân tích nước tiểu...</p>
                <h3>1.645.000 vnđ</h3>
                <a href="#appointment" class="btn"> Đặt lịch ngay <span class="fas fa-chevron-right"></span> </a>
            </div>
            <div class="box">
                <i class="fas fa-notes-medical"></i>
                <h3>Gói xét nghiệm gan chuyên sâu</h3>
                <p>Viêm Gan B (HBsAg, Anti HBs)
                    Viêm gan C (Anti HCV)
                    Men gan (AST, ALT, GGT)
                    Chức năng Gan (Albumin, Bilirubin TP, Bilirubin TT, Bilirubin GT)
                    Mỡ máu (Cholesterol, Triglycerid, HDL – Cholesterol</p>
                <h3>960.000 vnđ</h3>
                <a href="#appointment" class="btn"> Đặt lịch ngay <span class="fas fa-chevron-right"></span> </a>
            </div>

            <div>
                <a href="#appointment" class="btn"> Xem thêm <span class="fas fa-chevron-right"></span> </a>
            </div>

        </div>

    </section>

    <!-- services section ends -->



    <!-- doctors section starts  -->

    <section class="doctors" id="doctors">

        <h1 class="heading"> Đội ngũ <span>bác sĩ</span> </h1>

        <div class="box-container">

            <div class="box">
                <img src="image/doc-2.jpg" alt="">
                <h3>Nguyễn Trung Đức</h3>
                <span>Chuyên khoa Tim mạch</span>
                <div class="share">
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-facebook-f"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-twitter"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-instagram"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-linkedin"></a>

                </div>
            </div>

            <div class="box">
                <img src="image/doc-1.jpg" alt="">
                <h3>Ngô Văn Nam</h3>
                <span>Răng Hàm Mặt</span>
                <div class="share">
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-facebook-f"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-twitter"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-instagram"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-linkedin"></a>
                </div>
            </div>

            <div class="box">
                <img src="image/doc-3.jpg" alt="">
                <h3>Bùi Quốc Huy</h3>
                <span>Bệnh truyền nhiễm</span>
                <div class="share">
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-facebook-f"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-twitter"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-instagram"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-linkedin"></a>
                </div>
            </div>

            <div class="box">
                <img src="image/doc-4.jpg" alt="">
                <h3>Bác sĩ A</h3>
                <span>Bệnh truyền nhiễm</span>
                <div class="share">
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-facebook-f"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-twitter"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-instagram"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-linkedin"></a>
                </div>
            </div>

            <div class="box">
                <img src="image/doc-5.jpg" alt="">
                <h3>Bác sĩ B</h3>
                <span>Bệnh truyền nhiễm</span>
                <div class="share">
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-facebook-f"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-twitter"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-instagram"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-linkedin"></a>
                </div>
            </div>

            <div class="box">
                <img src="image/doc-6.jpg" alt="">
                <h3>Bác sĩ C</h3>
                <span>Bệnh truyền nhiễm</span>
                <div class="share">
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-facebook-f"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-twitter"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-instagram"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-linkedin"></a>

                </div>
            </div>
            <div class="box">
                <img src="image/doc-7.jpg" alt="">
                <h3>Bác sĩ D</h3>
                <span>Bệnh truyền nhiễm</span>
                <div class="share">
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-facebook-f"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-twitter"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-instagram"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-linkedin"></a>
                </div>
            </div>
            <div class="box">
                <img src="image/doc-8.jpg" alt="">
                <h3>Bác sĩ E</h3>
                <span>Bệnh truyền nhiễm</span>
                <div class="share">
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-facebook-f"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-twitter"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-instagram"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-linkedin"></a>
                </div>
            </div>
            <div class="box">
                <img src="image/doc-9.jpg" alt="">
                <h3>Bác sĩ F</h3>
                <span>Bệnh truyền nhiễm</span>
                <div class="share">
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-facebook-f"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-twitter"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-instagram"></a>
                    <a href="https://www.facebook.com/nam.ngovan.31149?locale=vi_VN" class="fab fa-linkedin"></a>
                </div>
            </div>

        </div>

    </section>

    <!-- doctors section ends -->

    <!-- appointmenting section starts   -->

    <section class="appointment" id="appointment">

        <h1 class="heading"> <span>Đặt lịch</span> ngay </h1>

        <div class="row">

            <div class="image">
                <img src="image/appointment-img.svg" alt="">
            </div>

            <form action="" method="post">
                <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '<p class ="message">' . $message . '</p>';
                    }
                }
                ?>

                <div class="inputlichhen">
                    
                    <h3>Đặt lịch hẹn</h3>
                    <h2 style="color: red; text-align: center;"><?php echo $show ?></h2>
                    <label>Họ và tên: </label>
                    <p style="color: red;"><?php echo $erht ?></p>
                    <input type="text" name="name" placeholder="Họ và Tên" class="box">
                    <label>Ngày sinh: </label>
                    <p style="color: red;"><?php echo $erns ?></p>
                    <input type="date" name="ngaysinh" class="box">
                    <label>Số điện thoại</label>
                    <p style="color: red;"><?php echo $ersdt ?></p>
                    <input type="number" name="sdt" placeholder="Số điện thoại" class="box">
                    <label>Giới tính: </label>
                    <select name="gioitinh" id="" class="box">
                        <option value="nam">Nam</option>
                        <option value="nu">Nữ</option>
                        <option value="other">Khác</option>
                    </select> <br>
                    <label>Địa chỉ: </label>
                    <p style="color: red;"><?php echo $erdc ?></p>
                    <input type="text" name="diachi" placeholder="Địa chỉ" class="box">
                    <label>Triệu chứng: </label>
                    <p style="color: red;"><?php echo $ertc ?></p>
                    <input type="text" name="trieuchung" placeholder="Triệu chứng" class="box">
                    <label>Dịch vụ y tế: </label>
                    <select name="dichvuyte" id="tendichvu" class="box">
                        <?php
                        $a = mysqli_query($connect, "SELECT tendichvu FROM service");
                        while ($row = mysqli_fetch_assoc($a)) {
                            $tendichvu = $row['tendichvu'];
                            echo "<option value='$tendichvu'>$tendichvu</option>";
                        }
                        ?>
                    </select> <br>
                    
                    <label>Giá tiền: </label>
                    <input type="text" name="giatien" id="giatien" class="box" readonly placeholder="*******">
                    <label>Ngày hẹn khám: </label>
                    <p style="color: red;"><?php echo $ernhk ?></p>
                    <input type="date" name="ngayhenkham" class="box">
                </div>

                <input type="submit" name="datlich" value="Đặt lịch ngay" class="btn">
            </form>

        </div>

    </section>

    <!-- appointmenting section ends -->

    <!-- review section starts  -->

    <section class="review" id="review">

        <h1 class="heading"> Đánh giá <span>Của khách hàng</span> </h1>

        <div class="box-container">

            <div class="box">
                <img src="image/pic-3.jpg" alt="">
                <h3>nguoidung1</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text">Quá trình tiếp nhận và đón tiếp rất chuyên nghiệp và thân thiện. Nhân viên lễ tân và nhân viên tiếp đón luôn tỏ ra nhiệt tình, chu đáo và sẵn lòng giải đáp mọi thắc mắc của tôi. Tôi cảm thấy được chào đón và quan tâm từ khi bước vào bệnh viện.</p>
            </div>

            <div class="box">
                <img src="image/pic-1.jpg" alt="">
                <h3>nguoidung2</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text">Tôi hài lòng với chất lượng dịch vụ y tế mà tôi nhận được. Bác sĩ và y tá đã thể hiện sự chuyên môn và tận tâm trong việc chẩn đoán và điều trị. Tôi cảm thấy được lắng nghe và thông tin về tình trạng sức khỏe của mình được giải thích một cách rõ ràng.</p>
            </div>

            <div class="box">
                <img src="image/pic-2.png" alt="">
                <h3>nguoidung3</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text">Bệnh viện được trang bị các trang thiết bị y tế hiện đại và công nghệ tiên tiến. Điều này góp phần đáng kể vào sự chính xác và hiệu quả của quy trình chẩn đoán và điều trị. Tôi cảm thấy yên tâm khi biết rằng tôi đang nhận được sự chăm sóc với các công cụ và thiết bị tiên tiến nhất.</p>
            </div>

        </div>

    </section>

    <!-- review section ends -->

    <!-- blogs section starts  -->

    <section class="blogs" id="blogs">

        <h1 class="heading"> BLogs <span>của chúng tôi</span> </h1>

        <div class="box-container">

            <div class="box">
                <div class="image">
                    <img src="image/blog-1.jpg" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                    </div>
                    <h3>"Bệnh viện với trang thiết bị hiện đại: Giải pháp y tế tiên tiến cho mọi bệnh tình"</h3>
                    <a href="#" class="btn">Xem thêm<span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="image/blog-2.jpg" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                    </div>
                    <h3>"Bệnh viện đẳng cấp quốc tế: Chất lượng dịch vụ y tế không giới hạn"</h3>
                    <a href="#" class="btn"> Xem thêm <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="image/blog-3.jpg" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                    </div>
                    <h3>"Bệnh viện chuyên khoa hàng đầu: Sự chăm sóc chuyên môn đáng tin cậy"</h3>
                    <a href="#" class="btn"> Xem thêm <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>
            <div class="box">
                <div class="image">
                    <img src="image/blog-4.jpg" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                    </div>
                    <h3>"Chúng tôi đồng hành cùng bạn: Hỗ trợ nhiệt tình, không giới hạn"</h3>
                    <a href="#" class="btn"> Xem thêm <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>
            <div class="box">
                <div class="image">
                    <img src="image/blog-5.jpg" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                    </div>
                    <h3>"Chăm sóc đa phương diện: Bệnh viện đáng tin cho mọi gia đình"</h3>
                    <a href="#" class="btn"> Xem thêm <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>
            <div class="box">
                <div class="image">
                    <img src="image/blog-6.jpg" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                    </div>
                    <h3>"Chăm sóc y tế tối ưu: Bệnh viện với đội ngũ chuyên gia hàng đầu"</h3>
                    <a href="#" class="btn"> Xem thêm <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>

        </div>

    </section>

    <!-- blogs section ends -->

    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>Điều Hướng</h3>
                <a href="#home"> <i class="fas fa-chevron-right"></i> Trang chủ </a>
                <a href="#about"> <i class="fas fa-chevron-right"></i> Về chúng tôi </a>
                <a href="#services"> <i class="fas fa-chevron-right"></i> Dịch vụ </a>
                <a href="#doctors"> <i class="fas fa-chevron-right"></i> Bác sĩ </a>
                <a href="#appointment"> <i class="fas fa-chevron-right"></i> Đặt lịch hẹn </a>
                <a href="#review"> <i class="fas fa-chevron-right"></i> Đánh giá </a>
                <a href="#blogs"> <i class="fas fa-chevron-right"></i> Bài viết </a>
            </div>

            <div class="box">
                <h3>Dịch vụ</h3>
                <a href="#services"> <i class="fas fa-chevron-right"></i> Xét nghiệm mỡ máu </a>
                <a href="#services"> <i class="fas fa-chevron-right"></i> Chuẩn đoán sốt xuất huyết </a>
                <a href="#services"> <i class="fas fa-chevron-right"></i> Đặt xe cứu thương </a>
                <a href="#services"> <i class="fas fa-chevron-right"></i> Xét nghiệm toàn diện </a>
                <a href="#services"> <i class="fas fa-chevron-right"></i> Xét nghiệm gan chuyên sâu </a>
            </div>

            <div class="box">
                <h3>Thông tin đặt lịch</h3>
                <a href="#"> <i class="fas fa-phone"></i> 0854129229 </a>
                <a href="#"> <i class="fas fa-phone"></i> 0123456789 </a>
                <a href="#"> <i class="fas fa-envelope"></i> ngovannam10022003@gmail.com </a>
                <a href="#"> <i class="fas fa-envelope"></i> suguprovip@gmail.com </a>
                <a href="#"> <i class="fas fa-map-marker-alt"></i> Bắc Ninh, Việt Nam</a>
            </div>

            <div class="box">
                <h3>Theo dõi chúng tôi</h3>
                <a href="#"> <i class="fab fa-facebook"></i> facebook </a>
                <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
                <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
                <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
                <a href="#"> <i class="fab fa-pinterest"></i> pinterest </a>
            </div>

        </div>


    </section>

    <!-- footer section ends -->


    <!-- js file link  -->
    <script src="script.js"></script>
    <script>
        $(document).ready(function() {
            $('#tendichvu').on('change', function() {
                var tenDichVu = $(this).val(); // lấy giá trị từ ô input idbenhnhan truyền vào biến idBenhNhan

                $.ajax({
                    url: 'get_giatien_value.php', // Đường dẫn đến file xử lý Ajax
                    method: 'POST',
                    data: {
                        tenDichVu: tenDichVu
                    }, // biến idBenhNhan được sử dụng để gửi dữ liệu trong yêu cầu AJAX 
                    success: function(response) {
                        $('#giatien').val(response);
                    }
                });
            });
        });
    </script>
</body>

</html>