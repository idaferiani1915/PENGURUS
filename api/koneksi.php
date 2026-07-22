<?php
$host   = "127.0.0.1";
$user   = "root";         // ganti sesuai server
$pass   = "bagusdev123";             // ganti sesuai server
$dbname = "db_pengurus";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "gagal", "pesan" => "Koneksi database gagal."]));
}
?>
