
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "rap_studio");

// Proses booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = $_POST['tanggal'];
    $durasi = isset($_POST['durasi']) ? (int)$_POST['durasi'] : 1;
    $jam_mulai = isset($_POST['jam_mulai']) ? (int)$_POST['jam_mulai'] : 8;

    // Menentukan harga berdasarkan durasi
    $harga = 0;
    $dp_required = 0;
    switch ($durasi) {
        case 1:
            $harga = 40000;
            $dp_required = 10000;
            break;
        case 2:
            $harga = 70000;
            $dp_required = 20000;
            break;
        case 3:
            $harga = 110000;
            $dp_required = 30000;
            break;
        case 4:
            $harga = 140000;
            $dp_required = 40000;
            break;
    }

    $jam_list = [];
    for ($i = 0; $i < $durasi; $i++) {
        $jam_list[] = ($jam_mulai + $i) . ":00";
    }
    $jam_str = implode(",", $jam_list);

    // Cek bentrok booking
    $booked_slots = [];
    $stmt = $conn->prepare("SELECT jam FROM bookings WHERE tanggal=?");
    $stmt->bind_param("s", $tanggal);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $slots = explode(",", $row['jam']);
        foreach ($slots as $slot) {
            $booked_slots[] = trim($slot);
        }
    }

    $conflict = array_intersect($booked_slots, $jam_list);
    if (!empty($conflict)) {
        $error = "Jam bentrok dengan booking lain: " . implode(", ", $conflict);
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, tanggal, jam, status,bukti_dp, created_at) VALUES (?, ?, ?, 'Menunggu DP', ?, ?)");
        $stmt->bind_param("issii", $user_id, $tanggal, $jam_str, $bukti_dp, $created_at);
        $stmt->execute();
        $success = "Booking berhasil. Silakan upload bukti DP sebesar Rp " . number_format($bukti_dp, 0, ',', '.') . ".";
    }
}

// Proses upload bukti DP
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_dp'])) {
    $booking_id = $_POST['booking_id'];
    $file = $_FILES['bukti_dp'];

    $allowed_types = ['jpg', 'jpeg', 'png'];
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_types)) {
        $error = "Hanya file gambar (.jpg, .jpeg, .png) yang diperbolehkan.";
    } elseif ($file['size'] > 5000000) {
        $error = "Ukuran file terlalu besar. Maksimum 5MB.";
    } else {
        $filename = time() . '_' . $file['name'];
        $path = 'uploads/' . $filename;

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($file['tmp_name'], $path)) {
            $stmt = $conn->prepare("UPDATE bookings SET bukti_dp=?, status='Menunggu Konfirmasi' WHERE id=?");
            $stmt->bind_param("si", $filename, $booking_id);
            $stmt->execute();
            $success = "Bukti DP berhasil diupload.";
        } else {
            $error = "Gagal upload file.";
        }
    }
}

// Ambil riwayat booking
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id=? ORDER BY tanggal DESC, jam DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$riwayat = $stmt->get_result();

