<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$query = $conn->query("SELECT * FROM registration WHERE is_deleted = 0");
$registrations = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Registrasi</title>
</head>
<body>
    <h1>Kelola Registrasi</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Email</th>
                <th>Nama</th>
                <th>Institusi</th>
                <th>Negara</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrations as $reg): ?>
            <tr>
                <td><?php echo $reg['email']; ?></td>
                <td><?php echo $reg['name']; ?></td>
                <td><?php echo $reg['institution']; ?></td>
                <td><?php echo $reg['country']; ?></td>
                <td><?php echo $reg['address']; ?></td>
                <td>
                    <a href="edit_registration.php?id=<?php echo $reg['id']; ?>">Edit</a>
                    <a href="delete_registration.php?id=<?php echo $reg['id']; ?>">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
