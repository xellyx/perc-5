<?php
$method = getenv('REQUEST_METHOD');
$method = isset($_REQUEST['_METHOD']) ? $_REQUEST['_METHOD'] : $method;
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

function process_get($param) {
    if ($param[0] == "data_buku") {
        require_once 'db.php';
        try {
            $conn = new PDO(
                "mysql:host=$host;dbname=$dbname",
                $username,
                $password,
                array(
                    \PDO::ATTR_ERRMODE =>
                    \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_PERSISTENT => false
                )
            );
            if (!empty($param[1])) {
                $handle = $conn->prepare("
                SELECT id, nama_peminjam, judul_buku, tgl_pinjam FROM data_buku
                WHERE ID = :id
                ");
                $handle->bindParam(':id', $param[1], PDO::PARAM_INT);
                $handle->execute();
            } else {
                $handle = $conn->query("SELECT id, nama_peminjam, judul_buku, tgl_pinjam FROM data_buku");
            }
            if ($handle->rowCount()) {
                $status = 'Berhasil';
                $data = $handle->fetchAll(PDO::FETCH_ASSOC);
                $arr = array('status' => $status, 'data' => $data);
            } else {
                $status = "Tidak ada data";
                $arr = array('status' => $status);
            }
            header('Content-Type: application/json');
            echo json_encode($arr);
        } catch (PDOException $pe) {
            die(json_encode($pe->getMessage()));
        }
    }
}

function process_post($param) {
    if ((count($param) == 1) and ($param[0] == "data_buku")) {
        require_once 'db.php';
        $dataNama = (isset($_POST['nama_peminjam']) ? $_POST['nama_peminjam'] : NULL);
        $dataJudul = (isset($_POST['judul_buku']) ? $_POST['judul_buku'] : NULL);
        $dataTanggal = (isset($_POST['tgl_pinjam']) ? $_POST['tgl_pinjam'] : NULL);
        try {
            $conn = new PDO(
                "mysql:host=$host;dbname=$dbname",
                $username,
                $password,
                array(
                    \PDO::ATTR_ERRMODE =>
                    \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_PERSISTENT => false
                )
            );
            $handle = $conn->prepare("
            INSERT INTO data_buku (nama_peminjam, judul_buku, tgl_pinjam)
            VALUES (:nama_peminjam, :judul_buku, :tgl_pinjam)");
            $handle->bindParam(':nama_peminjam', $dataNama);
            $handle->bindParam(':judul_buku', $dataJudul);
            $handle->bindParam(':tgl_pinjam', $dataTanggal);
            $handle->execute();
            if ($handle->rowCount()) {
                $status = 'Berhasil';
                $idTerakhir = $conn->lastInsertId();
                $arr = array('status' => $status, 'id' => $idTerakhir);
            } else {
                $status = "Gagal";
                $arr = array('status' => $status);
            }
            echo json_encode($arr);
        } catch (PDOException $pe) {


            die(json_encode($pe->getMessage()));
        }
    }
}

function process_put($param) {
    if ((count($param) == 2) and $param[0] == "data_buku" and
        $_SERVER["CONTENT_TYPE"] == 'application/x-www-form-urlencoded'
    ) {
        require_once 'db.php';

        parse_str(file_get_contents('php://input'), $data);
        $dataNama = $data['nama_peminjam'];
        $dataJudul = $data['judul_buku'];
        try {
            $conn = new PDO(
                "mysql:host=$host;dbname=$dbname",
                $username,
                $password,
                array(
                    \PDO::ATTR_ERRMODE =>
                    \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_PERSISTENT => false
                )
            );
            $handle = $conn->prepare("
            UPDATE data_buku 
            SET nama_peminjam=:nama_peminjam, judul_buku=:judul_buku WHERE ID=:id");

            $dataID = $param[1];
            $handle->bindParam(':id', $dataID, PDO::PARAM_INT);
            $handle->bindParam(':nama_peminjam', $dataNama);
            $handle->bindParam(':judul_buku', $dataJudul);
            $handle->execute();

            if ($handle->rowCount()) {
                $status = 'Berhasil';
            } else {
                $status = "Gagal";
            }
            $arr = array('status' => $status, 'id' => $dataID, 'nama_peminjam' => $dataNama, 'judul_buku' => $dataJudul);
            echo json_encode($arr);
        } catch (PDOException $pe) {
            die(json_encode($pe->getMessage()));
        }
    }
}

function process_delete($param) {
    if ((count($param) == 2) and $param[0] == "data_buku") {
        require_once 'db.php';
        try {
            $conn = new PDO(
                "mysql:host=$host;dbname=$dbname",
                $username,
                $password,
                array(
                    \PDO::ATTR_ERRMODE =>
                    \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_PERSISTENT => false
                )
            );
            $handle = $conn->prepare("
            DELETE FROM data_buku
            WHERE ID=:id
            ");
            $dataID = $param[1];
            $handle->bindParam(':id', $dataID, PDO::PARAM_INT);
            $handle->execute();
            if ($handle->rowCount()) {
                $status = 'Berhasil';
            } else {

                $status = "Gagal";
            }
            $arr = array('status' => $status, 'id' => $dataID);
            echo json_encode($arr);
        } catch (PDOException $pe) {
            die(json_encode($pe->getMessage()));
        }
    }
}
function process_options($param) {

    if ((count($param) == 1) and $param[0] == 'data_buku') {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Lenght: 0');
        header('Content-Type: text/plain');
    }
}

switch ($method) {
    case 'PUT':
        process_put($request);
        break;
    case 'POST':
        process_post($request);
        break;
    case 'GET':
        process_get($request);
        break;
    case 'DELETE':
        process_delete($request);
        break;
    case 'OPTIONS':
        process_options($request);
        break;
}
