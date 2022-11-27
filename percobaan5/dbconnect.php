<?php
function pdo_connect_mysql() {
	$DATABASE_NAME = 'kuliah';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
	$DATABASE_HOST = 'localhost';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	exit('Koneksi ke database gagal');
    }
}
