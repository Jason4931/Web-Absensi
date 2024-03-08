<?php
$sqlall = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]'";
$resultall = $conn->query($sqlall);
$hal = "";
$activeHal = 1;
if (isset($_GET["hal" . $activeHal])) {
    ${"hal" . $activeHal} = "active";
    $_SESSION["hal"] = "0,10";
} else {
    ${"hal" . $activeHal} = "active";
    $_SESSION["hal"] = "0,10";
}
for ($i = 2; $i <= 100; $i++) {
    if (isset($_GET["hal" . $i])) {
        ${"hal" . $i} = "active";
        $_SESSION["hal"] = ($i - 1) * 10 . ",10";
        $activeHal = $i;
        ${"hal1"} = "";
    } else {
        ${"hal" . $i} = "";
    }
}
if (isset($_GET["k"])) {
    $sql = "SELECT * FROM `terlambat` WHERE `Groupname`='$_SESSION[Groupname]'";
    $result = $conn->query($sql);
    $sql2 = "UPDATE `terlambat` SET `Waktu`='$_GET[terlambat]' WHERE `Groupname`='$_SESSION[Groupname]'";
    $result2 = $conn->query($sql2);
    if($result2){
        header('location: /Project Absensi/?menu=absensis');
    }
    else{
        echo "Request failed to send, please try again";
    }
}
if (isset($_GET["kp"])) {
    $sql = "SELECT * FROM `terlambat` WHERE `Groupname`='$_SESSION[Groupname]'";
    $result = $conn->query($sql);
    $sql2 = "UPDATE `terlambat` SET `Pulang`='$_GET[pulang]' WHERE `Groupname`='$_SESSION[Groupname]'";
    $result2 = $conn->query($sql2);
    if($result2){
        header('location: /Project Absensi/?menu=absensis');
    }
    else{
        echo "Request failed to send, please try again";
    }
}
$sqlT = "SELECT * FROM `terlambat` WHERE `Groupname`='$_SESSION[Groupname]'";
$resultT = $conn->query($sqlT);
if (mysqli_num_rows($resultT)==0){
    $sql2 = "INSERT INTO `terlambat` (`Groupname`, `Waktu`) VALUES ('$_SESSION[Groupname]', '')";
    $result2 = $conn->query($sql2);
    if($result2){
        header('location: /Project Absensi/?menu=absensis');
    }
    else{
        echo "Request failed to send, please try again";
    }
}
if (isset($_POST["absen"])) {
    if($_POST['waktu'] == ""){
        $_POST['waktu'] = date("H:i:s");
    }
    if($_POST['keterangan'] == ""){
        if (mysqli_num_rows($resultT)>0) {
            while($row = $resultT->fetch_assoc()) {
                if(strval($row["Waktu"]) == "00:00:00"){
                    $_POST['keterangan'] = "Hadir";
                }
                else if($_POST['waktu'] <= $row["Waktu"]){
                    $_POST['keterangan'] = "Hadir";
                }
                else if($_POST['waktu'] > $row["Waktu"]){
                    $_POST['keterangan'] = "Terlambat";
                }
            }
        }
    } else if(strtolower($_POST['keterangan']) == "h" || strtolower($_POST['keterangan']) == "hadir"){
        $_POST['keterangan'] = "Hadir";
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
    if($_POST['tanggal'] == ""){
        $_POST['tanggal'] = date("Y-m-d");
    }
    $sql = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]' AND `Nama`='$_POST[nama]' AND `Tanggal`='$_POST[tanggal]'";
    $result = $conn->query($sql);
    if(mysqli_num_rows($result)>0){
        if($_POST['keterangan']!="Pulang"){
            $_POST['keterangan'] = "Sudah Absen";
        }
    }
    $sqlakun = "SELECT * FROM `akunabsensi` WHERE `Groupname`='$_SESSION[Groupname]' AND `Nama`='$_POST[nama]'";
    $resultakun = $conn->query($sqlakun);
    $sqlT = "SELECT * FROM `terlambat` WHERE `Groupname`='$_SESSION[Groupname]'";
    $resultT = $conn->query($sqlT);
    if ($_POST['keterangan']!="Sudah Absen" && $_POST['keterangan']!="Bruh WDYM" && mysqli_num_rows($resultakun)>0 && $_POST['keterangan']!="Pulang"){
        while($rowT = $resultT->fetch_assoc()) {
            $sql2 = "INSERT INTO `absen` (`Groupname`, `Nama`, `Keterangan`, `Tanggal`, `WaktuDatang`, `Terlambat`) VALUES ('$_SESSION[Groupname]', '$_POST[nama]', '$_POST[keterangan]', '$_POST[tanggal]', '$_POST[waktu]', '$rowT[Waktu]')";
        }
    }
    else if($_POST['keterangan']=="Pulang") {
        if(mysqli_num_rows($result)>0){
            while($row = $resultT->fetch_assoc()) {
                $sql2 = "UPDATE `absen` SET `WaktuPulang`='$_POST[waktu]' WHERE `Groupname`='$_SESSION[Groupname]' AND `Nama`='$_POST[nama]'";
                if($_POST['waktu']<$row["Pulang"]){
                    $sql2 = "UPDATE `absen` SET `Keterangan`='Ijin' WHERE `Groupname`='$_SESSION[Groupname]' AND `Nama`='$_POST[nama]'";
                }
                $result2 = $conn->query($sql2);
                if($result2){
                    header('location: /Project Absensi/?menu=absensis');
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
    else if(mysqli_num_rows($resultakun)==0) {
        echo '<script>alert("Nama tersebut tidak ada dalam daftar akun!");</script>';
    }
    else if($_POST['keterangan']=="Sudah Absen"){
        echo '<script>alert("Nama tersebut sudah diabsen hari ini!");</script>';
    }
    if(!isset($sql2)){
        $sql2="SELECT * FROM `absen`";
    }
    $result2 = $conn->query($sql2);
    if($result2 && $_POST['keterangan']!="Bruh WDYM" && mysqli_num_rows($resultakun)>0 && $_POST['keterangan']!="Sudah Absen"){
        header('location: /Project Absensi/?menu=absensis');
    }
}
$date = date("Y-m-d");
$sqlabsen = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]' AND `Tanggal`='$date' LIMIT $_SESSION[hal]";
$resultabsen = $conn->query($sqlabsen);
if(isset($_GET['delete'])){
    $sql = "DELETE FROM `absen` WHERE `ID`='$_GET[delete]'";
    $result = $conn->query($sql);
    if ($result) {
    header("location: /Project Absensi/?menu=absensis");
    }
    else{
    header("location: /Project Absensi/?menu=absensis");
    }
  }
?>
<body>
  <?php include "Nav.php"; ?>
  <div class="card m-3">
    <div class="card-body m-3">
        <div style="color:#555566">
            <h2>Absensi <?=$_SESSION["Groupname"]?></h2>
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
        <form action="" method="get">
            <input hidden name="menu" value="absensis">
            <?php
            if (mysqli_num_rows($resultT)>0) {
                while($row = $resultT->fetch_assoc()) {
                    $batas = strval($row["Waktu"]);
                    $batas = $batas." ";
                    if($batas == "00:00:00 "){
                        $batas = "None ";
                    }
                    echo "Batas Jam Terlambat : "; ?><b><?php echo $batas; ?></b><?php
                    if(!isset($_GET['batas'])) {
                        echo "<a class='btn bg-success text-white btn-sm' href='/Project Absensi/?menu=absensis&batas'>Ganti</a>";
                    }
                    else if(isset($_GET['batas'])) { ?>
                        <input name="terlambat" type="time" class="form-control w-25" required>
                        <?php echo '<button class="btn bg-success text-white btn-sm" type="submit" name="k">Done</button>'; ?>
                        <label>12:00 AM = None</label>
                    <?php }
                }
            } ?>
            <div class="mt-1">
                <?php
                $sqlT = "SELECT * FROM `terlambat` WHERE `Groupname`='$_SESSION[Groupname]'";
                $resultT = $conn->query($sqlT);
                if (mysqli_num_rows($resultT)>0) {
                    while($row = $resultT->fetch_assoc()) {
                        $batasp = strval($row["Pulang"]);
                        $batasp = $batasp." ";
                        if($batasp == "00:00:00 "){
                            $batasp = "None ";
                        }
                        echo "Batas Jam Pulang : "; ?><b><?php echo $batasp; ?></b><?php
                        if(!isset($_GET['batasp'])) {
                            echo "<a class='btn bg-success text-white btn-sm' href='/Project Absensi/?menu=absensis&batasp'>Ganti</a>";
                        }
                        else if(isset($_GET['batasp'])) { ?>
                            <input name="pulang" type="time" class="form-control w-25" required>
                            <?php echo '<button class="btn bg-success text-white btn-sm" type="submit" name="kp">Done</button>'; ?>
                            <label>12:00 AM = None</label>
                        <?php }
                    }
                } ?>
            </div>
        </form>
        <form action="" method="post" class="row">
            <p style="color:orange" class="btn bg-warning-subtle mt-2">Keterangan 🡒 Hadir / Ijin / Sakit / Terlambat / Alpa / Pulang ⠀ (Kosong = Hadir / Terlambat)</p>
            <div class="col-lg-2 col-md-3 col-sm-12 col-12">
                <label class="form-label py-1"> Absen Nama: </label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                <input class="form-control" type="text" name="nama" placeholder="Nama" required>
            </div>
            <div class="col-lg-3 col-md-2 col-sm-6 col-12">
                <input class="form-control" type="text" name="keterangan" placeholder="Keterangan">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-6">
                <input class="form-control" type="date" name="tanggal" placeholder="Tanggal">
            </div>
            <div class="col-md-2 col-sm-3 col-6">
                <input class="form-control" type="time" name="waktu" placeholder="Waktu">
            </div>
            <div class="col-12 mt-2">
                <input class="btn bg-primary text-white w-100" type="submit" name="absen" value="Submit"><br>
            </div>
        </form><br>
        <?php
        if (mysqli_num_rows($resultabsen)>0) {
            while($row = $resultabsen->fetch_assoc()) {
                ?><div class="row mt-1">
                    <div class="col-lg-4 col-md-5 col-sm-6 col-5">
                    <?php echo $row["Nama"]." ".$row["Keterangan"]; ?>
                    </div>
                    <div class="col-4">
                    <?php
                    if($row["Keterangan"]=="Hadir"){
                        echo $row["WaktuDatang"]." <p style='color:darkblue'>".$row["WaktuPulang"]."</p>";
                    }else if($row["Keterangan"]=="Terlambat"){
                        $telats=floor((strtotime($row["WaktuDatang"])-strtotime($row["Terlambat"])))%60;
                        $telati=floor((strtotime($row["WaktuDatang"])-strtotime($row["Terlambat"]))/60)%60;
                        $telath=floor((strtotime($row["WaktuDatang"])-strtotime($row["Terlambat"]))/3600);
                        echo $row["WaktuDatang"]."<b style='color:red'> +".$telath.":".$telati.":".$telats."</b> <p style='color:darkblue'>".$row["WaktuPulang"]."</p>";
                    }
                    ?>
                    </div>
                    <div class="col-1">
                    <?php echo "<a class='btn btn-danger btn-sm' href='/Project Absensi/?menu=absensis&delete=".$row['ID']."'>Delete</a>"; ?>
                    </div>
                </div><?php
            }
        }
        if(mysqli_num_rows($resultall)>10) { ?>
            <div class="center mt-4">
                <div class="pagination">
                    <a href="/Project Absensi/?menu=absensis" class="<?=$hal1?>">1</a>
                    <a href="/Project Absensi/?menu=absensis&hal2" class="<?=$hal2?>">2</a>
                    <?php 
                    $max_pages = 100;
                    $links_per_page = 10;
                    for ($i = 3; $i <= $max_pages; $i++) {
                        $hal = "hal" . $i;
                        $condition = ($i - 1) * $links_per_page;
                        if (mysqli_num_rows($resultall) > $condition) {
                            echo '<a href="/Project Absensi/?menu=absensis&' . $hal . '" class="' . ${$hal} . '">' . $i . '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
  </div>
</body>
</html>