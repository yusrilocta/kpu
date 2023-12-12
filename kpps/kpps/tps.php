<?php 
include '../../admin/koneksi.php';
include 'header.php';
// Fungsi untuk mendapatkan semua data calon
function getCalon($conn) {

    $gg = $_SESSION['username'];
    $query = "SELECT * FROM tps where handle = :handle";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':handle', $gg);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<div class="container">
<div class="row">
    <div class="col">
          <div class="table-responsive bg-white">
                    <table class="table border mb-0">
                      <thead class=" fw-semibold">
                        <tr class="align-middle">
                          <th>Nama</th>
                          <th>Nama Partai</th>
                          <th class="text-center">Nomer Urut</th>
                          <th class="text-center">laki-Laki</th>
                          <th class="text-center">Perempuan</th>
                          <th></th>
                        </tr>
                      </thead>
                      <?php
                      $calon = getCalon($conn);
                       foreach ($calon as $data)
                       { ?>

                       
                      <tbody>
                        <tr class="align-middle">
                          <td>
                            <div><?php echo $data['kec'] ?></div>
                            <div class="small text-medium-emphasis"><span>Calon</span> | Registered: Jan 1, 2022</div>
                          </td>
                          <td>
                            <div class="clearfix">
                              <div class="float-start">
                                <div class="fw-semibold"><?php echo $data['desa'] ?></div>
                              </div>
                            </div>
                          </td>
                          <td class="text-center">
                          <?php echo $data['notps'] ?>
                          </td>
                          <td class="text-center">
                          <?php echo $data['peml'] ?>
                          </td>
                          <td class="text-center">
                          <?php echo $data['pemp'] ?>
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="icon">
                                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                                </svg>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Info</a><a class="dropdown-item" href="#">Edit</a><a class="dropdown-item text-danger" href="#">Delete</a></div>
                            </div>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  </div>
        
                  </div>
</div>

<?php include 'footer.php'; ?>