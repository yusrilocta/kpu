<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.php");
    exit();
}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengeditan Masal Pemilu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
@import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap');

.card {
    width: 100%;
       border-radius: 20px; 
       overflow: hidden;
       border: 0;
       box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06),
                   0 2px 4px rgba(0, 0, 0, 0.07);
       transition: all 0.15s ease;
}

.card:hover {
             box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1),
                         0 10px 8px rgba(0, 0, 0, 0.015);
}

.card-body .card-title {
                  font-family: 'Lato', sans-serif;
                  font-weight: 700;
                  letter-spacing: 0.3px;
                  font-size: 24px;
                  color: #121212;
}

.card-text {
             font-family: 'Lato', sans-serif;
             font-weight: 400;
             font-size: 15px;
             letter-spacing: 0.3px;
             color: #4E4E4E;
  
}

.card .container {
           width: 88%;
          background: #F0EEF8;
           border-radius: 30px;
           height: 140px;
        align-items: center;
         justify-content: center;
}

.container:hover > img {
                       transform: scale(1.2);
}

.container img {
                padding: 75px;  
               margin-top: -40px;
               margin-bottom: -40px;
              transition: 0.4s ease;
              cursor: pointer;
}

.btn {
      background: #EEECF7;
      border: 0;
      color: #5535F0;
      width: 98%;
      font-weight: bold;
      border-radius: 20px;
      height: 40px;
      transition: all 0.2s ease;
}

.btn:hover {
            background: #441CFF;
}

.btn:focus {
            background: #441CFF;
            outline: 0;  
}
 

 
    </style>
</head>
<body>
    <div class="container">
    <div class="card mb-5 mt-5">
  <div class="card-body mx-auto">
    <h5 class="card-title">Proses Input Data Pemilih Calon</h5>
    <p class="card-text">Mohon Perhatikan Data dengan Benar</p>
  </div>
</div>
        <?php
        // Koneksi ke database
        include 'koneksi.php';

        // Fungsi untuk mendapatkan data tps dari tabel "tps"
        function getTpsData($conn)
        {
            $query = "SELECT * FROM tps";
            $stmt = $conn->query($query);
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
                'pemp' => $_POST['pemp'],
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
            $query = "INSERT INTO pemilu (id_calon,id_tps, peml, pemp,total) VALUES (?, ?, ?, ?,?)";
            $stmt = $conn->prepare($query);
        
            // Binding parameter ke statement
            $stmt->bind_param('sssss', $id_calon, $id_tps, $peml, $pemp,$total);
        
            // Looping untuk menginput data dari array
            foreach ($data['id_calon'] as $key => $value) {
                $id_calon = $value;
                $id_tps = $data['id_tps'][$key];
                $peml = $data['peml'][$key];
                $pemp = $data['pemp'][$key];
                $total = $peml + $pemp;
        
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
<div class="row">
    <div class="col">
  <div class="animate__animated animate bounce card mx-auto" style="width: 18rem;">
    <div class="container mt-3">
      <img src="https://i.ibb.co/gRpP2Lm/icons8-online-128.png" class="card-img-top " alt="..."></div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
      
      <?php $part = getCalonData($conn); foreach ($part as $as){ ?>
        <h5 class="card-title ms-1"><?php echo $as['nama_calon']; ?></h5>
<p class="card-text mb-1 ms-1"><?php echo $as['nama_partai']; ?></p>
     <?php } ?>
     </div>
     <div class="col-2">
     <?php $cal = getCalonData($conn); foreach ($cal as $asa){ ?>
<h1 class="h1"><?php echo $asa['no_urut']; ?></h1>
     <?php } ?>
    </div>
        </div>
    </div>
  </div>
  
    </div>
    <div class="col">
        <!-- Form untuk menampilkan data pemilu dan memungkinkan pengeditan masal -->
        <form method="POST">
            <table class="table">
                <thead>
                    <tr>
                        
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>TPS</th>
                        <th>Pemilih Laki-Laki</th>
                        <th>Pemilih Perempuan</th>
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
                        // Tambahkan input form untuk id_partai, peml, dan pemp dengan nilai awal
                        // yang sesuai dengan data yang ada di tabel "pemilu"
                        
                        echo "<td><input type='text' class='form-control' name='peml[]'></td>";
                        echo "<td><input type='text' class='form-control' name='pemp[]'></td>";
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
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
