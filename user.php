<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body {
        background-color: #d9d8d9;
    }
    .navbar{
        /*background-color: #541f7c;*/
       font-family: "Lilita One", serif;
       background-image: url('gambar/anime3.jpg');
       
    }
    .feature-card {
        transition: transform 0.3s ease;
        margin-bottom: 20px;
        height: 100%;
        
    }
    .feature-card:hover {
        transform: scale(1.01);
    }
    .card-img-top {
      height: 250px; /* Sesuaikan tinggi gambar agar seragam */
      object-fit: cover;
    }
            .hero-section {
            background-color: #b3a3ba;
            color: white;
            padding: 60px 0;
            text-align: center;
            font-family: "Lilita One", serif;
            font-weight: 400;
            font-style: normal;
            background-image: url('gambar/anime2.jpg');
            /* Tambahkan properti berikut */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            min-height: 220px; /* Sesuaikan dengan kebutuhan */
            display: flex;
            align-items: center;
        }

    
    .feature-container {
        max-width: 2000px;
        margin: 0 auto;
        padding: 21.5px;
        font-family: "Lilita One", serif;
        /*background-color: #f4e9e1;*/
        background-image: url('gambar/anime1.jpg');
        
        
    }
 

    </style>
</head>
<body>
    
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">English Learning</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="user.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userFeature/fitur1.php">Watch video</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userFeature/fitur2.php">Basic English</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userFeature/fitur3.php">Read Comic</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userFeature/fitur4.php">About Us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        <li><hr class="dropdown-divider"></li>
                      
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="hero-section">
    <div class="container">
        
        <h1>Website English learning</h1>
        <p class="lead">Best English Learning Website in MBANTUL</p>
    </div>
</div>

<div class="feature-container">
  <div class="row justify-content-center">
      <div class="col-md-3">
          <div class="card feature-card">
              <a href="userFeature/fitur2.php" class="text-reset text-decoration-none">
                  <img src="gambar/anime4.jpg" class="card-img-top" alt="Jual Barang">
                  <div class="card-body">
                      <h5 class="card-title text-center">Basic English</h5>
                  </div>
              </a>
          </div>
      </div>
      <div class="col-md-3">
          <div class="card feature-card">
              <a href="userFeature/fitur1.php" class="text-reset text-decoration-none">
                  <img src="gambar/anime5.jpg" class="card-img-top" alt="Beli Barang">
                  <div class="card-body">
                      <h5 class="card-title text-center">Watch Video</h5>
                  </div>
              </a>
          </div>
      </div>
      <div class="col-md-3">
        <div class="card feature-card">
            <a href="userFeature/fitur3.php" class="text-reset text-decoration-none">
                <img src="gambar/gambar22.jpg" class="card-img-top" alt="Jual Barang">
                <div class="card-body">
                    <h5 class="card-title text-center">Read Comic</h5>
                </div>
            </a>
        </div>
    </div>
  </div>
</div>


<footer class="bg-dark text-white text-center py-3">
    <div class="container">
        <p>Copyright © 2025 English Learning Website | Rafi Adam | Fajar Setia | Faris Raihan | Jhoifa Winola | Ilham Bintaris</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
