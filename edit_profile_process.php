<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $profilePicture = $_FILES['profile_picture'];

    $query = "UPDATE users SET username = :username, email = :email";

    // Periksa jika ada gambar baru
    if ($profilePicture['error'] === 0) {
        $uploadDir = 'uploads/';
        $fileExtension = pathinfo($profilePicture['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('profile_', true) . '.' . $fileExtension;
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($profilePicture['tmp_name'], $uploadPath)) {
            $query .= ", profile_picture = :profile_picture";
            $params[':profile_picture'] = $fileName;
        }
    }

    $query .= " WHERE id = :id";
    $params = [
        ':username' => $username,
        ':email' => $email,
        ':id' => $_SESSION['user_id']
    ];

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    echo "Profil berhasil diperbarui!";
}
?>