// Ambil info user
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - R.A.P Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-hover: #0099ff;
            --dark-bg: #121212;
            --card-bg: rgba(33, 37, 41, 0.8);
            --text-light: #f8f9fa;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }
        
        body {
            background: linear-gradient(135deg, #2b2d42 0%, #121212 100%);
            color: var(--text-light);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            padding-bottom: 40px;
        }
        
        .navbar {
            background: rgba(18, 18, 18, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            background: linear-gradient(45deg, #0d6efd, #00c6ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .dashboard-container {
            margin-top: 30px;
        }
        
        .welcome-card {
            background: linear-gradient(135deg, rgba(33, 37, 41, 0.9) 0%, rgba(28, 28, 30, 0.9) 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .section-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }
        
        .card-title {
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
            display: inline-block;
        }
        
        .card-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(45deg, var(--primary-color), var(--primary-hover));
            border-radius: 10px;
        }
        
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
            box-shadow: 0 0 15px rgba(13, 110, 253, 0.3);
            color: white;
        }
        
        .form-select option {
            background-color: #212529;
            color: white;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-hover));
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.5);
            background: linear-gradient(45deg, var(--primary-hover), var(--primary-color));
        }
        
        .btn-danger {
            background: linear-gradient(45deg, #dc3545, #ff5e6d);
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            transition: all 0.3s;
        }
        
        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.5);
            background: linear-gradient(45deg, #ff5e6d, #dc3545);
        }
        
        .btn-success {
            background: linear-gradient(45deg, var(--success-color), #20c997);
            border: none;
            border-radius: 50px;
            padding: 6px 15px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.5);
            background: linear-gradient(45deg, #20c997, var(--success-color));
        }
        
        .table {
            color: var(--text-light);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }
        
        .table th {
            background-color: rgba(0, 0, 0, 0.2);
            color: var(--text-light);
            font-weight: 600;
            border-color: rgba(255, 255, 255, 0.1);
            padding: 12px 15px;
        }
        
        .table td {
            border-color: rgba(255, 255, 255, 0.1);
            padding: 12px 15px;
            vertical-align: middle;
        }
        
        .table tr:hover td {
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .badge {
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 8px;
        }
        
        .badge.bg-success {
            background: linear-gradient(45deg, var(--success-color), #20c997) !important;
        }
        
        .badge.bg-warning {
            background: linear-gradient(45deg, var(--warning-color), #ffda6a) !important;
        }
        
        .badge.bg-secondary {
            background: linear-gradient(45deg, #6c757d, #adb5bd) !important;
        }
        
        .alert {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s;
        }
        
        .alert-success {
            background: linear-gradient(45deg, rgba(25, 135, 84, 0.9), rgba(32, 201, 151, 0.9));
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(45deg, rgba(220, 53, 69, 0.9), rgba(255, 94, 109, 0.9));
            color: white;
        }
        
        .file-upload {
            position: relative;
            overflow: hidden;
            margin-bottom: 10px;
        }
        
        .file-upload input[type=file] {
            font-size: 0.8rem;
            padding: 8px;
        }
        
        .profile-info {
            display: flex;
            align-items: center;
        }
        
        .profile-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, var(--primary-color), var(--primary-hover));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }
        
        .profile-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .profile-email {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .custom-date-input::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
        
        .booking-price {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(45deg, #0d6efd, #00c6ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 15px;
        }
        
        .booking-price small {
            font-size: 1rem;
            opacity: 0.8;
        }
        
        .calendar-hint {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 5px;
        }
        
        .dropdown-menu {
            background-color: #212529;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .dropdown-item {
            color: var(--text-light);
        }
        
        .dropdown-item:hover {
            background-color: #343a40;
            color: white;
        }
        
        .file-preview {
            width: 100%;
            height: 150px;
            border-radius: 8px;
            border: 2px dashed rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            overflow: hidden;
            position: relative;
            display: none;
        }
        
        .file-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        .pricing-info {
            background-color: rgba(13, 110, 253, 0.1);
            border-left: 3px solid var(--primary-color);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .features-list {
            list-style-type: none;
            padding-left: 0;
        }
        
        .features-list li {
            padding: 8px 0;
            display: flex;
            align-items: center;
        }
        
        .features-list li i {
            color: var(--primary-color);
            margin-right: 10px;
        }
        
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.3s;
            opacity: 0;
            visibility: hidden;
            z-index: 999;
        }
        
        .scroll-top.active {
            opacity: 1;
            visibility: visible;
        }
        
        .scroll-top:hover {
            background: var(--primary-hover);
            transform: translateY(-3px);
        }

        .price-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-bottom: 15px;
        }
        
        .price-table th {
            background-color: rgba(13, 110, 253, 0.1);
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            color: var(--text-light);
        }
        
        .price-table td {
            padding: 8px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 5px;
        }
        
        .dp-amount {
            color: #ffc107;
            font-weight: 600;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .welcome-card, .section-card {
                padding: 20px;
            }
            
            .table-responsive {
                font-size: 0.85rem;
            }
            
            .profile-info {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">R.A.P Studio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#booking"><i class="fas fa-calendar-plus me-1"></i> Booking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#riwayat"><i class="fas fa-history me-1"></i> Riwayat</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> Akun
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container dashboard-container">
        <!-- Alerts -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn">
                <i class="fas fa-check-circle me-2"></i> <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeIn">
                <i class="fas fa-exclamation-circle me-2"></i> <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Welcome Card -->
        <div class="welcome-card animate__animated animate__fadeIn">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="profile-info">
                        <div class="profile-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div class="profile-name">Selamat datang, <?= htmlspecialchars($_SESSION['nama']) ?>!</div>
                            <div class="profile-email"><?= htmlspecialchars($user['email'] ?? '') ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="logout.php" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="section-card animate__animated animate__fadeIn" id="booking">
            <h4 class="card-title"><i class="fas fa-calendar-plus me-2"></i>Booking Studio</h4>
            
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="pricing-info">
                        <h5><i class="fas fa-tags me-2"></i>R.A.P STUDIO PRODUCTION</h5>
                        <p>Daftar harga dan DP yang diperlukan:</p>
                        
                        <table class="price-table">
                            <thead>
                                <tr>
                                    <th>Durasi</th>
                                    <th>Harga</th>
                                    <th>DP Minimal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1 Jam</td>
                                    <td>Rp 40.000</td>
                                    <td class="dp-amount">Rp 10.000</td>
                                </tr>
                                <tr>
                                    <td>2 Jam</td>
                                    <td>Rp 70.000</td>
                                    <td class="dp-amount">Rp 20.000</td>
                                </tr>
                                <tr>
                                    <td>3 Jam</td>
                                    <td>Rp 110.000</td>
                                    <td class="dp-amount">Rp 30.000</td>
                                </tr>
                                <tr>
                                    <td>4 Jam</td>
                                    <td>Rp 140.000</td>
                                    <td class="dp-amount">Rp 40.000</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <ul class="features-list">
                            <li><i class="fas fa-check-circle"></i> Studio rekaman profesional</li>
                            <li><i class="fas fa-check-circle"></i> Peralatan audio berkualitas tinggi</li>
                            <li><i class="fas fa-check-circle"></i> Engineer studio berpengalaman</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <form method="POST" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-calendar-day me-2"></i>Tanggal:</label>
                    <input type="date" name="tanggal" class="form-control custom-date-input" required min="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-clock me-2"></i>Jam Mulai:</label>
                    <select name="jam_mulai" class="form-select" required>
                        <?php for ($i = 8; $i <= 21; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?>:00</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-hourglass-half me-2"></i>Durasi (jam):</label>
                    <select name="durasi" class="form-select" required id="durasiSelect">
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?> jam</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-6 mt-4 mb-2">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="mt-1 fs-6">
                                <span>DP: </span>
                                <span class="fw-bold text-warning" id="dpAmount">Rp 10.000 - Rp 40.000</span>
                            </div>
                        </div>
                        <button name="book" class="btn btn-primary">
                            <i class="fas fa-calendar-check me-2"></i>Booking Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Riwayat Booking -->
        <div class="section-card animate__animated animate__fadeIn" id="riwayat">
            <h4 class="card-title"><i class="fas fa-history me-2"></i>Riwayat Booking</h4>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="fas fa-calendar me-1"></i> Tanggal</th>
                            <th><i class="fas fa-clock me-1"></i> Jam</th>
                            <th><i class="fas fa-info-circle me-1"></i> Status</th>
                            <th><i class="fas fa-file-image me-1"></i> Bukti DP</th>
                            <th><i class="fas fa-upload me-1"></i> Upload</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($riwayat->num_rows > 0): ?>
                        <?php while ($row = $riwayat->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['tanggal']) ?></td>
                                <td><?= htmlspecialchars($row['jam']) ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Dikonfirmasi'): ?>
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i> Dikonfirmasi</span>
                                    <?php elseif ($row['status'] == 'Menunggu Konfirmasi'): ?>
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Menunggu Konfirmasi</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><i class="fas fa-hourglass me-1"></i> Menunggu DP</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['bukti_dp']): ?>
                                        <a href="uploads/<?= htmlspecialchars($row['bukti_dp']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye me-1"></i> Lihat
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted"><i class="fas fa-times-circle me-1"></i> Belum ada</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!$row['bukti_dp']): ?>
                                        <form method="POST" enctype="multipart/form-data" class="upload-form">
                                            <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                            <div class="file-preview" id="preview-<?= $row['id'] ?>"></div>
                                            <div class="file-upload">
                                                <input type="file" name="bukti_dp" class="form-control form-control-sm file-input" 
                                                       required accept="image/*" data-preview="preview-<?= $row['id'] ?>">
                                            </div>
                                            <button type="submit" name="upload_dp" class="btn btn-success btn-sm">
                                                <i class="fas fa-upload me-1"></i> Upload
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-success"><i class="fas fa-check-circle me-1"></i> Sudah Upload</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-calendar-xmark fa-2x mb-3 text-muted"></i>
                                <p class="mb-0">Belum ada riwayat booking. Silakan lakukan booking terlebih dahulu.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Scroll to top button -->
    <div class="scroll-top" id="scrollTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update total harga berdasarkan durasi
        const durasiSelect = document.getElementById('durasiSelect');
        const totalHarga = document.getElementById('totalHarga');
        const hargaPerJam = 100000;
        
        durasiSelect.addEventListener('change', function() {
            const durasi = parseInt(this.value);
            const total = durasi * hargaPerJam;
            totalHarga.textContent = 'Rp ' + total.toLocaleString('id-ID');
        });
        
        // File preview before upload
        const fileInputs = document.querySelectorAll('.file-input');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const previewId = this.getAttribute('data-preview');
                const previewDiv = document.getElementById(previewId);
                
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewDiv.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                        previewDiv.style.display = 'flex';
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
        
        // Scroll to top
        const scrollTop = document.getElementById('scrollTop');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTop.classList.add('active');
            } else {
                scrollTop.classList.remove('active');
            }
        });
        
        scrollTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Set minimum date for booking
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.min = tomorrow.toISOString().split('T')[0];
        });
        
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Auto close alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>
</body>
</html>