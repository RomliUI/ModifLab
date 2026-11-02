<?php
session_start();
// Jika form dikirimkan, simpan nama pengguna ke dalam Session
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['username'])) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ModifLab Planner</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: sans-serif; }
        body { background-color: #2b2b2b; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-card { background-color: #383838; padding: 30px; border-radius: 12px; width: 380px; box-shadow: 0 4px 10px rgba(0,0,0,0.5); text-align: center; }
        h2 { margin-bottom: 10px; font-size: 20px; color: #ff7b00; }
        p.sub { font-size: 12px; color: #aaa; margin-bottom: 20px; }
        .form-group { text-align: left; margin-bottom: 15px; }
        label { display: block; font-size: 12px; margin-bottom: 5px; color: #ccc; }
        input { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #555; background: #222; color: #fff; font-size: 14px; }
        .btn { width: 100%; padding: 10px; background: #ff7b00; border: none; border-radius: 6px; color: #fff; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .btn:hover { background: #e06d00; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>ModifLab Login</h2>
        <p class="sub">Masukkan nama Anda untuk memulai sesi</p>
        <form method="POST" action="">
            <div class="form-group">
                <label>Nama Pengguna</label>
                <input type="text" name="username" placeholder="Contoh: Garage Master" required>
            </div>
            <button type="submit" class="btn">Masuk</button>
        </form>
    </div>
</body>
</html>