<!-- crud.php -->
<?php

include 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD - User Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>CRUD - User Management</h1>

        <!-- Tambahkan tombol untuk menampilkan form tambah user -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Tambah User
        </button>

        <!-- Tampilkan tabel dengan data user -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tahun Masuk</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../koneksi.php';
                // Fungsi untuk mendapatkan semua data user
                function getUser($conn) {
                    $kpps = "kpps";
                    $query = "SELECT * FROM user where role = :kpps";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':kpps', $kpps);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                // Fungsi untuk menambahkan user baru
                function addUser($conn, $id_user, $nama, $thmasuk, $role) {
                    $query = "INSERT INTO user (id, nama, thmasuk, role) VALUES (:id_user, :nama, :thmasuk, :role)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id_user', $id_user);
                    $stmt->bindParam(':nama', $nama);
                    $stmt->bindParam(':thmasuk', $thmasuk);
                    $stmt->bindParam(':role', $role);
                    $stmt->execute();
                }

                // Fungsi untuk menghapus user berdasarkan ID
                function deleteUser($conn, $id) {
                    $query = "DELETE FROM user WHERE id = :id";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                }

                // Fungsi untuk mengupdate data user
                function updateUser($conn, $id, $nama, $thmasuk, $role) {
                    $query = "UPDATE user SET nama = :nama, thmasuk = :thmasuk, role = :role WHERE id = :id";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':nama', $nama);
                    $stmt->bindParam(':thmasuk', $thmasuk);
                    $stmt->bindParam(':role', $role);
                    $stmt->execute();
                }

                // Proses penambahan user
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
                    $id_user = $_POST['id_user'];
                    $nama = $_POST['nama'];
                    $thmasuk = $_POST['thmasuk'];
                    $role = $_POST['role'];

                    addUser($conn,$id_user, $nama, $thmasuk, $role);
                    header("Location: crud.php");
                    exit();
                }

                // Proses penghapusan user
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
                    $id = $_POST['id'];

                    deleteUser($conn, $id);
                    header("Location: crud.php");
                    exit();
                }

                // Proses update user
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
                    $id = $_POST['id'];
                    $nama = $_POST['nama'];
                    $thmasuk = $_POST['thmasuk'];
                    $role = $_POST['role'];

                    updateUser($conn, $id, $nama, $thmasuk, $role);
                    header("Location: crud.php");
                    exit();
                }

                // Menampilkan data user dalam tabel
                $users = getUser($conn);
                foreach ($users as $data) {
                    echo "<tr>";
                    echo "<td>{$data['id']}</td>";
                    echo "<td>{$data['nama']}</td>";
                    echo "<td>{$data['thmasuk']}</td>";
                    echo "<td>{$data['role']}</td>";
                    echo "<td>";
                    echo "<button type='button' class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editUserModal{$data['id']}'>Edit</button>";
                    echo "<form method='POST' class='d-inline-block' onsubmit=\"return confirm('Apakah Anda yakin ingin menghapus user ini?');\">";
                    echo "<input type='hidden' name='id' value='{$data['id']}'>";
                    echo "<button type='submit' class='btn btn-sm btn-danger' name='delete_user'>Hapus</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";

                    // Modal untuk edit user
                    echo "<div class='modal fade' id='editUserModal{$data['id']}' tabindex='-1' aria-labelledby='editUserModalLabel{$data['id']}' aria-hidden='true'>";
                    echo "<div class='modal-dialog'>";
                    echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                    echo "<h5 class='modal-title' id='editUserModalLabel{$data['id']}'>Edit User</h5>";
                    echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                    echo "</div>";
                    echo "<div class='modal-body'>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='id' value='{$data['id']}'>";
                    echo "<div class='mb-3'>";
                    echo "<label for='edit_nama{$data['id']}' class='form-label'>Nama</label>";
                    echo "<input type='text' class='form-control' id='edit_nama{$data['id']}' name='nama' value='{$data['nama']}' required>";
                    echo "</div>";
                    echo "<div class='mb-3'>";
                    echo "<label for='edit_thmasuk{$data['id']}' class='form-label'>Tahun Masuk</label>";
                    echo "<input type='text' class='form-control' id='edit_thmasuk{$data['id']}' name='thmasuk' value='{$data['thmasuk']}' required>";
                    echo "</div>";
                    echo "<div class='mb-3'>";
                    echo "<label for='edit_role{$data['id']}' class='form-label'>Role</label>";
                    echo "<input type='text' class='form-control' id='edit_role{$data['id']}' name='role' value='{$data['role']}' required>";
                    echo "</div>";
                    echo "<button type='submit' class='btn btn-primary' name='update_user'>Simpan</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal untuk tambah user -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                        <div class="mb-3">
                                <label for="id_user" class="form-label">WhatsApp</label>
                                <input type="text" class="form-control" id="id_user" name="id_user" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="thmasuk" class="form-label">Tahun Masuk</label>
                                <input type="text" class="form-control" id="thmasuk" name="thmasuk" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" class="form-control" id="role" name="role" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_user">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'footer.php' ?>