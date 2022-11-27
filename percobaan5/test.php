<?php
require_once "db.php";
if (function_exists($_GET['function'])) {
    $_GET['function']();
}

function getid(){
    global $koneksi;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = "SELECT * FROM data_buku WHERE id= $id";
    $result = $koneksi->query($query);
    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}
function tambah()
{
    global $koneksi;
    $check = array('id' => '', 'nama_peminjam' => '', 'judul_buku' => '', 'tgl_pinjam' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    if ($check_match == count($check)) {

        $result = mysqli_query($koneksi, "INSERT INTO data_buku SET
               id = '$_POST[id]',
               nama_peminjam = '$_POST[nama_peminjam]',
               judul_buku = '$_POST[judul_buku]',
               tgl_pinjam = '$_POST[tgl_pinjam]'");

        if ($result) {
            $response = array(
                'message' => 'Data berhasil dimasukkan'
            );
        } else {
            $response = array(
                'message' => 'Data gagal dimasukkan'
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
function update()
{
    global $koneksi;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $check = array('nama_peminjam' => '', 'judul_buku' => '', 'tgl_pinjam' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    if ($check_match == count($check)) {

        $result = mysqli_query($koneksi, "UPDATE data_buku SET               
               nama_peminjam = '$_POST[nama_peminjam]',
               judul_buku = '$_POST[judul_buku]',
               tgl_pinjam = '$_POST[tgl_pinjam]' WHERE id = $id");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Update Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Update Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter',
            'data' => $id
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
function delete()
{
    global $koneksi;
    $id = $_GET['id'];
    $query = "DELETE FROM data_buku WHERE id=" . $id;
    if (mysqli_query($koneksi, $query)) {
        $response = array(
            'message' => 'Delete Success'
        );
    } else {
        $response = array(
            'message' => 'Data yang dicari mungkin tidak ada'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
