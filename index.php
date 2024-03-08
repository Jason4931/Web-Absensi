<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "absensi";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    };
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    };
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cantarell&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: "Cantarell";
    }
    .dropbtn {
        border-radius: 10px;
        background-color: #0dcaf0;
        color: white;
        padding-top: 8px;
        padding-bottom: 8px;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }
    .dropbtn:hover, .dropbtn:focus {
        background-color: #00bae0;
    }
    .dropdown {
        position: relative;
        display: inline-block;
    }
    .dropdown-content {
        border-radius: 10px;
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 120px;
        overflow: auto;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    .dropdown-content a {
        color: black;
        padding: 9px 12px;
        text-decoration: none;
        display: block;
    }
    .dropdown a:hover {background-color: #ddd;}
    .show {display: block;}
    .center {
        text-align: center;
    }
    .pagination {
        display: inline-block;
    }
    .pagination a {
        border-radius: 8px;
        color: black;
        float: left;
        padding: 4px 12px;
        text-decoration: none;
        transition: background-color .3s;
        border: 2px solid #ddd;
        margin: 0 3px;
    }
    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        border: 2px solid #4CAF50;
    }
    .pagination a:hover:not(.active) {background-color: #ddd;}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<?php
date_default_timezone_set('Asia/Jakarta');
if(!isset($_SESSION['ID'])) {
    if(isset($_GET['register'])){
        $title="Register - Absensi";
        include "register.php";
    }
    else {
        $title="Login - Absensi";
        include "login.php";
    }
}
else if(isset($_GET['logout'])){
    include "logout.php";
}
else{
    if(!isset($_GET['menu'])){
        $_GET['menu']=null;
    }
    switch ($_GET['menu']) {
        case "absensis":
            $title="Absensi - Absensi";
            $_SESSION["Active"]="absensis";
            include "absensis.php";
            break;
        case "absensiu":
            $title="Absensi - Absensi";
            $_SESSION["Active"]="absensiu";
            include "absensiu.php";
            break;
        case "akun":
            $title="Akun - Absensi";
            $_SESSION["Active"]="akun";
            include "akun.php";
            break;
        case "historiu":
            $title="Histori - Absensi";
            $_SESSION["Active"]="historiu";
            include "historiu.php";
            break;
        case "historig":
            $title="Histori - Absensi";
            $_SESSION["Active"]="historig";
            include "historig.php";
            break;
        case "supervisor":
            $title="Supervisor - Absensi";
            $_SESSION["Active"]="supervisor";
            include "supervisor.php";
            break;
        default:
            $title="Home - Absensi";
            $_SESSION["Active"]="home";
            include "home.php";
            break;
    }
}
?><title><?=$title?></title>
</html>