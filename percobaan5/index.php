<?php
include 'dbconnect.php';
$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;


$stmt = $pdo->prepare('SELECT * FROM data_buku ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$data_buku = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_datas = $pdo->query('SELECT COUNT(*) FROM data_buku')->fetchColumn();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TUGAS AKHIR PWA</title>
    <link rel="stylesheet" href="./css/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="manifest" href="./manifest.json">
</head>

<body>
    <header class="main-header">
        <h1>Pengisian Data Buku</h1>
        <a href="create.php"><i class="homebtn fas fa-book fa-2x"></i></a>
    </header>

    <article class="card" id="pwa">

        <div class="card__content">
            <h3>Data Buku</h3>
            <a href="create.php"><i class="homebtn2">Tambah Data</i></a>
            <table class="table1" border="1">
                <thead>
                    <tr>
                        <td>ID Buku</td>
                        <td>Nama Peminjam</td>
                        <td>Judul Buku</td>
                        <td>Tanggal Pinjam</td>
                        <td>Opsi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_buku as $data) : ?>
                        <tr>
                            <td><?= $data['id'] ?></td>
                            <td><?= $data['nama_peminjam'] ?></td>
                            <td><?= $data['judul_buku'] ?></td>
                            <td><?= $data['tgl_pinjam'] ?></td>
                            <td class="actions">
                                <a href="update.php?id=<?= $data['id'] ?>" class="edit"><i class="fas fa-pen fa-xs fa-1x"></i></a>
                                <a href="delete.php?id=<?= $data['id'] ?>" class="trash"><i class="fas fa-trash fa-xs fa-1x"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>

    </article>
    <script src="./js/app.js"></script>
</body>

</html>