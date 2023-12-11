<?php include 'nav.php'; ?>
<?php
// Koneksi ke database
$host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'admin';

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel tps dan pemilu
$query = "SELECT tps.id AS id_tps, tps.kec, tps.desa, tps.notps, tps.peml, tps.pemp,
                 SUM(pemilu.peml) AS calon_1_peml,
                 SUM(pemilu.pemp) AS calon_1_pemp
          FROM tps
          LEFT JOIN pemilu ON tps.id = pemilu.id_tps
          GROUP BY tps.id, tps.kec, tps.desa, tps.notps
          ORDER BY tps.id";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemilu</title>
</head>
<body>
<div class="container mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>kec</th>
                    <th>desa</th>
                    <th>notps</th>
                    <th>Data Laki</th>
                    <th>Hasil laki-laki</th>
                    <th>Hasil</th>
                    <th>Data Per</th>
                    <th>Hasil perempuan</th>
                    <th>Hasil</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_tps"] . "</td>";
                        echo "<td>" . $row["kec"] . "</td>";
                        echo "<td>" . $row["desa"] . "</td>";
                        echo "<td>" . $row["notps"] . "</td>";
                        echo "<td>" . $row["peml"] . "</td>";
                        echo "<td>" . $row["calon_1_peml"] . "</td>";
                        if ($row['calon_1_peml'] > $row['peml']){
                            $t = "dipertanyakan";
                        } else{
                            $t = "Layak";
                        }
                        echo "<td>" . $t . "</td>";
                        echo "<td>" . $row["pemp"] . "</td>";
                        echo "<td>" . $row["calon_1_pemp"] . "</td>";
                        if ($row['calon_1_pemp'] > $row['pemp']){
                            $l = "dipertanyakan";
                        } else{
                            $l = "Layak";
                        }
                        echo "<td>" . $l . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

<?php
$conn->close();
?>


<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>