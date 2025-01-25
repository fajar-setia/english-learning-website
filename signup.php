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

// Inisialisasi variabel untuk pesan kesalahan
$usernameError = "";
$emailError = "";
$passwordError = "";
$confirmPasswordError = "";
$successMessage = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validasi input
    if (empty($username)) {
        $usernameError = "Username diperlukan!";
    }
    if (empty($email)) {
        $emailError = "Email diperlukan!";
    }
    if (empty($password)) {
        $passwordError = "Password diperlukan!";
    }
    if (empty($confirmPassword)) {
        $confirmPasswordError = "Konfirmasi password diperlukan!";
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordError = "Password tidak cocok!";
    }

    // Jika tidak ada kesalahan, simpan ke database
    if (empty($usernameError) && empty($emailError) && empty($passwordError) && empty($confirmPasswordError)) {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Menyimpan data ke database
        $stmt = $conn->prepare("INSERT INTO pengguna (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss",$username , $email, $hashedPassword);

        if ($stmt->execute()) {
            $successMessage = "Pendaftaran berhasil! Silakan <a href='index.php'>Login</a>";
        } else {
            $emailError = "Error: " . $stmt->error; // Jika ada kesalahan saat eksekusi
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="assets/login.css">
</head>
<style>


</style>
<body>

<!-- Form signup yang dipusatkan -->
<div class="container">
    <div class="row w-100">
        <!-- Kolom untuk gambar -->
        <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
            <img src="gambar/background4.jpg" alt="Signup Illustration" class="img-fluid">
        </div>

        <!-- Kolom untuk form -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="card w-75 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4 fs-2">Signup</h5>
                    <form method="POST">
                    <div class="form-floating mb-3">
                            <input type="Text" name="username" class="form-control" id="floatingInput" placeholder="create username">
                            <label for="floatingInput">Username</label>
                            <div class="text-danger"><?php echo $usernameError; ?></div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                            <label for="floatingInput">Email address</label>
                            <div class="text-danger"><?php echo $emailError; ?></div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="create Password">
                            <label for="floatingPassword">Create Password</label>
                            <div class="text-danger"><?php echo $passwordError; ?></div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="confirm_password" class="form-control" id="floatingPassword1" placeholder="confirm Password">
                            <label for="floatingPassword1">Confirm Password</label>
                            <div class="text-danger"><?php echo $confirmPasswordError; ?></div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Sign Up</button>
                        <div class="sign-in">
                            <p class="text-center">
                                Already have an account? <a class="sign mb-5 link-offset-2 link-underline link-underline-opacity-0 fw-light" href="index.php">Login</a>
                            </p>
                        </div>
                        
                        <div class="icon-akhir d-flex flex-column align-items-center gap-3 mb-3">
                            
                        </div>
                    </form>
                    <div class="text-center text-success mt-3"><?php echo $successMessage; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
</body>
</html>