<?php 
include '../../admin/koneksi.php';
include 'header.php';
        // Fungsi untuk mendapatkan data tps dari tabel "tps"
        function getTpsData($conn){

            $gg = $_SESSION['username'];
            $query = "SELECT * FROM tps where handle = :handle";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':handle', $gg);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // Fungsi untuk mendapatkan data calon dari tabel "calon"
        function getCalonData($conn)
        {
            $calon = $_POST['id'];
            $query = "SELECT * FROM calon WHERE id = $calon";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function getPemiluData($conn)
        {
            $query = "SELECT * FROM pemilu";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // Proses pengeditan masal data pemilu
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Data array yang ingin di-input ke database
            $data = array(
                'id_calon' => $_POST['id_calon'],
                'id_tps' => $_POST['id_tps'],
                'peml' => $_POST['peml'],
            );
        
            // Koneksi ke database
            $host = 'localhost';
            $db_user = 'root';
            $db_pass = '';
            $db_name = 'admin';
        
            $conn = new mysqli($host, $db_user, $db_pass, $db_name);
        
            // Cek koneksi ke database
            if ($conn->connect_error) {
                die("Koneksi ke database gagal: " . $conn->connect_error);
            }
        
            // Query untuk meng-input data array ke dalam tabel "pemilu"
            $query = "INSERT INTO pemilu (id_calon, id_tps, peml, total) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
        
            // Binding parameter ke statement
            $stmt->bind_param('ssss', $id_calon, $id_tps, $peml, $total);
        
            // Looping untuk menginput data dari array
            foreach ($data['id_calon'] as $key => $value) {
                $id_calon = $value;
                $id_tps = $data['id_tps'][$key];
                $peml = $data['peml'][$key];
                $total = $peml;
        
                // Eksekusi query untuk setiap data
                if ($stmt->execute()) {
                    echo "Data berhasil di-input ke database.";
                    
                } else {
                    echo "Terjadi kesalahan: " . $stmt->error;
                    break; // Berhenti jika terjadi kesalahan pada salah satu data
                }
            }
            $stmt->close();
        $conn->close();
        header("location: calon.php");
        }
        

      ?>

   <div class="col card container">
        <!-- Form untuk menampilkan data pemilu dan memungkinkan pengeditan masal -->
        <form method="POST">
            <table class="table">
                <thead>
                    <tr>
                        
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>TPS</th>
                        <th>Pemilih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pemiluData = getPemiluData($conn);
                    $tpsData = getTpsData($conn);
                    $calonData = getCalonData($conn);

                    foreach ($tpsData as $data) {
                        echo "<tr>";    
                        echo "<td>{$data['kec']}</td>";
                        echo "<td>{$data['desa']}</td>";
                        echo "<td>{$data['notps']}</td>";
                        echo "<input type='hidden'class='form-control' value='{$data['id']}' name='id_tps[]'>";
                        foreach ($calonData as $calon) {
                           // echo "<td>{$calon['nama']}</td>";
                            echo "<input type='hidden'class='form-control' value='{$calon['id']}' name='id_calon[]'>";
                            
                        }
                        
                        echo "<td><input type='text' class='form-control' name='peml[]'></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary ">Simpan Perubahan</button>
            </div>
        </form>
        
    </div>



<?php 
include 'footer.php'; ?>