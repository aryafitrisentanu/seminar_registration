<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $institution = $_POST['institution'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    // Cek apakah email sudah terdaftar
    $query = $conn->prepare("SELECT * FROM registration WHERE email = ? AND is_deleted = 0");
    $query->execute([$email]);

    if ($query->rowCount() > 0) {
        echo "Email sudah digunakan!";
    } else {
        // Masukkan data ke database
        $stmt = $conn->prepare("INSERT INTO registration (email, name, institution, country, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$email, $name, $institution, $country, $address]);
        echo "Pendaftaran berhasil!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Seminar</title>
</head>
<body>
    <h1>Registrasi Seminar</h1>
    <form method="POST" action="register.php">
        Email: <input type="email" name="email" required><br>
        Nama: <input type="text" name="name" required><br>
        Institusi: <input type="text" name="institution" required><br>
        Negara: <input type="text" name="country" required><br>
        Alamat: <textarea name="address" required></textarea><br>
        <input type="submit" value="Daftar">
    </form>
</body>
</html>
