<body>
  <?php include "Nav.php"; ?>
  <div class="card m-3">
    <div class="card-body m-3">
      <h5 class="card-title" style="color:#0891C0">Web Absensi</h5>
      <p class="card-text" style="text-align: justify;">
        Selamat datang di platform absensi online yang efisien dan andal.<br>
        Pengelolaan absensi kini lebih mudah dengan fitur kami yang intuitif.<br>
        Lacak kehadiran, atur jadwal, dan analisis data dengan cepat.<br>
        Sederhana, efektif, dan tepat waktu!<br>
        <?php if($_SESSION['Akses']=="Supervisor") { ?><br>
        Absensi = Halaman Absensi Nama & Tanggal/Waktu + Fitur Delete<br>
        Akun = Halaman Tampilan Seluruh Akun Absensi + Fitur Tambah & Edit<br>
        Histori = Halaman Tampilan Seluruh Histori Absensi & Keterangan<br><br>

        <i>Tips : Hanya Input nama yang diharuskan, Input lain optional / tidak harus diisi</i><br>
        <i>⠀⠀⠀⠀ Anda boleh membuat akun lain untuk menambah grup absensi</i><br>
        <?php } ?>
      </p>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>