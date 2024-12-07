
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvHux31Lkhxg42LY60f8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min-js"></script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head> 
<body>
    <nav class="navbar navbar-expand-lg navbar-info bg-info">
        <h5 class="text-white"><a href="../index.php" style="text-decoration: none; color: white;"> Healthy Service</a></h5>
        <div class="mr-auto"></div>
        <ul class="navbar-nav">
                
                <li class="nav-item"><a href="" class="nav-link text-white"><?php echo $_SESSION['staff'] ?></a></li>
                <li class="nav-item"><a href="logoutdoctor.php" class="nav-link text-white">Đăng xuất</a></li>
        </ul>
    </nav>
</body>
</html>