<?php
session_start();
include ('db.php');

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

var_dump($_SESSION['user']['role']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pengaduan masyarakat</title>
    <link rel="stylesheet" href="style_user.css">
</head>
<body>
    <header>
    <h1>WELCOME USER</h1>
    <form action="logout.php" method="post">
        <input style="width:7rem" type="submit" value="Logout" onclick="return confirm('Are you sure to logout?')">
    </form>
    </header>
    <section>
        <label>pengaduan :</label>
        <input type="text" name="isi" require>
        <label>isi laporan :</label>
        <textarea name="isi laporan" id="#"></textarea>
    </section>
    <section class= "kirim">
        <button>kirim laporan</button>
        <input type="file" name="foto">
    </section>
</body>
</html>