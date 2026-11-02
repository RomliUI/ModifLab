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
    <title>Ringkasan - ModifLab Mobil</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: sans-serif; }
        body { background-color: #222; color: #fff; display: flex; height: 100vh; overflow: hidden; }
        
        aside { width: 250px; background-color: #1a1a1a; border-right: 1px solid #333; display: flex; flex-direction: column; justify-content: space-between; padding: 20px; }
        .sidebar-brand { font-size: 18px; font-weight: bold; color: #ff7b00; margin-bottom: 30px; }
        .nav-links { list-style: none; display: flex; flex-direction: column; gap: 10px; flex-grow: 1; }
        .nav-links a { color: #bbb; text-decoration: none; padding: 10px 12px; border-radius: 6px; display: block; font-size: 14px; }
        .nav-links a.active, .nav-links a:hover { background-color: #333; color: #fff; }
        .logout-btn { color: #ff4d4d; text-decoration: none; font-size: 14px; padding: 10px 0; display: block; cursor: pointer; }

        main { flex-grow: 1; overflow-y: auto; padding: 30px; position: relative; }
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .welcome-text h1 { font-size: 22px; margin-bottom: 5px; }
        .welcome-text p { font-size: 13px; color: #aaa; }
        .btn-add { background: #ff7b00; color: #fff; border: none; padding: 8px 15px; border-radius: 6px; font-weight: bold; cursor: pointer; }
        .btn-add:hover { background: #e06d00; }

        .data-section { background-color: #2b2b2b; border: 1px solid #3a3a3a; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 15px; color: #ff7b00; }
        
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }
        th { background-color: #333; color: #ccc; padding: 10px; border-bottom: 1px solid #444; }
        td { padding: 10px; border-bottom: 1px solid #333; color: #ddd; }
        
        .action-btns button { padding: 4px 8px; border-radius: 4px; border: none; cursor: pointer; font-size: 11px; margin-right: 4px; }
        .btn-edit { background: #3b82f6; color: #fff; }
        .btn-delete { background: #ef4444; color: #fff; }

        #toast {
            visibility: hidden; min-width: 250px; background-color: #333; color: #fff; text-align: center;
            border-radius: 6px; padding: 12px; position: fixed; z-index: 1000; right: 30px; bottom: 30px;
            font-size: 14px; box-shadow: 0px 4px 10px rgba(0,0,0,0.4); border-left: 5px solid #ff7b00;
            transition: visibility 0.3s, opacity 0.3s ease-in-out; opacity: 0;
        }
        #toast.show { visibility: visible; opacity: 1; }
        @media (max-width: 768px) { body { flex-direction: column; overflow: auto; } aside { width: 100%; height: auto; } main { height: auto; } }
    </style>
</head>
<body>

    <!-- SIDEBAR NAVIGASI BERBASIS PHP -->
    <aside>
        <div>
            <div class="sidebar-brand">ModifLab Mobil</div>
            <ul class="nav-links">
                <li><a href="index.php" class="active">1. Ringkasan</a></li>
                <li><a href="katalog.php">2. Katalog Part Mobil</a></li>
                <li><a href="proyek.php">3. Proyek Modifikasi</a></li>
                <li><a href="pengaturan.php">4. Pengaturan Akun</a></li>
            </ul>
        </div>
        <div>
            <!-- Tombol Logout menghapus Session via file logout.php -->
            <a href="logout.php" class="logout-btn">Keluar (Logout)</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main>
        <header>
            <div class="welcome-text">
                <!-- Menampilkan nama pengguna secara dinamis dari Session PHP -->
                <h1 id="greeting-title">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
                <p id="greeting-desc">Kelola data ringkasan modifikasi mobil Anda di sini.</p>
            </div>
            <button class="btn-add" id="btn-tambah">+ Tambah Data</button>
        </header>

        <div class="data-section" id="section-katalog">
            <div class="section-title">Data 1: Katalog Sparepart Mobil (Kategori/Part)</div>
            <table>
                <thead>
                    <tr>
                        <th>ID Part</th>
                        <th>Nama Komponen</th>
                        <th>Kategori</th>
                        <th>Estimasi Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="katalog-tbody">
                    <!-- Data dimuat dari Web Storage -->
                </tbody>
            </table>
        </div>
    </main>

    <div id="toast">Notifikasi berhasil!</div>

    <script>
        function showToast(message) {
            const toast = document.getElementById("toast");
            toast.innerText = message;
            toast.className = "show";
            setTimeout(() => { toast.className = toast.className.replace("show", ""); }, 3000);
        }

        let katalogData = JSON.parse(localStorage.getItem('katalog_mobil_db')) || [
            { id: 'P-001', nama: 'Velg Racing Volk Rays TE37 R17', kategori: 'Kaki-kaki', harga: 'Rp 6.500.000' }
        ];

        function renderTabel() {
            const tbody = document.getElementById('katalog-tbody');
            tbody.innerHTML = '';
            katalogData.forEach((item, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td>${item.kategori}</td>
                    <td>${item.harga}</td>
                    <td class="action-btns">
                        <button class="btn-edit" onclick="editData(${index})">Edit</button>
                        <button class="btn-delete" onclick="hapusData(${index})">Hapus</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
            localStorage.setItem('katalog_mobil_db', JSON.stringify(katalogData));
        }
        renderTabel();

        document.getElementById('btn-tambah').addEventListener('click', function() {
            alert("Sistem ModifLab: Menyiapkan form input data komponen baru.");
            let namaBaru = prompt("Masukkan nama komponen modifikasi mobil baru:", "Knalpot HKS Carbon");
            if (namaBaru && namaBaru.trim() !== "") {
                katalogData.push({ id: 'P-00' + (katalogData.length + 1), nama: namaBaru, kategori: 'Exhaust', harga: 'Rp 2.200.000' });
                renderTabel();
                showToast("Sukses: Data baru disimpan ke Web Storage!");
            }
        });

        document.getElementById('section-katalog').addEventListener('dblclick', () => showToast("Event dblclick: Area tabel diklik ganda."));
        const greetingTitle = document.getElementById('greeting-title');
        greetingTitle.addEventListener('mouseover', () => greetingTitle.style.color = '#ff7b00');
        greetingTitle.addEventListener('mouseout', () => greetingTitle.style.color = '#fff');
        document.addEventListener('keydown', (e) => { if(e.code === 'Space') { e.preventDefault(); showToast("Event keydown: Tombol Spasi ditekan."); } });

        function hapusData(index) {
            if(confirm("Yakin ingin menghapus data ini?")) {
                katalogData.splice(index, 1);
                renderTabel();
                showToast("Peringatan: Data dihapus!");
            }
        }
        function editData(index) {
            let namaBaru = prompt("Ubah nama komponen:", katalogData[index].nama);
            if(namaBaru) { katalogData[index].nama = namaBaru; renderTabel(); showToast("Informasi: Data diperbarui!"); }
        }
    </script>
</body>
</html>