<?php
// Sertakan file koneksi ke database
include 'db/connection.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';
$user_id = $_SESSION['user_id'];

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $bio = trim($_POST['bio']);

    // Validasi input
    if (empty($name)) {
        $error = 'Name is required.';
    } else {
        try {
            // Update data pengguna
            $stmt = $pdo->prepare("UPDATE users SET name = :name, bio = :bio WHERE id = :id");
            $stmt->execute(['name' => $name, 'bio' => $bio, 'id' => $user_id]);
            $success = 'Profile updated successfully!';
        } catch (PDOException $e) {
            $error = 'Update failed: ' . $e->getMessage();
        }
    }
}

// Ambil data pengguna untuk ditampilkan di form
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();

if (!$user) {
    die('User not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Profile</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="<?= htmlspecialchars($user['name']) ?>" 
                    class="form-control" 
                    required>
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea 
                    name="bio" 
                    id="bio" 
                    class="form-control" 
                    rows="5"><?= htmlspecialchars($user['bio']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
