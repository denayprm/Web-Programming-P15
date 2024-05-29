<?php
include("connection.php");

if (isset($_POST["submit"])) { // submit button clicked
    // receive data from form using $_POST
    $nim = htmlentities(strip_tags(trim($_POST["nim"])));
    $nama = htmlentities(strip_tags(trim($_POST["nama"])));
    $tempat_lahir = htmlentities(strip_tags(trim($_POST["tempat_lahir"])));
    $jenis_kelamin = isset($_POST["jenis_kelamin"]) ? htmlentities(strip_tags(trim($_POST["jenis_kelamin"]))) : '';
    $fakultas = htmlentities(strip_tags(trim($_POST["fakultas"])));
    $jurusan = htmlentities(strip_tags(trim($_POST["jurusan"])));
    $ipk = htmlentities(strip_tags(trim($_POST["ipk"])));
    $tanggal_lahir = htmlentities(strip_tags(trim($_POST["tanggal_lahir"])));

    $error_message = "";

    if (empty($nim)) {
        $error_message .= "<li>NIM belum diisi</li>";
    } elseif (!preg_match("/^[0-9]{7}$/", $nim)) {
        $error_message .= "<li>NIM harus berupa 7 digit angka</li>";
    }

    $nim = mysqli_real_escape_string($link, $nim);
    $query = "SELECT * FROM mahasiswa WHERE nim='$nim'";
    $result = mysqli_query($link, $query);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows >= 1) {
        $error_message .= "<li>NIM sudah terdaftar</li>";
    }

    if (empty($nama)) {
        $error_message .= "<li>Nama belum diisi</li>";
    }

    if (empty($tempat_lahir)) {
        $error_message .= "<li>Tempat lahir belum diisi</li>";
    }

    if (empty($tanggal_lahir)) {
        $error_message .= "<li>Tanggal lahir belum diisi</li>";
    }

    if (empty($jenis_kelamin)) {
        $error_message .= "<li>Jenis kelamin belum diisi</li>";
    }

    if (empty($fakultas)) {
        $error_message .= "<li>Fakultas belum diisi</li>";
    }

    if (empty($jurusan)) {
        $error_message .= "<li>Jurusan belum diisi</li>";
    }

    if (!is_numeric($ipk) OR ($ipk <= 0)) {
        $error_message .= "<li>IPK harus diisi dengan angka</li>";
    }

    if ($error_message === "") {
        $nim = mysqli_real_escape_string($link, $nim);
        $nama = mysqli_real_escape_string($link, $nama);
        $tempat_lahir = mysqli_real_escape_string($link, $tempat_lahir);
        $jenis_kelamin = mysqli_real_escape_string($link, $jenis_kelamin);
        $fakultas = mysqli_real_escape_string($link, $fakultas);
        $jurusan = mysqli_real_escape_string($link, $jurusan);
        $tanggal_lahir = mysqli_real_escape_string($link, $tanggal_lahir);
        $ipk = (float) $ipk;

        // make query to insert data to the table
        $query = "INSERT INTO mahasiswa (nim, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, fakultas, jurusan, ipk) VALUES ";
        $query .= "('$nim', '$nama', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$fakultas', '$jurusan', $ipk)";

        $result = mysqli_query($link, $query);

        if ($result) { // query success, redirect to main page
            $message = "Mahasiswa dengan nama \"<b>$nama</b>\" dan Nim \"<b>$nim</b>\" sudah berhasil ditambahkan";
            $message = urlencode($message);
            header("Location: index.php?message={$message}");
        } else {
            die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-5 border rounded bg-white py-4 px-5 mb-5">
        <header class="header-title mb-4">
            <h1>
                <a href="./index.php" style="text-decoration: none;">
                    <span class="fw-normal text-dark">Sistem Informasi</span>
                    <span class="text-primary">Mahasiswa</span>
                </a>
            </h1>
            <hr>
        </header>
        <section>
            <h2 class="mb-3">Tambah Data Mahasiswa</h2>
            <?php
            if (isset($error_message) && $error_message !== "") {
                echo "<div class=\"alert alert-danger mb-3\"><ul class=\"m-0\">$error_message</ul></div>";
            }
            ?>
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form">
                <div class="mb-3">
                    <label for="nim" class="form-label">Nim</label>
                    <input type="text" name="nim" id="nim" class="form-control" value="<?php echo (isset($nim)) ? $nim : ""; ?>" placeholder="Contoh: 1234567">
                    <span class="text-muted">(7 digit angka)</span>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo (isset($nama)) ? $nama : ""; ?>" placeholder="Masukkan Nama Kamu">
                </div>
                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="<?php echo (isset($tempat_lahir)) ? $tempat_lahir :""; ?>" placeholder="Masukkan Tempat Lahir">
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?php echo (isset($tanggal_lahir)) ? $tanggal_lahir : ""; ?>">
                </div>
                <div class="mb-3">
                    <div>
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="laki-laki" name="jenis_kelamin" value="Laki-laki" <?php echo (isset($jenis_kelamin) && $jenis_kelamin === "Laki-laki") ? "checked" : ""; ?>>
                        <label class="form-check-label" for="laki-laki">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="jenis_kelamin" name="jenis_kelamin" value="Perempuan" <?php echo (isset($jenis_kelamin) && $jenis_kelamin === "Perempuan") ? "checked" : ""; ?>>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="fakultas" class="form-label">Fakultas</label>
                    <select name="fakultas" id="fakultas" class="form-select">
                        <option value="">Pilih Fakultas</option>
                        <?php
                        $faculties = ["FIP", "FPIPS", "FPBS", "FPSD", "FPMIPA", "FPTK", "FPEB"];
                        foreach ($faculties as $faculty) {
                            if (isset($fakultas) && $fakultas === $faculty) {
                                echo "<option value=\"$faculty\" selected>$faculty</option>";
                            } else {
                                echo "<option value=\"$faculty\">$faculty</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" class="form-control" value="<?php echo (isset($jurusan)) ? $jurusan : ""; ?>" placeholder="Masukkan Jurusan">
                </div>
                <div class="mb-3">
                    <label for="ipk">IPK</label>
                    <input type="text" name="ipk" id="ipk" class="form-select" value="<?php echo (isset($ipk)) ? $ipk : ""; ?>" placeholder="Contoh: 3.85">
                    <span class="text-muted">(angka desimal dipisah dengan karakter titik ".")</span>
                </div>
                <br>
                <div class="mb-3">
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                </div>
            </form>
        </section>
        <?php
        mysqli_close($link);
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
