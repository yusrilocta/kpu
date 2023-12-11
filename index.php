<?php include 'admin/admin/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500,700,900" rel="stylesheet">

    <title>Hitung Cepat - KPU</title>
<!--
SOFTY PINKO
https://templatemo.com/tm-535-softy-pinko
-->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/templatemo-softy-pinko.css">

    </head>
    
    <body>

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="#" class="logo">
                            <img src="assets/images/logo.png" alt="Softy Pinko"/>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="#welcome" class="active">Home</a></li>
                            <li><a href="#features">About</a></li>
                            <li><a href="#work-process">Work Process</a></li>
                            <li><a href="#testimonials">Testimonials</a></li>
                            <li><a href="#pricing-plans">Pricing Tables</a></li>
                            <li><a href="/kpu/admin">Login Admin</a></li>
                            <li><a href="/kpps">Login KPPS</a></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Welcome Area Start ***** -->
    <div class="welcome-area" id="welcome">

        <!-- ***** Header Text Start ***** -->
        <div class="header-text">
            <div class="container">
                <div class="row">
                    <div class="offset-xl-3 col-xl-6 offset-lg-2 col-lg-8 col-md-12 col-sm-12">
                        <h1>Selamat Datang di <strong>Hitung Cepat</strong><br>Komisi Pemilihan Umum <strong>Baturaja</strong></h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- ***** Header Text End ***** -->
    </div>
    <!-- ***** Welcome Area End ***** -->

    <!-- ***** Features Small Start ***** -->
    <section class="section home-feature">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <!-- ***** Features Small Item Start ***** -->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.2s">
                            <div class="features-small-item">
                                
                            <p>Perbandingan Pemilih Dan Total Peserta Pemilih</p>
                            <canvas id="chart"></canvas>
                            <p>Status: <span id="status"></span></p>
                            </div>
                        </div>
                        <!-- ***** Features Small Item End ***** -->

                        <!-- ***** Features Small Item Start ***** -->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.4s">
                            <div class="features-small-item">
                                 <canvas id="tpsChart"></canvas>
                            </div>
                        </div>
                        <!-- ***** Features Small Item End ***** -->

                        <!-- ***** Features Small Item Start ***** -->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.6s">
                            <div class="features-small-item">
                                <div class="icon">
                                    <i><img src="assets/images/featured-item-01.png" alt=""></i>
                                </div>
                                <h5 class="features-title">6 TPS</h5>
                                <p>1440 Pemilih</p>
                            </div>
                        </div>
                        <!-- ***** Features Small Item End ***** -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Home Parallax Start ***** -->
    <section class="mini" id="work-process">
        <div class="mini-content">
            <div class="container">
                <div class="row">
                    <div class="offset-lg-3 col-lg-6">
                        <div class="info">
                            <h1>Work Process</h1>
                            <p>Aenean nec tempor metus. Maecenas ligula dolor, commodo in imperdiet interdum, vehicula ut ex. Donec ante diam.</p>
                        </div>
                    </div>
                </div>

                <!-- ***** Mini Box Start ***** -->
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/work-process-item-01.png" alt=""></i>
                            <strong>Get Ideas</strong>
                            <span>Godard pabst prism fam cliche.</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/work-process-item-01.png" alt=""></i>
                            <strong>Sketch Up</strong>
                            <span>Godard pabst prism fam cliche.</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/work-process-item-01.png" alt=""></i>
                            <strong>Discuss</strong>
                            <span>Godard pabst prism fam cliche.</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/work-process-item-01.png" alt=""></i>
                            <strong>Revise</strong>
                            <span>Godard pabst prism fam cliche.</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/work-process-item-01.png" alt=""></i>
                            <strong>Approve</strong>
                            <span>Godard pabst prism fam cliche.</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/work-process-item-01.png" alt=""></i>
                            <strong>Launch</strong>
                            <span>Godard pabst prism fam cliche.</span>
                        </a>
                    </div>
                </div>
                <!-- ***** Mini Box End ***** -->
            </div>
        </div>
    </section>
    <!-- ***** Home Parallax End ***** -->

    <!-- ***** Counter Parallax Start ***** -->
    <section class="counter">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="count-item decoration-bottom">
                            <strong>126</strong>
                            <span>Projects</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="count-item decoration-top">
                            <strong>63</strong>
                            <span>Happy Clients</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="count-item decoration-bottom">
                            <strong>18</strong>
                            <span>Awards Wins</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="count-item">
                            <strong>27</strong>
                            <span>Countries</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Counter Parallax End ***** -->   
    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <ul class="social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright">Copyright &copy; 2020 Softy Pinko Company - Design: TemplateMo</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
        var ctx = document.getElementById('chart').getContext('2d');

// Data dari PHP
var data = <?php

    $queryPemilu = "SELECT SUM(peml) AS total_pemilu FROM pemilu;";
    $stmtPemilu = $conn->query($queryPemilu);
    $dataPemil = $stmtPemilu->fetch(PDO::FETCH_ASSOC);

    $queryTPS = "SELECT SUM(pemp + peml) AS total_pemilih FROM tps;
    ";
    $stmtTPS = $conn->query($queryTPS);
    $dataTP = $stmtTPS->fetch(PDO::FETCH_ASSOC);

    echo json_encode([$dataPemil, $dataTP]);
?>;

var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Total Pemilih'],
        datasets: [
            {
                label: 'Pemilu',
                data: [data[0].total_pemilu],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'TPS',
                data: [data[1].total_pemilih],
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
var pemilu = data[0].total_pemilu;
var tps = data[1].total_pemilih;

if (pemilu < tps ) {
    statusElement.textContent = 'Dipertanyakan!';
} else {
    statusElement.textContent = 'Layak';
}
//BATAS PIE CHART
<?php $quero = "SELECT * FROM tps";

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
        } ?>
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


    </script>
  </body>
</html>