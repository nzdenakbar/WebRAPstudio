<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "rap_studio");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  
  // Validasi input
  $errors = [];
  
  if (empty($nama)) {
    $errors[] = "Nama tidak boleh kosong";
  }
  
  if (empty($email)) {
    $errors[] = "Email tidak boleh kosong";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid";
  }
  
  if (empty($_POST['password'])) {
    $errors[] = "Password tidak boleh kosong";
  } elseif (strlen($_POST['password']) < 6) {
    $errors[] = "Password minimal 6 karakter";
  }
  
  // Cek apakah email sudah terdaftar
  $check_email = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $check_email->bind_param("s", $email);
  $check_email->execute();
  $result = $check_email->get_result();
  
  if ($result->num_rows > 0) {
    $errors[] = "Email sudah terdaftar, silakan gunakan email lain";
  }
  
  if (empty($errors)) {
    $query = $conn->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
    $query->bind_param("sss", $nama, $email, $password);
    
    if ($query->execute()) {
      $_SESSION['register_success'] = true;
      header("Location: login.php");
      exit();
    } else {
      $errors[] = "Gagal mendaftar. Coba lagi.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - R.A.P Studio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #2b2d42 0%, #121212 100%);
      color: #f8f9fa;
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
    }
    
    .register-container {
      background-color: rgba(33, 37, 41, 0.8);
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(10px);
      padding: 40px;
      margin-top: 50px;
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .register-container::before {
      content: "";
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 80%);
      z-index: -1;
    }
    
    .form-control {
      background-color: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: white;
      border-radius: 10px;
      padding: 12px 15px;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      background-color: rgba(255, 255, 255, 0.15);
      border-color: #0d6efd;
      box-shadow: 0 0 15px rgba(13, 110, 253, 0.5);
      color: white;
    }
    
    .form-label {
      font-weight: 500;
      margin-bottom: 0.7rem;
      font-size: 1.05rem;
    }
    
    .btn-register {
      background: linear-gradient(45deg, #0d6efd, #0099ff);
      border: none;
      border-radius: 50px;
      padding: 12px;
      font-weight: 600;
      letter-spacing: 1px;
      text-transform: uppercase;
      box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
      transition: all 0.3s;
    }
    
    .btn-register:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(13, 110, 253, 0.6);
      background: linear-gradient(45deg, #0099ff, #0d6efd);
    }
    
    .logo {
      max-width: 150px;
      margin-bottom: 20px;
    }
    
    .alert {
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 20px;
    }
    
    .input-group-text {
      background-color: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: white;
      border-radius: 0 10px 10px 0;
    }
    
    .password-toggle {
      cursor: pointer;
    }
    
    h2 {
      font-weight: 700;
      margin-bottom: 30px;
      background: linear-gradient(45deg, #0d6efd, #00c6ff);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      position: relative;
      display: inline-block;
    }
    
    @media (max-width: 768px) {
      .register-container {
        padding: 20px;
        margin-top: 20px;
      }
      h2 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="register-container">
          <div class="text-center">
            <!-- Anda bisa mengganti dengan logo asli -->
            <h2 class="mb-4">R.A.P Studio</h2>
            <p class="mb-4">Daftar dan mulai perjalanan musik Anda bersama kami</p>
          </div>
          
          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                  <li><?php echo $error; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
          
          <form method="POST" class="needs-validation" novalidate>
            <div class="mb-4">
              <label for="nama" class="form-label">
                <i class="fas fa-user me-2"></i>Nama Lengkap
              </label>
              <input type="text" name="nama" id="nama" class="form-control" 
                     value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>" required>
              <div class="invalid-feedback">Nama lengkap wajib diisi</div>
            </div>
            
            <div class="mb-4">
              <label for="email" class="form-label">
                <i class="fas fa-envelope me-2"></i>Email
              </label>
              <input type="email" name="email" id="email" class="form-control" 
                     value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
              <div class="invalid-feedback">Email wajib diisi dengan format yang benar</div>
            </div>
            
            <div class="mb-4">
              <label for="password" class="form-label">
                <i class="fas fa-lock me-2"></i>Kata Sandi
              </label>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="input-group-text password-toggle" onclick="togglePassword()">
                  <i class="fas fa-eye" id="toggleIcon"></i>
                </span>
              </div>
              <small class="form-text text-light-emphasis mt-1">Minimal 6 karakter</small>
              <div class="invalid-feedback">Kata sandi wajib diisi</div>
            </div>
            
            <div class="mb-4">
              <button type="submit" class="btn btn-primary btn-register w-100">
                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
              </button>
            </div>
            
            <div class="text-center">
              <p>Sudah punya akun? <a href="login.php" class="text-info fw-bold">Login di sini</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle password visibility
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }
    
    // Form validation
    (function() {
      'use strict';
      
      const forms = document.querySelectorAll('.needs-validation');
      
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          
          form.classList.add('was-validated');
        }, false);
      });
    })();
  </script>
</body>
</html>