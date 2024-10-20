<?php
require 'db_connection.php'; // Ganti dengan 'db.php' jika itu nama file Anda
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $db->prepare("SELECT * FROM registration WHERE id = ? AND is_deleted = 0");
    $query->execute([$id]);
    $registration = $query->fetch(PDO::FETCH_ASSOC);

    // Jika data tidak ditemukan
    if (!$registration) {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak disediakan.";
    exit;
}

// Proses update jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $institution = $_POST['institution'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    // Cek apakah email sudah ada (kecuali untuk email yang sama)
    $checkEmail = $db->prepare("SELECT * FROM registration WHERE email = ? AND id != ? AND is_deleted = 0");
    $checkEmail->execute([$email, $id]);

    if ($checkEmail->rowCount() > 0) {
        echo "Email sudah terdaftar.";
    } else {
        // Update data peserta
        $stmt = $db->prepare("UPDATE registration SET email = ?, name = ?, institution = ?, country = ?, address = ? WHERE id = ?");
        if ($stmt->execute([$email, $name, $institution, $country, $address, $id])) {
            header("Location: manage_registrations.php");
            exit;
        } else {
            echo "Gagal mengupdate data.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pendaftaran</title>
</head>
<body>
    <h1>Edit Pendaftaran</h1>
    <form action="edit_registration.php?id=<?php echo $id; ?>" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($registration['email']); ?>" required><br>
        
        <label>Nama:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($registration['name']); ?>" required><br>
        
        <label>Institusi:</label><br>
        <input type="text" name="institution" value="<?php echo htmlspecialchars($registration['institution']); ?>"><br>
        
        <label>Negara:</label><br>
        <input type="text" name="country" value="<?php echo htmlspecialchars($registration['country']); ?>"><br>
        
        <label>Alamat:</label><br>
        <textarea name="address"><?php echo htmlspecialchars($registration['address']); ?></textarea><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>
