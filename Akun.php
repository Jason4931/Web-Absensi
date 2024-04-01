<?php
$search = "";
$sqlall = "SELECT * FROM `akunabsensi` WHERE `Groupname`='$_SESSION[Groupname]'";
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
$sql = "SELECT * FROM `akunabsensi` WHERE `Groupname`='$_SESSION[Groupname]' LIMIT $_SESSION[hal]";
$result = $conn->query($sql);
if(isset($_GET['delete'])){
    $sql = "DELETE FROM `akunabsensi` WHERE `ID`='$_GET[delete]'";
    $result = $conn->query($sql);
    if ($result) {
    header("location: ./?menu=akun");
    }
    else{
    header("location: ./?menu=akun");
    }
}
if(isset($_POST['edit'])){
    $sql = "UPDATE `akunabsensi` SET `Nama`='$_POST[nama]',`Kelamin`='$_POST[kelamin]',`Alamat`='$_POST[alamat]',`TglLahir`='$_POST[tgllahir]',`Email`='$_POST[email]',`NoHP`='$_POST[nohp]',`Keterangan`='$_POST[keterangan]' WHERE `ID`='$_GET[edit]'";
    $result = $conn->query($sql);
    if ($result) {
    header("location: ./?menu=akun");
    }
    else{
    header("location: ./?menu=akun");
    }
}
if(isset($_GET['tambah'])){
    $sql2 = "INSERT INTO `akunabsensi` (`Groupname`,`Nama`,`Kelamin`,`Alamat`,`TglLahir`,`Email`,`NoHP`,`Keterangan`) VALUES ('$_SESSION[Groupname]','$_GET[nama]','$_GET[kelamin]','$_GET[alamat]','$_GET[tgllahir]','$_GET[email]','$_GET[nohp]','$_GET[keterangan]')";
    $result2 = $conn->query($sql2);
    if ($result2) {
    header("location: ./?menu=akun");
    }
    else{
        echo "Request failed to send, please try again";
    }
}
if(isset($_GET['inputsearch'])){
    $sql = "SELECT * FROM `akunabsensi` WHERE `Groupname`='$_SESSION[Groupname]' AND `Nama`='$_GET[inputsearch]'";
    $result = $conn->query($sql);
    $search = "searching";
}
?>
<body>
<?php include "Nav.php"; ?>
<div class="card m-3 border-0">
    <div class="card-body m-3">
        <div class="row">
            <div class="col-12 rounded-3" style="text-align:center; background-color:#F9F9F9">
                <h2>Akun</h2>
            </div>
            <div class="col-12">
                <div style="font-size:20px" class="card bg-body-secondary shadow-sm p-4 m-1">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-6 col-7">
                                <input hidden name="menu" value="akun">
                                <input class="form-control" type="text" name="inputsearch" placeholder="Nama">
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-3 col-5">
                                <input class="btn bg-primary text-white btn-sm w-100" type="submit" name="search" value="Search">
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-3 col-12 mt-sm-0 mt-1">
                                <?php
                                if(!isset($_GET['add'])) {
                                    echo "<a class='btn bg-success text-white btn-sm w-100' href='/Project Absensi/?menu=akun&add'>Tambah</a>";
                                }
                                else if(isset($_GET['add'])) {
                                    echo '<button class="btn bg-success text-white btn-sm w-100" type="submit" name="tambah">Done</button>';
                                } ?>
                            </div>
                        </div>
                        <?php if(isset($_GET['add'])) { ?>
                        <hr><div class="row">
                            <div class="col-lg-4 col-md-5 col-sm-6">
                                Nama :
                            </div>
                            <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                <input name="nama" type="text" class="form-control py-2 border-warning" required>
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-6">
                                Kelamin :
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-3 mb-1">
                                <div class="form-control py-2 border-warning">
                                    <input name="kelamin" type="radio" class="py-2" value="Laki" id="laki">
                                    <label for="laki">Laki</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-3 mb-1">
                                <div class="form-control py-2 border-warning">
                                    <input name="kelamin" type="radio" class="py-2" value="Perempuan" id="perempuan">
                                    <label for="perempuan">Perempuan</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-6">
                                Alamat :
                            </div>
                            <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                <input name="alamat" type="text" class="form-control py-2 border-warning">
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-6">
                                Tanggal Lahir :
                            </div>
                            <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                <input name="tgllahir" type="date" class="form-control py-2 border-warning">
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-6">
                                Email :
                            </div>
                            <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                <input name="email" type="text" class="form-control py-2 border-warning">
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-6">
                                Nomor HP :
                            </div>
                            <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                <input name="nohp" type="text" class="form-control py-2 border-warning">
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-6">
                                Keterangan :
                            </div>
                            <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                <textarea class="form-control py-2 border-warning" name="keterangan" rows="3" cols="50"></textarea>
                            </div>
                        </div>
                        <?php } ?>
                    </form>
                    <br>
                    <?php
                    if (mysqli_num_rows($result)>0) {
                    while($row = $result->fetch_assoc()) {
                        ?><form method="post">
                        <div class="row">
                            <?php
                            if(!isset($_GET['add'])){ 
                                if((isset($_GET['edit']) && $row['ID']==$_GET['edit']) || !isset($_GET['edit'])) { ?>
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <b><?php echo $row["Nama"] ?></b><?php if($row["Email"]!=""){ echo " (".$row["Email"].")<br>"; }else{ echo "<br>"; } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-6 text-end">
                                    <?php
                                    if(!isset($_GET['edit'])) {
                                        echo "<a class='btn btn-secondary btn-sm w-100' href='/Project Absensi/?menu=akun&edit=".$row['ID']."'>Edit</a>";
                                    }
                                    else if(isset($_GET['edit'])) {
                                        echo '<button class="btn btn-secondary btn-sm w-100" type="submit" name="edit">Done</button>';
                                    }
                                    ?>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-6">
                                    <?php echo "<a class='btn btn-danger btn-sm w-100' href='/Project Absensi/?menu=akun&delete=".$row['ID']."'>Remove</a>"; ?>
                                </div>
                                <?php }
                                if(isset($_GET['edit']) && $row['ID']==$_GET['edit']) { ?>
                                    <hr class="mt-2">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-5 col-sm-6">
                                            Nama :
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                            <input name="nama" type="text" class="form-control py-2 border-warning" value="<?php echo $row["Nama"] ?>" required>
                                        </div>
                                        <div class="col-lg-4 col-md-5 col-sm-6">
                                            Kelamin :
                                            <?php
                                                $laki="";
                                                $perempuan="";
                                                if($row["Kelamin"]=="Laki") {
                                                    $laki="checked";
                                                } else if($row["Kelamin"]=="Perempuan") {
                                                    $perempuan="checked";
                                                }
                                            ?>
                                        </div>
                                        <div class="col-lg-4 col-md-3 col-sm-3 mb-1">
                                            <div class="form-control py-2 border-warning">
                                                <input name="kelamin" type="radio" class="py-2" value="Laki" id="laki" <?=$laki?>>
                                                <label for="laki">Laki</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-3 mb-1">
                                            <div class="form-control py-2 border-warning">
                                                <input name="kelamin" type="radio" class="py-2" value="Perempuan" id="perempuan" <?=$perempuan?>>
                                                <label for="perempuan">Perempuan</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-5 col-sm-6">
                                            Alamat :
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                            <input name="alamat" type="text" class="form-control py-2 border-warning" value="<?php echo $row["Alamat"] ?>">
                                        </div>
                                        <div class="col-lg-4 col-md-5 col-sm-6">
                                            Tanggal Lahir :
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                            <input name="tgllahir" type="date" class="form-control py-2 border-warning" value="<?php echo $row["TglLahir"] ?>">
                                        </div>
                                        <div class="col-lg-4 col-md-5 col-sm-6">
                                            Email :
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                            <input name="email" type="text" class="form-control py-2 border-warning" value="<?php echo $row["Email"] ?>">
                                        </div>
                                        <div class="col-lg-4 col-md-5 col-sm-6">
                                            Nomor HP :
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                            <input name="nohp" type="text" class="form-control py-2 border-warning" value="<?php echo $row["NoHP"] ?>">
                                        </div>
                                        <div class="col-lg-4 col-md-5 col-sm-6">
                                            Keterangan :
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-6 mb-1">
                                            <textarea class="form-control py-2 border-warning" name="keterangan" rows="3" cols="50"><?php echo $row["Keterangan"] ?></textarea>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </form>
                    <?php }
                    }
                    else{
                        if($search == "searching") {
                            echo "Data tidak ditemukan";
                        } else {
                            echo "Tidak ada akun";
                        }
                    }
                    if(mysqli_num_rows($resultall)>10) { ?>
                        <div class="center mt-4">
                            <div class="pagination">
                                <a href="/Project Absensi/?menu=akun" class="<?=$hal1?>">1</a>
                                <a href="/Project Absensi/?menu=akun&hal2" class="<?=$hal2?>">2</a>
                                <?php 
                                $max_pages = 100;
                                $links_per_page = 10;
                                for ($i = 3; $i <= $max_pages; $i++) {
                                    $hal = "hal" . $i;
                                    $condition = ($i - 1) * $links_per_page;
                                    if (mysqli_num_rows($resultall) > $condition) {
                                        echo '<a href="/Project Absensi/?menu=akun&' . $hal . '" class="' . ${$hal} . '">' . $i . '</a>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>