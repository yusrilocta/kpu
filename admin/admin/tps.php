<?php include 'nav.php'; ?>

    <div class="container mt-5">

        <!-- Tambahkan tombol untuk menampilkan form tambah TPS -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTpsModal">
            Tambah TPS
        </button>

        <!-- Tampilkan tabel dengan data TPS -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kecamatan</th>
                    <th>Tempat</th>
                    <th>TPS</th>
                    <th>Pemilih Laki-laki</th>
                    <th>Pemilih Perempuan</th>
                    <th>Dua Persen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                include 'koneksi.php';

                // Fungsi untuk mendapatkan semua data TPS
                function getTps($conn) {
                    $query = "SELECT * FROM tps";
                    $stmt = $conn->query($query);
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                // Fungsi untuk menambahkan TPS baru

                function addTps($conn, $kec, $desa, $notps, $peml, $pemp, $duaper) {

                    $query = "INSERT INTO tps ( kec,desa, notps, peml, pemp, duaper) VALUES (:kec, :desa, :notps, :peml, :pemp, :duaper)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':kec', $kec);
                    $stmt->bindParam(':desa', $desa);
                    $stmt->bindParam(':notps', $notps);
                    $stmt->bindParam(':peml', $peml);
                    $stmt->bindParam(':pemp', $pemp);
                    $stmt->bindParam(':duaper', $duaper);
                    $stmt->execute();
                }

                // Fungsi untuk menghapus TPS berdasarkan ID
                function deleteTps($conn, $id) {
                    $query = "DELETE FROM tps WHERE id = :id";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                }

                // Fungsi untuk mengupdate data TPS
                function updateTps($conn,$id, $kec, $desa, $notps, $peml, $pemp, $duaper) {
                    $query = "UPDATE tps SET kec = :kec, desa = :desa,notps = :notps, peml = :peml, pemp = :pemp, duaper = :duaper WHERE id = :id";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':kec', $kec);
                    $stmt->bindParam(':desa', $desa);
                    $stmt->bindParam(':notps', $notps);
                    $stmt->bindParam(':peml', $peml);
                    $stmt->bindParam(':pemp', $pemp);
                    $stmt->bindParam(':duaper', $duaper);
                    $stmt->execute();
                }

                // Proses penambahan TPS
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tps'])) {
                    $kec = $_POST['kec'];
                    $desa = $_POST['desa'];
                    $notps = $_POST['notps'];
                    $peml = $_POST['peml'];
                    $pemp = $_POST['pemp'];
                    $duaper = ($peml + $pemp) * 0.2;

                    addTps($conn, $kec, $desa, $notps, $peml, $pemp, $duaper);
                    header("Location: tps.php");
                    exit();
                }

                // Proses penghapusan TPS
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tps'])) {
                    $id = $_POST['id'];

                    deleteTps($conn, $id);
                    header("Location: tps.php");
                    exit();
                }

                // Proses update TPS
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_tps'])) {
                    $id = $_POST['id'];
                    $kec = $_POST['kec'];
                    $desa = $_POST['desa'];
                    $notps = $_POST['notps'];
                    $peml = $_POST['peml'];
                    $pemp = $_POST['pemp'];
                    $duaper = ($peml + $pemp) * 0.2;

                    updateTps($conn, $id,$kec, $desa, $notps, $peml, $pemp, $duaper);
                    header("Location: tps.php");
                    exit();
                }

                // Menampilkan data TPS dalam tabel
                $tps = getTps($conn);
                foreach ($tps as $data) {
                    echo "<tr>";
                    echo "<td>{$data['id']}</td>";
                    echo "<td>{$data['kec']}</td>";
                    echo "<td>{$data['desa']}</td>";
                    echo "<td>{$data['notps']}</td>";
                    echo "<td>{$data['peml']}</td>";
                    echo "<td>{$data['pemp']}</td>";
                    echo "<td>{$data['duaper']}</td>";
                    echo "<td>";
                    echo "<button type='button' class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editTpsModal{$data['id']}'>Edit</button>";
                    echo "<form method='POST' class='d-inline-block' onsubmit=\"return confirm('Apakah Anda yakin ingin menghapus TPS ini?');\">";
                    echo "<input type='hidden' name='id' value='{$data['id']}'>";
                    echo "<button type='submit' class='btn btn-sm btn-danger' name='delete_tps'>Hapus</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";

                    // Modal untuk edit TPS
                    echo "<div class='modal fade' id='editTpsModal{$data['id']}' tabindex='-1' aria-labelledby='editTpsModalLabel{$data['id']}' aria-hidden='true'>";
                    echo "<div class='modal-dialog'>";
                    echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                    echo "<h5 class='modal-title' id='editTpsModalLabel{$data['id']}'>Edit TPS</h5>";
                    echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                    echo "</div>";
                    echo "<div class='modal-body'>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='id' value='{$data['id']}'>";
                    echo "<div class='mb-3'>";
                    echo "<label for='edit_tempat{$data['id']}' class='form-label'>Tempat</label>";
                    echo "<input type='text' class='form-control' id='edit_kec{$data['id']}' name='kec' value='{$data['kec']}' required>";
                    echo "</div>";
                    echo "<div class='mb-3'>";
                    echo "<label for='edit_kecamatan{$data['id']}' class='form-label'>Kecamatan</label>";
                    echo "<input type='text' class='form-control' id='edit_desa{$data['id']}' name='desa' value='{$data['desa']}' required>";
                    echo "</div>";
                    echo "<div class='mb-3'>";
                    echo "<label for='edit_kecamatan{$data['id']}' class='form-label'>Kecamatan</label>";
                    echo "<input type='text' class='form-control' id='edit_notps{$data['id']}' name='notps' value='{$data['notps']}' required>";
                    echo "</div>";
                    echo "<div class='mb-3'>";
                    echo "<label for='edit_peml{$data['id']}' class='form-label'>Pemilih Laki-laki</label>";
                    echo "<input type='text' class='form-control' id='edit_peml{$data['id']}' name='peml' value='{$data['peml']}' required>";
                    echo "</div>";
                    echo "<div class='mb-3'>";
                    echo "<label for='edit_pemp{$data['id']}' class='form-label'>Pemilih Perempuan</label>";
                    echo "<input type='text' class='form-control' id='edit_pemp{$data['id']}' name='pemp' value='{$data['pemp']}' required>";
                    echo "</div>";  
                    echo "<button type='submit' class='btn btn-primary' name='update_tps'>Simpan</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal untuk tambah TPS -->
        <div class="modal fade" id="addTpsModal" tabindex="-1" aria-labelledby="addTpsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTpsModalLabel">Tambah TPS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="tempat" class="form-label">Tempat</label>
                                <input type="text" class="form-control" id="kec" name="kec" required>
                            </div>
                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Desa</label>
                                <input type="text" class="form-control" id="desa" name="desa" required>
                            </div>
                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">TPS</label>
                                <input type="text" class="form-control" id="notps" name="notps" required>
                            </div>
                            <div class="mb-3">
                                <label for="peml" class="form-label">Pemilih Laki-laki</label>
                                <input type="text" class="form-control" id="peml" name="peml" required>
                            </div>
                            <div class="mb-3">
                                <label for="pemp" class="form-label">Pemilih Perempuan</label>
                                <input type="text" class="form-control" id="pemp" name="pemp" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_tps">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
