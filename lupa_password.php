<?php
date_default_timezone_set("Asia/Jakarta");

// Memasukkan PHPMailer
require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "pengguna_les");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Cek apakah email ada
    $query = $conn->prepare("SELECT * FROM pengguna WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Email ditemukan
        $otp = rand(100000, 999999); // Membuat kode OTP 6 digit
        $expiresAt = date("Y-m-d H:i:s", strtotime("+10 minutes")); // Kode berlaku 10 menit

        // Simpan OTP ke database
        $insert = $conn->prepare("INSERT INTO reset_tokens (email, token, expires_at) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $email, $otp, $expiresAt);
        $insert->execute();

        // Kirim email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'setiafajar935@gmail.com'; // Ganti dengan email Anda
            $mail->Password = 'axux wtmx aqya doun';        
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('setiafajar935@gmail.com', 'Admin_Perusahaan');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Kode Verifikasi';
            $mail->Body    = "Kode verifikasi Anda adalah <b>$otp</b>. Berlaku selama 10 menit.";

            $mail->send();

            // Redirect ke halaman verifikasi
            header("Location: verifikasi_kode.php?email=" . urlencode($email));
            exit;
        } catch (Exception $e) {
            $message = "Gagal mengirim email. Pesan kesalahan: " . $mail->ErrorInfo;
            $alertType = "danger";
        }
    } else {
        $message = "Email tidak terdaftar.";
        $alertType = "warning";
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/lupaPass.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h3 class="text-center mb-4">Lupa Password</h3>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Masukan Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary d-grid gap-2">Reset</button>
                </form>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $alertType ?> mt-3" role="alert">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
