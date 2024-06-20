<?php

include("ceklogin.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tamu'])) {
    // Handle the AJAX request to update attendance
    $id_tamu = $_POST['id_tamu'];
    $query = "UPDATE tamu SET kehadiran='hadir' WHERE id_tamu='$id_tamu'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
    exit;
}
// $hadir = mysqli_query($koneksi, "SELECT");
// $blmhadir = mysqli_num_rows("");

// Fetch guests who have not attended
$ambiltamu = mysqli_query($koneksi, "SELECT * FROM tamu WHERE kehadiran='Tidak Hadir'");
$hitung = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM tamu WHERE kehadiran = 'Tidak Hadir'");
if (!$hitung) {
    echo "Error: " . mysqli_error($koneksi);
    exit();
}
$row = mysqli_fetch_assoc($hitung);
$hasil = $row['jml'];

$hitung1 = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM tamu WHERE kehadiran = 'Hadir'");
$row1 = mysqli_fetch_assoc($hitung1);
$hasil1 = $row1['jml'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambahtamu'])) {
    if (!empty($_POST['tamu_baru']) && !empty($_POST['alamat_baru']) && !empty($_POST['status_baru'])) {
        $nama_tamu = $_POST['tamu_baru'];
        $status = $_POST['status_baru'];
        $alamat = $_POST['alamat_baru'];
        $kehadiran = "Tidak Hadir";

        $sql = "INSERT INTO tamu (nama_tamu, alamat, status, kehadiran) VALUES ('$nama_tamu', '$alamat', '$status', '$kehadiran')";

        if ($koneksi->query($sql) === TRUE) {
            $_SESSION['message'] = 'Berhasil menambah tamu baru';
        } else {
            $_SESSION['message'] = 'Gagal menambah tamu baru: ' . $koneksi->error;
        }

        $koneksi->close();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Beranda</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div class="sidebar-brand-text mx-3">KEHADIRAN TAMU</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Beranda</span></a>
            </li>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                ABSENSI
            </div> -->

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="presensi.php">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Presensi</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="absensi.php">
                <i class="fa-solid fa-user-check "></i>
                    <span>Tamu Hadir</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="tidakhadir.php">
                <i class="fa-solid fa-user-xmark "></i>
                    <span>Tamu Belum Hadir</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="laporan.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Laporan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->
                    <img src="img/header.png" alt="nikah">

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Keluar
                        </a>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Tamu Hadir Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                <a href="absensi.php">
                                                Tamu Hadir</div></a>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $hasil1; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-user-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                <a href="tidakhadir.php">
                                                Tamu Belum Hadir</div></a>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $hasil; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-user-xmark fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Tambah Tamu</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-user-plus fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary mt-3 w-100" data-toggle="modal" data-target="#myModal">Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                <!-- /.container-fluid -->
</div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SKAGA 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Tamu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form method="post" action="">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="text" name="tamu_baru" class="form-control mt-3" placeholder="Nama Tamu" required>
                        <input type="text" name="alamat_baru" class="form-control mt-3" placeholder="Alamat/Instansi" required>
                        <select name="status_baru" class="form-control mt-3" required>
                            <option value="Non-VIP">Non-VIP</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambahtamu">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin untuk Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih Keluar untuk mengakhiri sesi</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="logout.php">Keluar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    
    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>
    $(document).ready(function() {
        $('.hadir-button').click(function() {
            var idTamu = $(this).data('id');
            var row = $(this).closest('tr');
            $.ajax({
                url: '', // Current script
                type: 'POST',
                data: { id_tamu: idTamu },
                success: function(response) {
                    if (response == 'success') {
                        row.remove();
                        alert('Absensi Berhasil');
                        location.reload();
                    } else {
                        alert('Failed to update kehadiran');
                    }
                }
            });
        });
    });
    </script>



</body>

</html>