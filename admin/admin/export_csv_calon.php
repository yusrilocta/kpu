<!DOCTYPE html>
<html>
<head>
    <title>Export Data Database ke CSV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Export Data Database ke CSV</h1>

        <?php
        // Koneksi ke database
include 'koneksi.php';

        // Proses export data ke file CSV
        if (isset($_POST['export'])) {
            $file_path = 'export_data.csv';
            $file = fopen($file_path, 'w');

            // Tuliskan header
            fputcsv($file, ['ID', 'ID Partai', 'Nama']);

            // Ambil data dari tabel "calon"
            $query = "SELECT * FROM calon";
            $stmt = $conn->query($query);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Tuliskan data ke dalam file CSV
                fputcsv($file, $row);
            }

            fclose($file);
            echo "Data berhasil di-export ke file CSV. <a href='$file_path'>Download</a>";
        }
        ?>

        <form method="POST">
            <button type="submit" name="export" class="btn btn-primary">Export to CSV</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
