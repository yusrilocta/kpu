<!DOCTYPE html>
<html>
<head>
    <title>Import Data CSV ke Database</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Import Data CSV ke Database</h1>

        <?php
        // Koneksi ke database
 include 'koneksi.php';

        // Proses import data dari file CSV
        if (isset($_POST['submit'])) {
            if ($_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
                $file_tmp_path = $_FILES['csv_file']['tmp_name'];
                $handle = fopen($file_tmp_path, 'r');

                // Skip header row
                fgetcsv($handle);

                while (($data = fgetcsv($handle)) !== false) {
                    $id_tps = $data[0];
                    $kec = $data[1];
                    $desa = $data[2];
                    $notps = $data[3];
                    $peml = $data[4];
                    $pemp = $data[5];
                    $duaper = $data[6];
                    $id_calon = $data[7];
                    $nama_calon = $data[8];
                    $nama_partai = $data[9];
                    $no_urut = $data[10];
                    $tpl = $data[11];
                    $tpp = $data[12];
                    $tdua = $data[13];

                        

                        // Insert data ke dalam tabel "calon"
                        $querysatu = "
                        INSERT INTO tps (kec, desa, notps,peml,pemp,duaper) VALUES (:kec, :desa, :notps,:peml,:pemp,:duaper);
                        INSERT INTO pemilu (id_tps, id_calon, pemp, peml, total) VALUES (:id_tps, :id_calon, :pempss, :pemlss, :total);
                        INSERT INTO calon (nama_calon, nama_partai, no_urut) VALUES (:nama_calon, :nama_partai, :no_urut);

                        ";
                        $stmt = $conn->prepare($querysatu);
                        $stmt->bindParam(':kec', $kec);
                        $stmt->bindParam(':desa', $desa);
                        $stmt->bindParam(':notps', $notps);
                        $stmt->bindParam(':peml', $peml);
                        $stmt->bindParam(':pemp', $pemp);
                        $stmt->bindParam(':duaper', $duaper);
                        $stmt->bindParam(':nama_calon', $nama_calon);
                        $stmt->bindParam(':nama_partai', $nama_partai);
                        $stmt->bindParam(':no_urut', $no_urut);
                        $stmt->bindParam(':id_tps', $id_tps);
                        $stmt->bindParam(':id_calon', $id_calon);
                        $stmt->bindParam(':pempss', $tpp);
                        $stmt->bindParam(':pemlss', $tpl);
                        $stmt->bindParam(':total', $tdua);

                    try {
                        $stmt->execute();
                    } catch (PDOException $e) {
                        echo "Terjadi kesalahan: " . $e->getMessage();
                        break;
                    }
                }

                fclose($handle);
                echo "Data berhasil diimpor dari file CSV.";
            } else {
                echo "Terjadi kesalahan saat mengunggah file CSV.";
            }
        }
        ?>

        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="csv_file" required>
            <button type="submit" name="submit" class="btn btn-primary">Import</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
