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
$sql = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]' ORDER BY `Tanggal` DESC LIMIT $_SESSION[hal]";
if(isset($_GET['masuk'])) {
  $sql = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]' AND (`Keterangan`='Hadir' OR `Keterangan`='Terlambat') ORDER BY `Tanggal` DESC";
} else if(isset($_GET['tdkmasuk'])) {
  $sql = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]' AND (`Keterangan`='Ijin' OR `Keterangan`='Sakit' OR `Keterangan`='Alpa') ORDER BY `Tanggal` DESC";
} else if(isset($_GET['hadir'])) {
  $sql = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]' AND `Keterangan`='Hadir' ORDER BY `Tanggal` DESC";
} else if(isset($_GET['ijin'])) {
  $sql = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]' AND `Keterangan`='Ijin' ORDER BY `Tanggal` DESC";
} else if(isset($_GET['sakit'])) {
  $sql = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]' AND `Keterangan`='Sakit' ORDER BY `Tanggal` DESC";
} else if(isset($_GET['terlambat'])) {
  $sql = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]' AND `Keterangan`='Terlambat' ORDER BY `Tanggal` DESC";
} else if(isset($_GET['alpa'])) {
  $sql = "SELECT * FROM `absen` WHERE `Groupname`='$_SESSION[Groupname]' AND `Keterangan`='Alpa' ORDER BY `Tanggal` DESC";
}
$result = $conn->query($sql);
?>
<body>
  <?php include "Nav.php";?>
  <div class="card m-3">
    <div class="card-body m-3">
      <h4 class="card-title" style="color:#0891C0">Histori</h4>
      <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn">Filter</button>
        <div id="myDropdown" class="dropdown-content">
          <a href="/Project Absensi/?menu=historig">All</a>
          <a href="/Project Absensi/?menu=historig&masuk">Masuk</a>
          <a href="/Project Absensi/?menu=historig&tdkmasuk">Tdk Masuk</a>
          <a href="/Project Absensi/?menu=historig&hadir">Hadir</a>
          <a href="/Project Absensi/?menu=historig&ijin">Ijin</a>
          <a href="/Project Absensi/?menu=historig&sakit">Sakit</a>
          <a href="/Project Absensi/?menu=historig&terlambat">Terlambat</a>
          <a href="/Project Absensi/?menu=historig&alpa">Alpa</a>
        </div>
      </div>
      <hr><p class="card-text" style="text-align: justify;">
      <table border="1" style="text-align:center;" class="w-100">
        <tr style="background-color:gray">
          <th rowspan="2">Tanggal</th>
          <th rowspan="2">Nama</th>
          <th colspan="2" class="pt-1">Waktu</th>
          <th rowspan="2">Keterangan</th>
        </tr>
        <tr style="background-color:gray">
          <th class="pb-1">Datang</th>
          <th class="pb-1">Pulang</th>
        </tr>
        <?php $_SESSION["lg"]=0;
        if (mysqli_num_rows($result)>0) {
          while($row = $result->fetch_assoc()) {
            $_SESSION["lg"]++;
            if($_SESSION["lg"] % 2 == 0){
              $lg='style="background-color:#eeeeee"';
            }else{
              $lg="";
            }
            ?>
            <tr <?=$lg?>>
              <td class="pt-3 pb-3"><?=$row["Tanggal"]?></td>
              <td><?=$row["Nama"]?></td>
              <td class="pe-sm-0 pe-1"><?=$row["WaktuDatang"]?></td>
              <td class="ps-sm-0 ps-1"><?=$row["WaktuPulang"]?></td>
              <td><?=$row["Keterangan"]?></td>
            </tr>
            <?php
            // echo $row["Tanggal"]." ⠀ ".$row["WaktuDatang"]."-".$row["WaktuPulang"]." ⠀ ".$row["Nama"]." ".$row["Keterangan"]."<br>";
          }
        } ?>
      </table><?php
      if(mysqli_num_rows($resultall)>10 && !isset($_GET['masuk']) && !isset($_GET['tdkmasuk']) && !isset($_GET['hadir']) && !isset($_GET['ijin']) && !isset($_GET['sakit']) && !isset($_GET['terlambat']) && !isset($_GET['alpa'])) { ?>
        <div class="center mt-4">
            <div class="pagination">
                <a href="/Project Absensi/?menu=historig" class="<?=$hal1?>">1</a>
                <a href="/Project Absensi/?menu=historig&hal2" class="<?=$hal2?>">2</a>
                <?php 
                $max_pages = 100;
                $links_per_page = 10;
                for ($i = 3; $i <= $max_pages; $i++) {
                    $hal = "hal" . $i;
                    $condition = ($i - 1) * $links_per_page;
                    if (mysqli_num_rows($resultall) > $condition) {
                        echo '<a href="/Project Absensi/?menu=historig&' . $hal . '" class="' . ${$hal} . '">' . $i . '</a>';
                    }
                }
                ?>
            </div>
        </div>
      <?php } ?>
      </p>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>
</body>
</html>