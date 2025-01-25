<?php
// Konfigurasi database
$host = 'localhost'; // Host database (biasanya 'localhost')
$user = 'root';      // Nama pengguna database
$pass = '';          // Kata sandi database (kosong jika menggunakan XAMPP tanpa password)
$db = 'pengguna_les'; // Nama database yang Anda gunakan

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
