<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fasilitas - R.A.P Studio Booking</title>
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
    
    .page-header {
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/api/placeholder/1200/400') center/cover no-repeat;
      padding: 8rem 0 4rem;
      text-align: center;
      position: relative;
    }
    
    .page-title {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 1rem;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
    }
    
    .page-subtitle {
      font-size: 1.2rem;
      opacity: 0.9;
      max-width: 700px;
      margin: 0 auto;
      text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.8);
    }
    
    .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 3rem;
      color: #ff6b6b;
      text-align: center;
    }
    
    .section-subtitle {
      text-align: center;
      max-width: 800px;
      margin: -2rem auto 3rem;
      color: #aaa;
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
    
    .facility-section {
      padding: 5rem 0;
      background-color: #1a1a1a;
    }
    
    .facility-card {
      background-color: rgba(255, 255, 255, 0.05);
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
      height: 100%;
    }
    
    .facility-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }
    
    .facility-img {
      height: 240px;
      width: 100%;
      object-fit: cover;
    }
    
    .facility-content {
      padding: 1.5rem;
    }
    
    .facility-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #ff6b6b;
    }
    
    .equipment-section {
      padding: 5rem 0;
      background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url('/api/placeholder/1200/600') center/cover fixed;
    }
    
    .equipment-card {
      background-color: rgba(255, 255, 255, 0.05);
      border-radius: 12px;
      padding: 2rem;
      height: 100%;
      transition: all 0.3s ease;
    }
    
    .equipment-card:hover {
      background-color: rgba(255, 107, 107, 0.1);
      transform: translateY(-5px);
    }
    
    .equipment-icon {
      font-size: 2.5rem;
      color: #ff6b6b;
      margin-bottom: 1.5rem;
    }
    
    .equipment-title {
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }
    
    .equipment-list {
      padding-left: 1.2rem;
      color: #ddd;
    }
    
    .equipment-list li {
      margin-bottom: 0.5rem;
    }
    
    .price-section {
      padding: 5rem 0;
      background-color: #151515;
    }
    
    .price-card {
      background-color: rgba(255, 255, 255, 0.05);
      border-radius: 12px;
      padding: 2.5rem 1.5rem;
      text-align: center;
      height: 100%;
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    .price-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }
    
    .popular-tag {
      position: absolute;
      top: 20px;
      right: -30px;
      background-color: #ff6b6b;
      color: white;
      padding: 0.3rem 2rem;
      transform: rotate(45deg);
      font-size: 0.8rem;
      font-weight: 600;
    }
    
    .price-category {
      text-transform: uppercase;
      font-weight: 700;
      letter-spacing: 2px;
      font-size: 1rem;
      color: #aaa;
      margin-bottom: 1rem;
    }
    
    .price-value {
      font-size: 2.5rem;
      font-weight: 800;
      color: #ff6b6b;
      margin-bottom: 1.5rem;
    }
    
    .price-time {
      font-size: 0.9rem;
      color: #888;
      margin-top: -1rem;
      margin-bottom: 1.5rem;
    }
    
    .price-features {
      list-style: none;
      padding: 0;
      margin-bottom: 2rem;
    }
    
    .price-features li {
      padding: 0.6rem 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .price-features li:last-child {
      border-bottom: none;
    }
    
    .cta-section {
      padding: 5rem 0;
      text-align: center;
      background-color: #1a1a1a;
    }
    
    .cta-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
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
      <a class="navbar-brand" href="index.php"><i class="fas fa-music me-2"></i>R.A.P Studio</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link active" href="fasilitas.php">Fasilitas</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link btn btn-sm btn-studio ms-2 px-3" href="register.php">Register</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <header class="page-header">
    <div class="container">
      <h1 class="page-title">Fasilitas Studio</h1>
      <p class="page-subtitle">Nikmati berbagai fasilitas berkualitas tinggi untuk mendukung proses rekaman musik Anda</p>
    </div>
  </header>

  <!-- Studio Facilities Section -->
  <section class="facility-section">
    <div class="container">
      <h2 class="section-title">Ruangan Studio</h2>
      <p class="section-subtitle">Kami menyediakan ruangan studio yang didesain khusus untuk menghasilkan kualitas audio terbaik dengan suasana yang nyaman</p>
      
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="facility-card">
            <img src="/api/placeholder/600/400" alt="Recording Room" class="facility-img">
            <div class="facility-content">
              <h3 class="facility-title">Recording Room</h3>
              <p>Ruangan rekaman yang dilengkapi dengan peredam suara berkualitas tinggi serta acoustic treatment untuk hasil rekaman yang jernih dan profesional.</p>
              <ul class="mt-3">
                <li>Luas ruangan: 5 x 6 meter</li>
                <li>Triple layer soundproofing</li>
                <li>Acoustic panels dan bass traps</li>
                <li>Temperatur terkontrol</li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="facility-card">
            <img src="/api/placeholder/600/400" alt="Control Room" class="facility-img">
            <div class="facility-content">
              <h3 class="facility-title">Control Room</h3>
              <p>Ruang kontrol dengan peralatan mixing dan mastering profesional. Dilengkapi dengan monitor audio flat-response untuk hasil mixing yang akurat.</p>
              <ul class="mt-3">
                <li>Workstation ergonomis</li>
                <li>Acoustic treatment optimal</li>
                <li>Viewing window ke recording room</li>
                <li>Sofa untuk client</li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="facility-card">
            <img src="/api/placeholder/600/400" alt="Live Room" class="facility-img">
            <div class="facility-content">
              <h3 class="facility-title">Live Room</h3>
              <p>Ruangan luas untuk rekaman instrumen dan band secara live. Desain akustik yang optimal untuk menghasilkan suara natural dan balance.</p>
              <ul class="mt-3">
                <li>Luas ruangan: 8 x 10 meter</li>
                <li>Ceiling height: 4 meter</li>
                <li>Variable acoustic panels</li>
                <li>Isolasi booth untuk amplifier</li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="facility-card">
            <img src="/api/placeholder/600/400" alt="Vocal Booth" class="facility-img">
            <div class="facility-content">
              <h3 class="facility-title">Vocal Booth</h3>
              <p>Booth vokal yang dirancang khusus untuk rekaman vokal dengan isolasi suara sempurna dan treatment akustik yang optimal.</p>
              <ul class="mt-3">
                <li>Dead-silent environment</li>
                <li>Reflection filters premium</li>
                <li>Pop filter dan mic stand profesional</li>
                <li>Headphone monitoring sistem</li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="facility-card">
            <img src="/api/placeholder/600/400" alt="Lounge Area" class="facility-img">
            <div class="facility-content">
              <h3 class="facility-title">Lounge Area</h3>
              <p>Area santai untuk istirahat dan berdiskusi. Dilengkapi dengan fasilitas refreshment dan WiFi kecepatan tinggi.</p>
              <ul class="mt-3">
                <li>Sofa dan bean bags nyaman</li>
                <li>Coffee bar dan mini kitchen</li>
                <li>WiFi Fiber Optic 100 Mbps</li>
                <li>TV dan sound system</li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="facility-card">
            <img src="/api/placeholder/600/400" alt="Practice Room" class="facility-img">
            <div class="facility-content">
              <h3 class="facility-title">Practice Room</h3>
              <p>Ruang latihan dengan peralatan band lengkap untuk persiapan sebelum sesi rekaman atau untuk latihan reguler.</p>
              <ul class="mt-3">
                <li>Drum set lengkap</li>
                <li>Amplifier gitar dan bass</li>
                <li>PA system dan mixer</li>
                <li>Basic soundproofing</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Equipment Section -->
  <section class="equipment-section">
    <div class="container">
      <h2 class="section-title">Peralatan Studio</h2>
      <p class="section-subtitle">Kami menggunakan peralatan berkualitas tinggi untuk menghasilkan rekaman profesional</p>
      
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="equipment-card">
            <i class="fas fa-microphone equipment-icon"></i>
            <h3 class="equipment-title">Mikrofon</h3>
            <ul class="equipment-list">
              <li>Neumann U87 Condenser Microphone</li>
              <li>Shure SM7B Dynamic Microphone</li>
              <li>AKG C414 Condenser Microphone</li>
              <li>Rode NT1-A Condenser Microphone</li>
              <li>Shure SM57 & SM58 Dynamic Microphones</li>
              <li>Sennheiser MD421 Dynamic Microphone</li>
              <li>AKG D112 Bass Drum Microphone</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="equipment-card">
            <i class="fas fa-sliders-h equipment-icon"></i>
            <h3 class="equipment-title">Audio Interface & Preamp</h3>
            <ul class="equipment-list">
              <li>Universal Audio Apollo x16 Interface</li>
              <li>Focusrite Clarett 8Pre Interface</li>
              <li>Neve 1073 Preamp</li>
              <li>API 512c Preamp</li>
              <li>Universal Audio 610 Tube Preamp</li>
              <li>SSL Alpha Channel Strip</li>
              <li>DBX 160A Compressor</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="equipment-card">
            <i class="fas fa-headphones equipment-icon"></i>
            <h3 class="equipment-title">Monitor & Headphone</h3>
            <ul class="equipment-list">
              <li>Yamaha HS8 Studio Monitors</li>
              <li>Adam Audio A7X Studio Monitors</li>
              <li>Focal Shape 65 Studio Monitors</li>
              <li>Avantone MixCubes Reference Monitor</li>
              <li>Beyerdynamic DT 770 Pro Headphones</li>
              <li>Sennheiser HD 650 Headphones</li>
              <li>Audio-Technica ATH-M50x Headphones</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="equipment-card">
            <i class="fas fa-laptop equipment-icon"></i>
            <h3 class="equipment-title">DAW & Software</h3>
            <ul class="equipment-list">
              <li>Pro Tools Ultimate</li>
              <li>Logic Pro X</li>
              <li>Ableton Live Suite</li>
              <li>Universal Audio UAD-2 Plugins</li>
              <li>Waves Complete Plugin Bundle</li>
              <li>Native Instruments Komplete 13</li>
              <li>Melodyne Studio</li>
              <li>iZotope RX 9 Advanced</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="equipment-card">
            <i class="fas fa-guitar equipment-icon"></i>
            <h3 class="equipment-title">Instrumen</h3>
            <ul class="equipment-list">
              <li>Pearl Reference Drum Kit</li>
              <li>Fender American Professional II Stratocaster</li>
              <li>Gibson Les Paul Standard</li>
              <li>Fender Precision Bass</li>
              <li>Yamaha Grand Piano</li>
              <li>Nord Stage 3 Keyboard</li>
              <li>Various Acoustic Guitars</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="equipment-card">
            <i class="fas fa-plug equipment-icon"></i>
            <h3 class="equipment-title">Outboard Gear</h3>
            <ul class="equipment-list">
              <li>Universal Audio LA-2A Compressor</li>
              <li>Empirical Labs Distressor</li>
              <li>Lexicon PCM96 Reverb</li>
              <li>TC Electronic M6000 Multi-effects</li>
              <li>Avalon VT-737sp Channel Strip</li>
              <li>Manley Variable Mu Compressor</li>
              <li>API 2500 Bus Compressor</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Call to Action -->
  <section class="cta-section">
    <div class="container">
      <h2 class="cta-title">Siap Untuk Memulai Proyek Musik Anda?</h2>
      <p class="mb-4">Buat akun dan booking studio sekarang untuk mendapatkan pengalaman rekaman terbaik</p>
      <div>
        <a href="register.php" class="btn btn-studio">Daftar Akun</a>
        <a href="login.php" class="btn btn-studio btn-outline">Booking Studio</a>
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
          <a href="booking.php" class="footer-link">Booking</a>
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