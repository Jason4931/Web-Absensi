<?php
if (isset($_POST["email"]) && isset($_POST["password"])) {
  $sql = "SELECT * FROM `akun` WHERE `Email`='$_POST[email]' AND `Password`='$_POST[password]'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  if (mysqli_num_rows($result)>0) {
    $_SESSION["Username"]=$row["Username"];
    $_SESSION["Akses"]=$row["Akses"];
    $_SESSION["ID"]=$row["ID"];
    if($_SESSION["Akses"]=="Supervisor"){
      $sql = "SELECT * FROM `grup` WHERE `Username`='$_SESSION[Username]'";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $_SESSION["Groupname"]=$row["Groupname"];
    }
    header('location: ./?menu=home');
  }
  else {
    echo '<script>alert("Email atau Password salah");</script>';
  }
}
?>
<body class="d-flex align-items-center py-4 bg-body-tertiary" style="overflow-x: hidden; background-image: url('./gambar/Bruh2.png'); background-repeat: no-repeat; background-size: cover;">
<main class="container-fluid w-100 m-auto">
  <div class="row">
    <div class="col-lg-3 col-md-2 col-sm-1 col-0"></div>
    <div class="col-lg-6 col-md-8 col-sm-10 col-12 ml-auto">
      <form method="post" class="card p-4 bg-body-secondary shadow-sm mx-4">

        <h1 class="h3 my-4 text-center">Log In</h1>
    
        <div>
          <input name="email" type="email" class="form-control my-2 py-2" placeholder="Email" required>
        </div>
        <div>
          <input name="password" type="password" class="form-control my-2 py-2" placeholder="Password" required>
        </div>
    
        <button class="btn bg-primary w-100 py-2 my-2 text-black" type="submit">Login</button>
        <div class="text-center mt-4">
          <label>Tidak punya akun?</label><br>
          <label><a href="./?register" style="text-decoration:none">Register</a></label>
        </div>
      </form>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-1 col-0"></div>
  </div>
</main>
</html>