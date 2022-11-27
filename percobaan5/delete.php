<?php
include 'dbconnect.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM data_buku WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $data_buku = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data_buku) {
        exit('ID tidak di temukan didalam tabel');
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM data_buku WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Data sudah dihapus';
        } else {
            header('Location: index.php');
            exit;
        }
    }
} else {
    exit('ID Tidak ditemukan');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Data</title>
    <link rel="stylesheet" href="./css/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body>

    <header class="main-header">
        <h1>Pengisian Data Buku</h1>
        <a href="index.php"><i class="homebtn fas fa-home fa-2x"></i></a>
        <a href="create.php"><i class="homebtn fas fa-book fa-2x"></i></a>
    </header>


    <article class="card1" id="pwa">

        <div class="card__content">

            <div class="hapusdata">
                <h2>Apakah anda ingim menghapus data pada ID: <?= $data_buku['id'] ?>?</h2>
                <?php if ($msg) : ?>
                    <p><?= $msg ?></p>
                <?php else : ?>
                    <div>
                        <a class="svbtn" href="delete.php?id=<?= $data_buku['id'] ?>&confirm=yes">Ya</a>
                        <a class="svbtn" href="delete.php?id=<?= $data_buku['id'] ?>&confirm=no">Tidak</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </article>
</body>

</html>