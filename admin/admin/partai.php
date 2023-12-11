<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD - Partai Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary container-fluid ">
  <div class="container">
    <a class="navbar-brand" href="#">Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Beranda</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li> -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Data
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="partai.php">Partai</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="tps.php">Tps</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link active h2" aria-current="page" href="calon.php">Calon</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active h2" aria-current="page" href="pemilu.php">Data Pemilu</a>
        </li>
      </ul>
      <ul class="navbar-nav d-flex">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php echo $_SESSION['username']; ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="crud.php">Edit Data</a></li>
            <li><hr class="dropdown-divider"></li>
            <form method="POST">
        <button class="dropdown-item btn" type="submit" name="logout">Logout</button>
    </form>
          </ul>
        </li>
</ul>
    </div>
  </div>
</nav>

    <div class="container">
        <br/>

        <!-- Tambahkan tombol untuk menampilkan form tambah partai -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPartaiModal">
            Tambah Partai
        </button>

        <!-- Tampilkan tabel dengan data partai -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Partai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                include 'koneksi.php';
                // Fungsi untuk mendapatkan semua data partai
                function getPartai($conn) {
                    $query = "SELECT * FROM partai";
                    $stmt = $conn->query($query);
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                // Fungsi untuk menambahkan partai baru
                function addPartai($conn, $nama_partai) {
                    $query = "SELECT id FROM partai ORDER BY id DESC LIMIT 1";
                    $stmt = $conn->query($query);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $result['id'];
                    $newId = $result['id'] + 1;

                    $query = "INSERT INTO partai (id, nama_partai) VALUES ($newId, :nama_partai)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':nama_partai', $nama_partai);
                    $stmt->execute();
                }

                // Fungsi untuk menghapus partai berdasarkan ID
                function deletePartai($conn, $id) {
                    $query = "DELETE FROM partai WHERE id = :id";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                }

                // Fungsi untuk mengupdate data partai
                function updatePartai($conn, $id, $nama_partai) {
                    $query = "UPDATE partai SET nama_partai = :nama_partai WHERE id = :id";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':nama_partai', $nama_partai);
                    $stmt->execute();
                }

                // Proses penambahan partai

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_partai'])) {
                    $nama_partai = $_POST['nama_partai'];

                    addPartai($conn, $nama_partai);
                    header("Location: partai.php");
                    exit();
                }

                // Proses penghapusan partai
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_partai'])) {
                    $id = $_POST['id'];

                    deletePartai($conn, $id);
                    header("Location: partai.php");
                    exit();
                }

                // Proses update partai
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_partai'])) {
                    $id = $_POST['id'];
                    $nama_partai = $_POST['nama_partai'];

                    updatePartai($conn, $id, $nama_partai);
                    header("Location: partai.php");
                    exit();
                }

                // Menampilkan data partai dalam tabel
                $partai = getPartai($conn);
                foreach ($partai as $data) {
                    echo "<tr>";
                    echo "<td>{$data['id']}</td>";
                    echo "<td>{$data['nama_partai']}</td>";
                    echo "<td>";
                    echo "<button type='button' class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editPartaiModal{$data['id']}'>Edit</button>";
                    echo "<form method='POST' class='d-inline-block' onsubmit=\"return confirm('Apakah Anda yakin ingin menghapus partai ini?');\">";
                    echo "<input type='hidden' name='id' value='{$data['id']}'>";
                    echo "<button type='submit' class='btn btn-sm btn-danger' name='delete_partai'>Hapus</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";

                    // Modal untuk edit partai
                    echo "<div class='modal fade' id='editPartaiModal{$data['id']}' tabindex='-1' aria-labelledby='editPartaiModalLabel{$data['id']}' aria-hidden='true'>";
                    echo "<div class='modal-dialog'>";
                    echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                    echo "<h5 class='modal-title' id='editPartaiModalLabel{$data['id']}'>Edit Partai</h5>";
                    echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                    echo "</div>";
                    echo "<div class='modal-body'>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='id' value='{$data['id']}'>";
                    echo "<div class='mb-3'>";
                    echo "<label for='edit_nama_partai{$data['id']}' class='form-label'>nama_partai Partai</label>";
                    echo "<input type='text' class='form-control' id='edit_nama_partai{$data['id']}' name='nama_partai' value='{$data['nama_partai']}' required>";
                    echo "</div>";
                    echo "<button type='submit' class='btn btn-primary' name='update_partai'>Simpan</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal untuk tambah partai -->
        <div class="modal fade" id="addPartaiModal" tabindex="-1" aria-labelledby="addPartaiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPartaiModalLabel">Tambah Partai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="nama_partai" class="form-label">nama_partai Partai</label>
                                <input type="text" class="form-control" id="nama_partai" name="nama_partai" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_partai">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
