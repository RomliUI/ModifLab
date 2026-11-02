<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ModifLab Planner</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: sans-serif; }
        body { background-color: #222; color: #fff; display: flex; height: 100vh; overflow: hidden; }
        
        /* Sidebar Admin */
        aside { width: 250px; background-color: #1a1a1a; border-right: 1px solid #333; display: flex; flex-direction: column; justify-content: space-between; padding: 20px; }
        .sidebar-brand { font-size: 18px; font-weight: bold; color: #ff7b00; margin-bottom: 30px; }
        .nav-links { list-style: none; display: flex; flex-direction: column; gap: 10px; flex-grow: 1; }
        .nav-links a { color: #bbb; text-decoration: none; padding: 10px 12px; border-radius: 6px; display: block; font-size: 14px; }
        .nav-links a.active, .nav-links a:hover { background-color: #333; color: #fff; }
        .logout-btn { color: #ff4d4d; text-decoration: none; font-size: 14px; padding: 10px 0; display: block; }

        /* Main Content Admin */
        main { flex-grow: 1; overflow-y: auto; padding: 30px; }
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .welcome-text h1 { font-size: 22px; margin-bottom: 5px; color: #ff7b00; }
        .welcome-text p { font-size: 13px; color: #aaa; }

        /* Statistik / Panel Info */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background-color: #2b2b2b; border: 1px solid #3a3a3a; border-radius: 8px; padding: 20px; }
        .stat-card h3 { font-size: 14px; color: #aaa; margin-bottom: 8px; }
        .stat-card p { font-size: 24px; font-weight: bold; color: #fff; }

        /* Tabel Kontrol Admin */
        .data-section { background-color: #2b2b2b; border: 1px solid #3a3a3a; border-radius: 8px; padding: 20px; }
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 15px; color: #ff7b00; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }
        th { background-color: #333; color: #ccc; padding: 10px; border-bottom: 1px solid #444; }
        td { padding: 10px; border-bottom: 1px solid #333; color: #ddd; }
        .badge { background: #ff7b00; color: #fff; padding: 3px 8px; border-radius: 4px; font-size: 11px; }

        @media (max-width: 768px) {
            body { flex-direction: column; overflow: auto; }
            aside { width: 100%; height: auto; }
            main { height: auto; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR ADMIN -->
    <aside>
        <div>
            <div class="sidebar-brand">Admin Panel - ModifLab</div>
            <ul class="nav-links">
                <li><a href="admin.php" class="active">Dashboard Admin</a></li>
                <li><a href="index.php">Kembali ke Web Utama</a></li>
            </ul>
        </div>
        <div>
            <!-- Tombol Logout menghapus Session -->
            <a href="logout.php" class="logout-btn">Keluar (Logout)</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main>
        <header>
            <div class="welcome-text">
                <h1>Panel Kontrol Administrator</h1>
                <!-- Menampilkan nama admin yang sedang aktif berdasarkan Session PHP -->
                <p>Selamat datang kembali, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>! Berikut ringkasan sistem.</p>
            </div>
        </header>

        <!-- KARTU STATISTIK SISTEM -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Pengguna Aktif (Session)</h3>
                <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
            </div>
            <div class="stat-card">
                <h3>Status Sesi PHP</h3>
                <p style="color: #4ade80;">Aktif / Secure</p>
            </div>
            <div class="stat-card">
                <h3>Total Menu Sistem</h3>
                <p>4 Modul PHP</p>
            </div>
        </div>

        <!-- TABEL MANAJEMEN PENGGUNA -->
        <div class="data-section">
            <div class="section-title">Dapat Dikelola Melalui Sesi PHP</div>
            <table>
                <thead>
                    <tr>
                        <th>Sesi Aktif</th>
                        <th>Waktu Akses</th>
                        <th>Hak Akses</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($_SESSION['username']); ?></td>
                        <td><?php echo date('d-m-Y H:i:s'); ?></td>
                        <td><span class="badge">Administrator</span></td>
                        <td><a href="logout.php" style="color: #ef4444; text-decoration: none; font-weight: bold;">Akhiri Sesi</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>