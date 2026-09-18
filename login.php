<?php session_start(); 
$conn = new mysqli("localhost", "root", "", "rap_studio");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  $query = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($query);
  
  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['nama'] = $user['nama'];
      header("Location: user_dashboard.php");
    } else {
      $error = "Password salah.";
    }
  } else {
    $error = "Akun tidak ditemukan.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - R.A.P Studio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #121212;
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    
    .navbar {
      background-color: rgba(0, 0, 0, 0.9) !important;
      padding: 1rem 0;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }
    
    .navbar-brand {
      font-weight: 700;
      font-size: 1.8rem;
      color: #ff6b6b !important;
    }
    
    .nav-link {
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin: 0 10px;
      transition: color 0.3s;
    }
    
    .nav-link:hover {
      color: #ff6b6b !important;
    }
    
    .login-section {
      flex: 1;
      display: flex;
      align-items: center;
      padding: 3rem 0;
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/api/placeholder/1200/800') center/cover no-repeat fixed;
    }
    
    .login-container {
      background-color: rgba(26, 26, 26, 0.95);
      border-radius: 12px;
      padding: 2.5rem;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      max-width: 500px;
      width: 100%;
      margin: 0 auto;
    }
    
    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    
    .login-header h2 {
      font-weight: 700;
      color: #ff6b6b;
      margin-bottom: 0.5rem;
    }
    
    .login-header p {
      color: #aaa;
    }
    
    .form-label {
      color: #ddd;
      font-weight: 500;
      margin-bottom: 0.5rem;
    }
    
    .form-control {
      background-color: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #fff;
      padding: 0.8rem 1rem;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    .form-control:focus {
      background-color: rgba(255, 255, 255, 0.12);
      border-color: #ff6b6b;
      box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.25);
      color: #fff;
    }
    
    .form-control::placeholder {
      color: #777;
    }
    
    .input-group-text {
      background-color: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #aaa;
    }
    
    .btn-login {
      background-color: #ff6b6b;
      color: white;
      border: none;
      padding: 0.8rem 2rem;
      font-weight: 600;
      border-radius: 8px;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s;
      margin-top: 1rem;
    }
    
    .btn-login:hover {
      background-color: #ff5252;
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
    }
    
    .divider {
      display: flex;
      align-items: center;
      margin: 1.5rem 0;
      color: #777;
    }
    
    .divider::before, 
    .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .divider span {
      padding: 0 1rem;
    }
    
    .social-login {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }
    
    .social-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.2rem;
      transition: all 0.3s;
    }
    
    .social-btn:hover {
      transform: translateY(-3px);
    }
    
    .btn-facebook {
      background-color: #1877f2;
    }
    
    .btn-google {
      background-color: #ea4335;
    }
    
    .footer-text {
      text-align: center;
      color: #aaa;
      margin-top: 1.5rem;
    }
    
    .footer-text a {
      color: #ff6b6b;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }
    
    .footer-text a:hover {
      color: #ff5252;
    }
    
    .alert-danger {
      background-color: rgba(220, 53, 69, 0.1);
      color: #ff6b6b;
      border: 1px solid rgba(220, 53, 69, 0.2);
      border-radius: 8px;
    }
    
    .footer {
      background-color: #0a0a0a;
      color: #888;
      padding: 3rem 0;
      margin-top: auto;
    }
    
    .footer-heading {
      color: #ff6b6b;
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }
    
    .footer-link {
      color: #aaa;
      text-decoration: none;
      display: block;
      margin-bottom: 0.7rem;
      transition: color 0.3s;
    }
    
    .footer-link:hover {
      color: #ff6b6b;
    }
    
    .social-icon {
      font-size: 1.5rem;
      color: #aaa;
      margin-right: 1rem;
      transition: color 0.3s;
    }
    
    .social-icon:hover {
      color: #ff6b6b;
    }
    
    .copyright {
      background-color: #050505;
      padding: 1.5rem 0;
      color: #666;
    }
    
    .remember-me {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 1rem;
    }
    
    .form-check-input {
      background-color: rgba(255, 255, 255, 0.1);
      border-color: rgba(255, 255, 255, 0.2);
    }
    
    .form-check-input:checked {
      background-color: #ff6b6b;
      border-color: #ff6b6b;
    }
    
    .forgot-password {
      color: #aaa;
      text-decoration: none;
      font-size: 0.9rem;
      transition: color 0.3s;
    }
    
    .forgot-password:hover {
      color: #ff6b6b;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php"><i class="fas fa-music me-2"></i>R.A.P Studio</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="fasilitas.php">Fasilitas</a></li>
          <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link btn btn-sm btn-studio ms-2 px-3" href="register.php">Register</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Login Section -->
  <section class="login-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="login-container">
            <div class="login-header">
              <h2>Login ke R.A.P Studio</h2>
              <p>Akses akun Anda untuk booking studio musik</p>
            </div>
            
            <?php if (isset($error)) echo "<div class='alert alert-danger mb-4'><i class='fas fa-exclamation-circle me-2'></i>$error</div>"; ?>
            
            <form method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
                </div>
              </div>
              
              <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
                  <span class="input-group-text" style="cursor: pointer;" id="togglePassword">
                    <i class="fas fa-eye"></i>
                  </span>
                </div>
              </div>
              
              <div class="remember-me">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="rememberMe">
                  <label class="form-check-label" for="rememberMe">Ingat saya</label>
                </div>
                <a href="#" class="forgot-password">Lupa kata sandi?</a>
              </div>
              
              <button type="submit" class="btn btn-login w-100">Masuk</button>
            </form>
            
            <div class="divider">
              <span>atau masuk dengan</span>
            </div>
            
            <div class="social-login">
              <a href="#" class="social-btn btn-facebook">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-btn btn-google">
                <i class="fab fa-google"></i>
              </a>
            </div>
            
            <p class="footer-text">
              Belum punya akun? <a href="register.php">Daftar sekarang</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-4">
          <h5 class="footer-heading">R.A.P Studio</h5>
          <p>Studio musik profesional dengan fasilitas modern dan sistem booking online yang memudahkan para musisi.</p>
          <div class="mt-3">
            <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <h5 class="footer-heading">Link Cepat</h5>
          <a href="index.php" class="footer-link">Beranda</a>
          <a href="fasilitas.php" class="footer-link">Fasilitas</a>
          <a href="harga.php" class="footer-link">Harga</a>
          <a href="login.php" class="footer-link">Booking</a>
          <a href="#" class="footer-link">FAQ</a>
        </div>
        <div class="col-lg-4 mb-4">
          <h5 class="footer-heading">Kontak Kami</h5>
          <p><i class="fas fa-map-marker-alt me-2"></i> Jl. Musik No. 123, Jakarta</p>
          <p><i class="fas fa-phone me-2"></i> +62 812-3456-7890</p>
          <p><i class="fas fa-envelope me-2"></i> info@rapstudio.id</p>
        </div>
      </div>
    </div>
  </footer>
  
  <div class="copyright text-center">
    <div class="container">&copy; 2025 R.A.P Studio. All Rights Reserved.</div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Password visibility toggle
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    togglePassword.addEventListener('click', function() {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      
      // Toggle eye icon
      this.querySelector('i').classList.toggle('fa-eye');
      this.querySelector('i').classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>