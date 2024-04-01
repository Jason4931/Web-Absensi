<?php
$home="";
$absensis="";
$absensiu="";
$akun="";
$historig="";
$historiu="";
$supervisor="";
if($_SESSION["Active"] == "home"){
  $home="active";
}
else if($_SESSION["Active"] == "absensis"){
  $absensis="active";
}
else if($_SESSION["Active"] == "absensiu"){
  $absensiu="active";
}
else if($_SESSION["Active"] == "akun"){
  $akun="active";
}
else if($_SESSION["Active"] == "historig"){
  $historig="active";
}
else if($_SESSION["Active"] == "historiu"){
  $historiu="active";
}
else if($_SESSION["Active"] == "supervisor"){
  $supervisor="active";
}
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">
            <a class="nav-link <?=$home?>" href="./?menu=home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?=$absensiu?>" href="./?menu=absensiu">Absensi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?=$historiu?>" href="./?menu=historiu">Histori</a>
          </li>
          <?php if($_SESSION['Akses']=="Supervisor") {?>
          <li class="nav-item ms-lg-4">
            <a class="nav-link <?=$absensis?> ms-lg-4 me-lg-0 me-4 btn bg-warning-subtle" href="./?menu=absensis">Absensi <?=$_SESSION["Groupname"]?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?=$akun?>" href="./?menu=akun">Akun</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?=$historig?>" href="./?menu=historig">Histori</a>
          </li>
          <?php } if($_SESSION['Akses']=="User") {?>
          <li class="nav-item ms-lg-4">
            <a class="nav-link btn bg-warning-subtle ms-lg-4 me-lg-0 me-4 <?=$supervisor?>" href="./?menu=supervisor">Apply Supervisor</a>
          </li>
          <?php } ?>
        </ul>
        <div class="d-flex">
          <span class="mx-2 text-end"><a href="#" style="text-decoration:none"><?=$_SESSION["Username"]?></a><a href="./?logout" class="nav-link">Logout</a></span>
        </div>
      </div>
    </div>
</nav>