<?php
include 'dbconnect.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama_peminjam = isset($_POST['nama_peminjam']) ? $_POST['nama_peminjam'] : '';
        $judul_buku = isset($_POST['judul_buku']) ? $_POST['judul_buku'] : '';
        $tgl_pinjam = isset($_POST['tgl_pinjam']) ? $_POST['tgl_pinjam'] : '';

        $stmt = $pdo->prepare('UPDATE data_buku SET id = ?, nama_peminjam = ?, judul_buku = ?, tgl_pinjam = ? WHERE id = ?');
        $stmt->execute([$id, $nama_peminjam, $judul_buku, $tgl_pinjam, $_GET['id']]);
        $msg = 'Data berhasil diubah';
    }
    $stmt = $pdo->prepare('SELECT * FROM data_buku WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $data_buku = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data_buku) {
        header('Location: index.php');
        exit;
    }
} else {
    exit('ID Tidak Ditemukan');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link rel="stylesheet" href="./css/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body>


    <header class="main-header">
        <h1>Pengisian Data Buku</h1>
        <a href="index.php"><i class="homebtn fas fa-home fa-2x"></i></a>
        <a href="create.php"><i class="homebtn fas fa-book fa-2x"></i></a>
    </header>

    <div class="container">
        <div class="content update">
            <h2>Edit Data ID: <?= $data_buku['id'] ?></h2>
            <form action="update.php?id=<?= $data_buku['id'] ?>" method="post">

                <label for="judul_buku"><b>ID Buku *</b></label>
                <input type="text" name="id" value="<?= $data_buku['id'] ?>" id="id">

                <label for="judul_buku"><b>Judul Buku *</b></label>
                <input type="text" name="judul_buku" value="<?= $data_buku['judul_buku'] ?>" id="judul_buku">

                <label for="nama_peminjam"><b>Nama Peminjam *</b></label>
                <input type="text" placeholder="Masukkan nama peminjam" name="nama_peminjam" value="<?= $data_buku['nama_peminjam'] ?>" required>

                <label for="tgl_pinjam"><b>Tanggal Pinjam *</b></label><br>
                <input type="date" name="tgl_pinjam" value="<?= $data_buku['tgl_pinjam'] ?>" id="tgl_pinjam">

                <input class="svbtn" type="submit" value="Update">

            </form>

        </div>
        <?php if ($msg) : ?>
            <p><?= $msg ?></p>
        <?php endif; ?>
</body>

</html>