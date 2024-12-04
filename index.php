<?php
include 'db/connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pendaftaran PKL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <h1>Welcome, <?= $user['name'] ?></h1>
        <p>Bio: <?= $user['bio'] ?></p>

        <div class="action-grid">
            <a href="edit_profile.php" class="action-card">
                <i class="fas fa-user-edit"></i>
                <span>Edit Profile</span>
            </a>
        </div>

        <a href="logout.php" class="back">Logout</a>
    </div>
</body>

</html>

