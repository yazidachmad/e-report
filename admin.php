<?php
session_start();

include "db.php";

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
} else {
    $user = $_SESSION['user'];
    if ($user['role'] == "basic") {
        header("Location: index.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

}
// Konfigurasi database
$host = "localhost";
$user = "root"; // Ganti sesuai username database Anda
$password = ""; // Ganti sesuai password database Anda
$database = "final_project";

// Koneksi ke database
$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Periksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pengaduan = $conn->real_escape_string($_POST['nama_pengaduan']);
    $isi_pengaduan = $conn->real_escape_string($_POST['isi_pengaduan']);

    // Validasi input
    if (empty($nama_pengaduan) || empty($isi_pengaduan)) {
        echo "Nama pengaduan dan isi pengaduan wajib diisi.";
    } else {
        // Query untuk menyimpan data
        $sql = "INSERT INTO pengaduan (nama_pengaduan, isi_pengaduan) VALUES ('$nama_pengaduan', '$isi_pengaduan')";

        if ($conn->query($sql) === TRUE) {
            echo "Pengaduan berhasil disimpan.";
        } else {
            echo "Terjadi kesalahan: " . $conn->error;
        }
    }
}

// Tutup koneksi
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pengaduan masyarakat</title>
    <link rel="stylesheet" href="style_user.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            resize: vertical;
        }

        textarea:focus {
            outline: none;
            border-color: #009879;
            box-shadow: 0 0 5px rgba(0, 152, 121, 0.5);
        }

        .form-header {
            font-size: 18px;
            font-weight: bold;
            color: #009879;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <form action="admin.php" method="POST">
    <div class="form-group">
        <label for="nama-pengaduan">Nama Pengaduan:</label>
        <textarea id="nama-pengaduan" name="nama_pengaduan" rows="2" placeholder="Masukkan nama anda..." required></textarea>
    </div>
    <div class="form-group">
        <label for="isi-pengaduan">Isi Pengaduan:</label>
        <textarea id="isi-pengaduan" name="isi_pengaduan" rows="4" placeholder="Masukkan isi pengaduan..." required></textarea>
    </div>
    <button type="submit" style="padding: 10px 20px; background-color: #009879; color: white; border: none; border-radius: 5px;">Kirim Pengaduan</button>
</form>
</body>
</html>




