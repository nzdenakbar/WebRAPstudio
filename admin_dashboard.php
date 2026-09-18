<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "rap_studio");

// Konfirmasi booking
if (isset($_GET['konfirmasi'])) {
    $id = intval($_GET['konfirmasi']);
    $conn->query("UPDATE bookings SET status = 'Dikonfirmasi' WHERE id = $id");
    header("Location: admin_dashboard.php");
    exit;
}

// Ambil daftar booking
$bookings = $conn->query("SELECT * FROM bookings ORDER BY tanggal DESC, jam DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - R.A.P Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h3>Selamat datang, Admin <?= $_SESSION['username'] ?></h3>
        <a href="logout.php" class="btn btn-danger float-end">Logout</a>

        <h4>Daftar Booking</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th>Bukti DP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['tanggal'] ?></td>
                        <td><?= $row['jam'] ?></td>
                        <td>
                            <?php if ($row['status'] === 'Dikonfirmasi'): ?>
                                <span class="badge bg-success">Dikonfirmasi</span>
                            <?php elseif ($row['status'] === 'Menunggu Konfirmasi'): ?>
                                <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Menunggu DP</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['bukti_dp']): ?>
                                <a href="uploads/<?= $row['bukti_dp'] ?>" target="_blank">Lihat</a>
                            <?php else: ?>
                                Belum ada
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] === 'Menunggu Konfirmasi'): ?>
                                <a href="?konfirmasi=<?= $row['id'] ?>" class="btn btn-success btn-sm">Konfirmasi</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
