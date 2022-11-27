<?php
include 'dbconnect.php';
$pdo = pdo_connect_mysql();
if (!empty($_POST)) {
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;

    $judul_buku = isset($_POST['judul_buku']) ? $_POST['judul_buku'] : '';
    $nama_peminjam = isset($_POST['nama_peminjam']) ? $_POST['nama_peminjam'] : '';
    $tgl_pinjam = isset($_POST['tgl_pinjam']) ? $_POST['tgl_pinjam'] : '';

    $stmt = $pdo->prepare('INSERT INTO data_buku VALUES (?, ?, ?, ?)');
    $stmt->execute([$id, $judul_buku, $nama_peminjam, $tgl_pinjam]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengisian data</title>
    <link rel="stylesheet" href="./css/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body>

    <header class="main-header">
        <h1>Pengisian Data Buku</h1>
        <a href="index.php"><i class="homebtn fas fa-home fa-2x"></i></a>
    </header>

    <div class="container">
        <form action="create.php" method="post">

            <input type="hidden" value="auto" name="id" id="id">

            <label for="judul_buku"><b>Judul Buku *</b></label>
            <input type="text" placeholder="Masukkan judul buku" name="judul_buku" required>

            <label for="nama_peminjam"><b>Nama Peminjam *</b></label>
            <input type="text" placeholder="Masukkan nama peminjam" name="nama_peminjam" required>

            <label for="tgl_pinjam"><b>Tanggal Pinjam *</b></label><br>
            <input type="date" name="tgl_pinjam" required>

            <input class="svbtn" type="submit" value="Create">

        </form>
    </div>
</body>

</html>