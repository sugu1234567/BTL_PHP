<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>ID Bệnh nhân</label>
            <input type="text" name="idthunhap" class="form-control">
        </div>
        <div class="form-group">
            <label>Tên bệnh nhân</label>
            <input type="text" name="idbenhnhan" class="form-control">
        </div>
        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="benhnhan" class="form-control">
        </div>
        <div class="form-group">
            <label>Ngày sinh</label>
            <input type="text" name="benhnhan" class="form-control">
        </div>
        <div class="form-group">
            <label>Giới tính</label>
            <input type="text" name="benhnhan" class="form-control">
        </div>
        <div class="form-group">
            <label>Địa chỉ</label>
            <input type="text" name="benhnhan" class="form-control">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="benhnhan" class="form-control">
        </div>
        <div class="form-group">
            <label>Ngày đăng kí</label>
            <input type="text" name="benhnhan" class="form-control">
        </div>
        <input type="submit" name="add" value="Thêm Mới" class="btn btn-success">
    </form>
</body>
</html>