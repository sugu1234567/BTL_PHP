<?php
    $connect = mysqli_connect('localhost','root','', 'id21676063_btlphp'); 
    if(!$connect){
        die("Không kết nối: ".mysqli_connect_error()); 
        exit();
    }
?>