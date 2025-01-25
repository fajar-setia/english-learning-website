<?php
session_start();  // Memulai sesi

require 'config.php'; 

// Inisialisasi variabel untuk pesan kesalahan
$emailError = "";
$passwordError = "";
$successMessage = "";

// Ambil pesan dan alertType dari session
if (isset($_SESSION['message']) && isset($_SESSION['alertType'])) {
    $message = $_SESSION['message'];
    $alertType = $_SESSION['alertType'];

    // Hapus pesan dari session setelah ditampilkan
    unset($_SESSION['message']);
    unset($_SESSION['alertType']);
}

// Mengatasi pengiriman form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($email)) {
        $emailError = "Email diperlukan!";
    }
    if (empty($password)) {
        $passwordError = "Password diperlukan!";
    }

    // Jika tidak ada kesalahan, lanjutkan ke login
    if (empty($emailError) && empty($passwordError)) {
        // Siapkan pernyataan SQL
        $stmt = $conn->prepare("SELECT * FROM pengguna WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        

        // Periksa apakah pengguna ada
        if ($user = $result->fetch_assoc()) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Login berhasil dan mengarahkan ke index.html
                header("Location: user.php");
                $_SESSION['user_id'] = true;
                $_SESSION['user_email'] = $email; // Opsional, jika Anda ingin menyimpan email pengguna
                header("Location: user.php");
                
                exit(); // Pastikan tidak ada kode lebih lanjut yang dieksekusi

            }
        } 

        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $admResult = $stmt->get_result();

        if($admin = $admResult->fetch_assoc()){
            if(password_verify($password,$admin['password'])){
                $_SESSION['admin_id'] = true;
                $_SESSION['admin_role'] = $admin['role'];
                header("Location: home.php");
                
                exit();
            }
        }

        else {
            $emailError = "Email dan password salah";
            echo "<script>alert('hai , " . $emailError . "!');</script>";
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
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="assets/login.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
</head>
<style>
    html, body {
    height: 100%;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
   background-image:url('https://wallpapercave.com/wp/wp3853272.jpg') !important; /* Ganti dengan path gambar Anda */
    background-size: cover; /* Agar gambar menutupi seluruh layar */
    background-position: center center; /* Agar gambar berada di tengah */
    background-attachment: fixed; /* Membuat gambar tetap saat scroll */
    background-repeat: no-repeat; /* Mencegah gambar diulang */
    font-family: Arial, sans-serif;
   
}
</style>
<body>
    <!-- Form login yang dipusatkan -->
    <div class="container">
        <div class="row w-100">
            <!-- Kolom untuk gambar -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
                <img src="gambar/background4.jpg" alt="Login Illustration" class="img-fluid">
            </div>
            <!-- Kolom untuk form -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="card w-75 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4 fs-2">Login</h5>

                        <!-- Tampilkan pesan jika ada -->
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-<?= $alertType ?>" role="alert">
                                <?= $message ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                                <label for="floatingInput">Email address</label>
                                <!-- <div class="text-danger"><?php echo $emailError; ?></div> -->
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                <!-- <div class="text-danger"><?php echo $passwordError; ?></div> -->
                            </div>
                            <div class="link d-flex justify-content-center align-items-center">
                                <a class="forgot-password link-offset-2 link-underline link-underline-opacity-0 fw-light" href="lupa_password.php">Forgot password?</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                            <div class="sign-in">
                                <p class="text-center">
                                    Don't have an account?<a class="sign mb-5 link-offset-2 link-underline link-underline-opacity-0 fw-light" href="signup.php"> Signup</a>
                                </p>
                            </div>
                            
                            <div class="icon-akhir d-flex flex-column align-items-center gap-3 mb-3">
                                
                            </div>
                        </form>
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

