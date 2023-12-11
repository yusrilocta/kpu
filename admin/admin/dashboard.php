<!-- dashboard.php -->
<?php
include 'nav.php';
include 'koneksi.php';
$quero = "SELECT * FROM tps";

        $stmt = $conn->query($quero);
        $dato = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tpsData = [];

        foreach ($dato as $row) {
            $tps = $row['desa'];
            if (!isset($tpsData[$tps])) {
                $tpsData[$tps] = ['total_laki' => 0, 'total_perempuan' => 0];
            }
            $tpsData[$tps]['total_laki'] += $row['pemp'];
            $tpsData[$tps]['total_perempuan'] += $row['peml'];
        }
        

        $query = "SELECT pemilu.id, tps.notps, calon.nama_calon, pemilu.pemp, pemilu.peml
            FROM pemilu
            INNER JOIN tps ON pemilu.id_tps = tps.id
            INNER JOIN calon ON pemilu.id_calon = calon.id
            ORDER BY calon.id, tps.notps";

        $stmt = $conn->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $calonData = [];

        foreach ($data as $row) {
            $calon = $row['nama_calon'];
            if (!isset($calonData[$calon])) {
                $calonData[$calon] = ['total_laki' => [], 'total_perempuan' => []];
            }
            $calonData[$calon]['total_laki'][] = $row['pemp'];
            $calonData[$calon]['total_perempuan'][] = $row['peml'];
        }
        $quera = "SELECT SUM(tps.pemp) AS total_laki, SUM(tps.peml) AS total_perempuan,
                            SUM(tps.pemp) + SUM(tps.peml) AS total_pemilih
                            FROM tps";

                $stmt = $conn->query($quera);
                $dats = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $quers = "SELECT SUM(pemilu.pemp) AS total_laki, SUM(pemilu.peml) AS total_perempuan,
                            SUM(pemilu.pemp) + SUM(pemilu.peml) AS total_pemilu
                            FROM pemilu";

                $stmt = $conn->query($quers);
                $datd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
<div class="container mt-5">
        <canvas id="chart"></canvas>
        <p>Status: <span id="status"></span></p>
    </div>

<div class="container col mt-2">
            <div class="row">
                <div class="col mt-2">
                <div class="card">
  <div class="card-header">
    Data Pemilih masing Masing Tps
  </div>
  <div class="card-body">
  <canvas id="calonChart"></canvas>
        <p>Status: <span id="status"></span></p>
  </div>
</div>
                </div>
                <div class="container col mt-2">
                <div class="card">
  <div class="card-header">
    Total Data Pemilih
  </div>
  <ul class="list-group list-group-flush">
  <?php foreach ($datd as $row) { ?>
    <li class="list-group-item">Total Laki-Laki : <?php echo $row['total_laki']; ?></li>
    <li class="list-group-item">Total Perempuan : <?php echo $row['total_perempuan']; ?></li>
    <li class="list-group-item">Total Pemilih : <?php echo $row['total_pemilu']; ?></li>
    
    <?php  } ?>
  </ul>
</div>

<div class="card mt-3">
  <div class="card-header">
    Sudah Memilih
  </div>
  <ul class="list-group list-group-flush">
  <?php foreach ($dats as $row) { ?>
    <li class="list-group-item">Terdata Laki-Laki : <?php echo $row['total_laki']; ?></li>
    <li class="list-group-item">Terdata Perempuan : <?php echo $row['total_perempuan']; ?></li>
    <li class="list-group-item">Terdata Pemilih : <?php echo $row['total_pemilih']; ?></li>
    <?php  } ?>
  </ul>
</div>
                    
                </div>
            </div>
        
        
        </div>
        <div class="container col mt-2">
            <div class="row">
                <div class="col mt-2">
                <div class="card">
  <div class="card-header">
    Data Pemilih masing Masing Tps
  </div>
  <div class="card-body">
    <canvas id="tpsChart"></canvas>
  </div>
</div>
                </div>
                <div class="container col mt-2">

                    
                </div>
            </div>
        
        
        </div>

</div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        

        var ctx = document.getElementById('tpsChart').getContext('2d');
        var tpsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_keys($tpsData)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($tpsData, 'total_laki')); ?>,
                    label: 'Pemilih Laki-laki',
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderWidth: 1
                }, {
                    data: <?php echo json_encode(array_column($tpsData, 'total_perempuan')); ?>,
                    label: 'Pemilih Perempuan',
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display : false
                    },
                }
            }
        });

// BATAAAAAAAAAAAAS
       

        var ctx = document.getElementById('calonChart').getContext('2d');
        var calonChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($calonData)); ?>,
                datasets: [{
                    label: 'Pemilih Laki-laki',
                    data: <?php echo json_encode(array_map('array_sum', array_column($calonData, 'total_laki'))); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderWidth: 1
                }, {
                    label: 'Pemilih Perempuan',
                    data: <?php echo json_encode(array_map('array_sum', array_column($calonData, 'total_perempuan'))); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },

                }
            }
        });

        //BATAAAAAAAAAAS
        var ctx = document.getElementById('chart').getContext('2d');

// Data dari PHP
var data = <?php

    $queryPemilu = "SELECT SUM(pemp) AS total_pemilih_laki_pemilu, SUM(peml) AS total_pemilih_perempuan_pemilu FROM pemilu;";
    $stmtPemilu = $conn->query($queryPemilu);
    $dataPemil = $stmtPemilu->fetch(PDO::FETCH_ASSOC);

    $queryTPS = "SELECT SUM(pemp) AS total_pemilih_laki_tps, SUM(peml) AS total_pemilih_perempuan_tps FROM tps;";
    $stmtTPS = $conn->query($queryTPS);
    $dataTP = $stmtTPS->fetch(PDO::FETCH_ASSOC);

    echo json_encode([$dataPemil, $dataTP]);
?>;

var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Total Pemilih Laki-laki', 'Total Pemilih Perempuan'],
        datasets: [
            {
                label: 'Pemilu',
                data: [data[0].total_pemilih_laki_pemilu, data[0].total_pemilih_perempuan_pemilu],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'TPS',
                data: [data[1].total_pemilih_laki_tps, data[1].total_pemilih_perempuan_tps],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: true
            }
        }
    }
});

// Cek status
var statusElement = document.getElementById('status');
var pemiluLaki = data[0].total_pemilih_laki_pemilu;
var pemiluPerempuan = data[0].total_pemilih_perempuan_pemilu;
var tpsLaki = data[1].total_pemilih_laki_tps;
var tpsPerempuan = data[1].total_pemilih_perempuan_tps;

if (pemiluLaki < tpsLaki || pemiluPerempuan < tpsPerempuan) {
    statusElement.textContent = 'Dipertanyakan!';
} else {
    statusElement.textContent = 'Layak';
}

    </script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>