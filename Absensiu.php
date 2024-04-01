<?php
if(isset($_GET['absen'])) {
    $sql = "SELECT * FROM `akunabsensi` WHERE `Groupname`='$_GET[absen]'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result)>0) {
        while($row = $result->fetch_assoc()) {
            $_SESSION["Group"]=$row["Groupname"];
        }
    }
    $sqlT = "SELECT * FROM `terlambat` WHERE `Groupname`='$_SESSION[Group]'";
    $resultT = $conn->query($sqlT);
    if(isset($_POST['absensi'])) {
        if($_POST['keterangan'] == ""){
            if (mysqli_num_rows($resultT)>0) {
                while($row = $resultT->fetch_assoc()) {
                    if(strval($row["Waktu"]) == "00:00:00"){
                        $_POST['keterangan'] = "Hadir";
                    }
                    else if(date("H:i:s") <= $row["Waktu"]){
                        $_POST['keterangan'] = "Hadir";
                    }
                    else if(date("H:i:s") > $row["Waktu"]){
                        $_POST['keterangan'] = "Terlambat";
                    }
                }
            }
        } else if(strtolower($_POST['keterangan']) == "h" || strtolower($_POST['keterangan']) == "hadir"){
            $_POST['keterangan'] = "hadir";
        } else if(strtolower($_POST['keterangan']) == "i" || strtolower($_POST['keterangan']) == "ijin"){
            $_POST['keterangan'] = "Ijin";
        } else if(strtolower($_POST['keterangan']) == "s" || strtolower($_POST['keterangan']) == "sakit"){
            $_POST['keterangan'] = "Sakit";
        } else if(strtolower($_POST['keterangan']) == "t" || strtolower($_POST['keterangan']) == "terlambat"){
            $_POST['keterangan'] = "Terlambat";
        } else if(strtolower($_POST['keterangan']) == "a" || strtolower($_POST['keterangan']) == "alpa"){
            $_POST['keterangan'] = "Alpa";
        } else if(strtolower($_POST['keterangan']) == "p" || strtolower($_POST['keterangan']) == "pulang"){
            $_POST['keterangan'] = "Pulang";
        } else{
            $_POST['keterangan'] = "Bruh WDYM";
        }
        $tanggal = date("Y-m-d");
        $sql = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Group]' AND `Nama`='$_SESSION[Username]' AND `Tanggal`='$tanggal'";
        $result = $conn->query($sql);
        if(mysqli_num_rows($result)>0){
            if($_POST['keterangan']!="Pulang"){
                $_POST['keterangan'] = "Sudah Absen";
            }
        }
        $waktu=date("H:i:s");
        $sqlT = "SELECT * FROM `terlambat` WHERE `Groupname`='$_SESSION[Groupname]'";
        $resultT = $conn->query($sqlT);
        if ($_POST['keterangan']!="Sudah Absen" && $_POST['keterangan']!="Bruh WDYM" && $_POST['keterangan']!="hadir" && $_POST['keterangan']!="Pulang"){
            while($rowT = $resultT->fetch_assoc()) {
                $sql2 = "INSERT INTO `absen` (`Groupname`, `Nama`, `Keterangan`, `Tanggal`, `WaktuDatang`, `Terlambat`) VALUES ('$_SESSION[Group]', '$_SESSION[Username]', '$_POST[keterangan]', '$tanggal', '$waktu', '$rowT[Waktu]')";
            }
        }
        else if($_POST['keterangan']=="Pulang") {
            if(mysqli_num_rows($result)>0){
                while($row = $resultT->fetch_assoc()) {
                    $sql2 = "UPDATE `absen` SET `WaktuPulang`='$waktu' WHERE `Groupname`='$_SESSION[Groupname]' AND `Nama`='$_SESSION[Username]'";
                    if($waktu<$row["Pulang"]){
                        $sql2 = "UPDATE `absen` SET `Keterangan`='Ijin' WHERE `Groupname`='$_SESSION[Groupname]' AND `Nama`='$_SESSION[Username]'";
                    }
                    $result2 = $conn->query($sql2);
                    if($result2){
                        header('location: ./?menu=absensiu');
                    }
                    else{
                        echo "Request failed to send, please try again";
                    }
                }
            }
        }
        else if($_POST['keterangan']=="Bruh WDYM") {
            echo '<script>alert("Keterangan kurang jelas, mohon absen lagi!");</script>';
        }
        else if($_POST['keterangan']=="hadir") {
            echo '<script>alert("Anda tidak boleh mengisi keterangan dengan Hadir!");</script>';
        }
        else if($_POST['keterangan']=="Sudah Absen"){
            echo '<script>alert("Anda sudah terabsen hari ini!");</script>';
        }
        if(!isset($sql2)){
            $sql2="SELECT * FROM `absen`";
        }
        $result2 = $conn->query($sql2);
        if($result2 && $_POST['keterangan']!="Bruh WDYM" && $_POST['keterangan']!="Hadir" && $_POST['keterangan']!="Sudah Absen"){
            header("location: ./?menu=absensiu&absen=$_SESSION[Group]");
        }
    }
    $date = date("Y-m-d");
    $sqlabsen = "SELECT * FROM `absen` WHERE `Nama`='$_SESSION[Username]' AND `Tanggal`='$date'";
    $resultabsen = $conn->query($sqlabsen);
}
if(isset($_GET['keluar'])) {
    $sql = "DELETE FROM `akunabsensi` WHERE `ID`='$_GET[keluar]'";
    $result = $conn->query($sql);
    if ($result) {
        header("location: ./?menu=absensiu");
    }
    else{
        header("location: ./?menu=absensiu");
    }
}
?>
<body>
  <?php include "Nav.php"; ?>
  <div class="card m-3">
    <div class="card-body m-3">
        <div style="color:#555566">
            <?php if(!isset($_GET['absen'])) { ?>
                <h2>Absensi</h2>
            <?php } else if(isset($_GET['absen'])) { ?>
                <h2>Absensi <?=$_SESSION["Group"]?></h2>
            <?php } ?>
            <b><?php if(date("l") == "Sunday") {
                echo "Minggu ";
            } else if(date("l") == "Monday") {
                echo "Senin ";
            } else if(date("l") == "Tuesday") {
                echo "Selasa ";
            } else if(date("l") == "Wednesday") {
                echo "Rabu ";
            } else if(date("l") == "Thursday") {
                echo "Kamis ";
            } else if(date("l") == "Friday") {
                echo "Jumat ";
            } else if(date("l") == "Saturday") {
                echo "Sabtu ";
            } ?></b><?php
            echo date("j F Y / h:i A"); ?>
        </div><hr>
        <?php if(isset($_GET['absen'])) { ?>
            <?php
            if (mysqli_num_rows($resultT)>0) {
                while($row = $resultT->fetch_assoc()) {
                    $batas = strval($row["Waktu"]);
                    $batas = $batas." ";
                    if($batas == "00:00:00 "){
                        $batas = "None ";
                    }
                    echo "Batas Jam Terlambat : "; ?><b><?php echo $batas; ?></b><?php
                }
            } ?>
            <div class="mt-1">
                <?php
                $sqlT = "SELECT * FROM `terlambat` WHERE `Groupname`='$_SESSION[Group]'";
                $resultT = $conn->query($sqlT);
                if (mysqli_num_rows($resultT)>0) {
                    while($row = $resultT->fetch_assoc()) {
                        $batasp = strval($row["Pulang"]);
                        $batasp = $batasp." ";
                        if($batasp == "00:00:00 "){
                            $batasp = "None ";
                        }
                        echo "Batas Jam Pulang : "; ?><b><?php echo $batasp; ?></b><?php
                    }
                } ?>
            </div>
            <form action="" method="post" class="row">
                <input hidden name="menu" value="absensiu">
                <p style="color:orange" class="btn bg-warning-subtle mt-2">Keterangan 🡒 Ijin / Sakit / Terlambat / Alpa / Pulang ⠀ (Kosong = Hadir / Terlambat)</p>
                <div class="col-lg-2 col-md-3 col-sm-12 col-12">
                    <label class="form-label py-1"> Absen Nama: </label>
                </div>
                <div class="col-lg-5 col-md-4 col-sm-5 col-12">
                    <input class="form-control" type="text" name="nama" placeholder="Nama" value="<?=$_SESSION['Username']?>" disabled>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-7 col-12">
                    <input class="form-control" type="text" name="keterangan" placeholder="Keterangan">
                </div>
                <div class="col-12 mt-2">
                    <input class="btn bg-primary text-white w-100" type="submit" name="absensi" value="Submit"><br>
                </div>
            </form><br>
        <?php
        if (mysqli_num_rows($resultabsen)>0) {
            while($row = $resultabsen->fetch_assoc()) {
                ?><div class="row mt-1">
                    <div class="col-12">
                    <?php echo $row["Nama"]." ".$row["Keterangan"]; ?>
                    </div>
                </div><?php
            }
        }
        } if(!isset($_GET['absen'])) { ?>
            <form action="" method="get">
                <input hidden name="menu" value="absensiu">
                <?php
                echo "Daftar Grup :<br>";
                $sql = "SELECT * FROM `akun` WHERE `Username`='$_SESSION[Username]'";
                $result = $conn->query($sql);
                if (mysqli_num_rows($result)>0) {
                    while($row = $result->fetch_assoc()) {
                        $sql2 = "SELECT * FROM `akunabsensi` WHERE `Nama`='$_SESSION[Username]' AND `Email`='$row[Email]'";
                        $result2 = $conn->query($sql2);
                        if (mysqli_num_rows($result2)>0) {
                            while($row2 = $result2->fetch_assoc()) { ?>
                                <div class="row">
                                    <div class="col-8">
                                        <input class="btn bg-primary text-white mt-1" type="submit" name="absen" value="<?=$row2["Groupname"]?>">
                                    </div>
                                    <div class="col-4 text-end">
                                        <a class="btn bg-danger text-white mt-1" href="/Project Absensi/?menu=absensiu&keluar=<?=$row2["ID"]?>">Keluar</a>
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                }
                ?>
            </form>
        <?php } ?>
    </div>
  </div>
</body>
</html>