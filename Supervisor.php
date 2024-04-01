<?php
if(isset($_GET['create'])){
  $sql = "SELECT * FROM `grup` WHERE `Groupname`='$_GET[group]'";
  $result = $conn->query($sql);
  if(mysqli_num_rows($result)==0) {
    $sql = "UPDATE `akun` SET `Akses`='Supervisor' WHERE `Username`='$_SESSION[Username]'";
    $result = $conn->query($sql);
    $sql2 = "INSERT INTO `grup` (`Username`,`Groupname`) VALUES ('$_SESSION[Username]','$_GET[group]')";
    $result2 = $conn->query($sql2);
    if ($result && $result2) {
      sleep(3);
      header("location: ./?logout");
    }
    else{
      echo "Request failed to send, please try again";
    }
  } else {
    echo "Nama grup tersebut sudah dipakai!<br>Silahkan pakai yang lain!";
  }
}
?>
<body>
  <?php include "Nav.php"; ?>
  <div class="card m-3">
    <div class="card-body m-3">
      <form action="" method="get">
        <input hidden name="menu" value="supervisor">
        <h5 class="card-title" style="color:#0891C0">Nama Grup Anda :</h5>
        <p><i>Setelah dibuat, Nama grup tidak bisa diubah</i></p>
        <input name="group" type="text" class="form-control py-2 border-warning w-75" maxlength="50" required>
        <input class="btn bg-primary text-white btn-sm mt-1 p-2" type="submit" name="create" value="Create">
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>