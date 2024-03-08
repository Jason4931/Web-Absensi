<?php
if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {
  $sql = "SELECT * FROM `akun` WHERE `Username`='$_POST[username]' OR `Email`='$_POST[email]'";
  $result = $conn->query($sql);
  if(mysqli_num_rows($result)==0){
    $sql2 = "INSERT INTO `akun` (`Username`, `Email`, `Password`) VALUES ('$_POST[username]', '$_POST[email]', '$_POST[password]')";
    $result2 = $conn->query($sql2);
    if($result2){
      header('location: /Project Absensi/?login');
    }
    else{
      echo '<script>alert("Request failed to send, please try again");</script>';
    }
  }
  else{
    echo '<script>alert("Nama/Email sudah dipakai, silahkan menggunakan yang lain");</script>';
  }
}
?>
<body class="d-flex align-items-center py-4 bg-body-tertiary" style="overflow-x: hidden; background-image: url('./gambar/Bruh2.png'); background-repeat: no-repeat; background-size: cover;">
<main class="container-fluid w-100 m-auto">
  <div class="row">
    <div class="col-lg-3 col-md-2 col-sm-1 col-0"></div>
    <div class="col-lg-6 col-md-8 col-sm-10 col-12 ml-auto">
      <form method="post" class="card p-4 bg-body-secondary shadow-sm mx-4">

        <h1 class="h3 my-4 text-center">Register</h1>
        
        <div>
          <input name="username" type="text" class="form-control my-2 py-2" placeholder="Username" required>
        </div>
        <div>
          <input name="email" type="email" class="form-control my-2 py-2" placeholder="Email" required>
        </div>
        <div>
          <input name="password" type="password" class="form-control my-2 py-2" placeholder="Password" required>
        </div>
    
        <button class="btn bg-primary w-100 py-2 my-2 text-black" type="submit">Register</button>
        <div class="text-center mt-4">
          <label>Sudah punya akun?</label><br>
          <label><a href="/Project Absensi/?login" style="text-decoration:none">Login</a></label>
        </div>
      </form>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-1 col-0"></div>
  </div>
</main>
</html>