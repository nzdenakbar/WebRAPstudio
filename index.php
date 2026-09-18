<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>R.A.P Studio Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #121212;
      color: #fff;
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
    
    .hero-section {
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/api/placeholder/1200/800') center/cover no-repeat;
      height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
    }
    
    .hero-content {
      max-width: 800px;
      padding: 2rem;
      z-index: 2;
    }
    
    .hero-heading {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
    }
    
    .hero-subheading {
      font-size: 1.5rem;
      opacity: 0.9;
      margin-bottom: 2rem;
      text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.8);
    }
    
    .btn-studio {
      background-color: #ff6b6b;
      color: white;
      border: none;
      padding: 0.8rem 2rem;
      font-weight: 600;
      border-radius: 30px;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s;
      margin: 0 10px 10px 0;
    }
    
    .btn-studio:hover {
      background-color: #ff5252;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
    }
    
    .btn-outline {
      background-color: transparent;
      border: 2px solid #ff6b6b;
      color: #ff6b6b;
    }
    
    .btn-outline:hover {
      background-color: #ff6b6b;
      color: white;
    }
    
    .features-section {
      background-color: #1a1a1a;
      padding: 5rem 0;
    }
    
    .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 3rem;
      color: #ff6b6b;
      text-align: center;
    }
    
    .feature-card {
      background-color: rgba(255, 255, 255, 0.05);
      border-radius: 12px;
      padding: 2rem;
      height: 100%;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }
    
    .feature-icon {
      font-size: 3rem;
      color: #ff6b6b;
      margin-bottom: 1.5rem;
    }
    
    .feature-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }
    
    .testimonials-section {
      background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('/api/placeholder/1200/600') center/cover fixed;
      padding: 5rem 0;
    }
    
    .testimonial-card {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      padding: 2rem;
      margin-bottom: 2rem;
    }
    
    .testimonial-text {
      font-style: italic;
      margin-bottom: 1rem;
    }
    
    .client-name {
      font-weight: 600;
      color: #ff6b6b;
    }
    
    .footer {
      background-color: #0a0a0a;
      color: #888;
      padding: 3rem 0;
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
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="fas fa-music me-2"></i>R.A.P Studio</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="fasilitas.php">Fasilitas</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link btn btn-sm btn-studio ms-2 px-3" href="register.php">Register</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="hero-content">
      <h1 class="hero-heading">Selamat Datang di R.A.P Studio</h1>
      <p class="hero-subheading">Jadikan musik Anda lebih profesional dengan dukungan fasilitas studio berkualitas</p>
      <div>
        <a href="login.php" class="btn btn-studio">Booking Sekarang</a>
        <a href="#features" class="btn btn-studio btn-outline">Pelajari Lebih Lanjut</a>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="features-section">
    <div class="container">
      <h2 class="section-title">Fitur Utama</h2>
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="feature-card text-center">
            <i class="fas fa-calendar-check feature-icon"></i>
            <h4 class="feature-title">Booking Mudah</h4>
            <p>Pilih jam, bayar DP, dan dapatkan konfirmasi instan. Proses booking yang cepat dan tanpa ribet.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="feature-card text-center">
            <i class="fas fa-history feature-icon"></i>
            <h4 class="feature-title">Riwayat Booking</h4>
            <p>Akses dan lihat semua histori booking Anda dengan mudah. Pantau jadwal dan pembayaran dalam satu tempat.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="feature-card text-center">
            <i class="fas fa-user-shield feature-icon"></i>
            <h4 class="feature-title">Akses Admin</h4>
            <p>Kelola data booking dan pembayaran dengan sistem admin yang intuitif dan mudah digunakan.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonials-section">
    <div class="container">
      <h2 class="section-title">Apa Kata Mereka</h2>
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="testimonial-card">
            <p class="testimonial-text">"Studio musik terbaik dengan fasilitas lengkap! Sistem booking online sangat memudahkan jadwal recording kami."</p>
            <p class="client-name">- Andi, Vokalis Band Indie</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="testimonial-card">
            <p class="testimonial-text">"Suara yang dihasilkan sangat berkualitas dengan harga yang terjangkau. Sangat direkomendasikan!"</p>
            <p class="client-name">- Budi, Produser Musik</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="testimonial-card">
            <p class="testimonial-text">"Proses booking cepat dan pelayanan sangat ramah. Kami akan terus menggunakan R.A.P Studio untuk project musik kami."</p>
            <p class="client-name">- Cindy, Penyanyi Solo</p>
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
          <a href="login.php" class="footer-link">Booking</a>
          <a href="#" class="footer-link">FAQ</a>
        </div>
        <div class="col-lg-4 mb-4">
          <h5 class="footer-heading">Kontak Kami</h5>
          <p><i class="fas fa-map-marker-alt me-2"></i>Jl. Sidorejo No.8A, Sonopakis Lor, Ngestiharjo, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55184</p>
          <p><i class="fas fa-phone me-2"></i> +62 857-2951-6920</p>
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
    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const target = document.querySelector(targetId);
        if (target) {
          window.scrollTo({
            top: target.offsetTop - 70,
            behavior: 'smooth'
          });
        }
      });
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.style.padding = '0.5rem 0';
        navbar.style.backgroundColor = 'rgba(0, 0, 0, 0.95) !important';
      } else {
        navbar.style.padding = '1rem 0';
        navbar.style.backgroundColor = 'rgba(0, 0, 0, 0.9) !important';
      }
    });
  </script>
</body>
</html>