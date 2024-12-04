<?php
include 'db/connection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data dari form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi konfirmasi password
    if ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok.';
    } else {
        // Enkripsi password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Persiapkan query untuk memasukkan data ke database
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password_hash]);
            // Redirect ke halaman login setelah berhasil
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            // Tangani kesalahan saat proses pendaftaran
            $error = 'Pendaftaran gagal: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pendaftaran PKL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <h2><i class="fas fa-user-plus"></i> Register</h2>
        <p>Buat akun baru untuk mendaftar PKL.</p>

        <!-- Menampilkan pesan error jika ada -->
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" id="name" name="name" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <p class="auth-footer">
            Sudah punya akun? <a href="login.php">Masuk di sini</a>
        </p>
    </div>
</body>
</html>
