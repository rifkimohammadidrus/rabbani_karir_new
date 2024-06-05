<div class="sidebar-overlay"></div>
<?php if (isset($_GET['pelamar'])) { ?>
    <aside id="sidebar" class="sidebar sidebar-default" role="navigation">
<?php }else{ ?>
    <aside id="sidebar" class="sidebar sidebar-default open" role="navigation">
<?php } ?>

    <!-- User Info -->
    <div class="user-info">    
        <div>
            <a href="../index.html" target="_blank"><img src="../assets/dashboard/images/user.png" width="52" height="48" alt="User" /> <b style="color: #fff;">DASHBOARD HCD</b></a>
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['nama'] ?> <b>(<?php echo $_SESSION['nip'] ?>)</b></div>
            <div class="email"><strong><?php echo $_SESSION['email'] ?></strong></div>
            <div class="btn-group user-helper-dropdown">
                <i class="fa fa-chevron-down " aria-hidden="true" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <?php
        $sql = " SELECT * from lowongan_kerja where status = 1";
        $datanya=mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
        $banyakrecordlowongan=mysqli_num_rows($datanya);
    ?>
    <!-- Menu -->
    <style type="text/css">
        a i {
            padding-top: 10px;
        }
    </style>
    <div class="menu">
        <ul class="list">
            <li class="header">MENU HUMAN CAPITAL DEPARTEMENT</li>
            <li class="<?php echo $h; ?>">
                <a href="home.php">
                    <i class="fa fa-handshake-o fa-lg" aria-hidden="true"></i>
                    <span>Lowongan kerja</span>&nbsp;<button style="height: 20px;margin-top: 7px" class="btn btn-danger btn-xs" title="jumlah lowongan aktif"><?php echo $banyakrecordlowongan; ?></button>
                </a>
            </li>
            <li class="<?php echo $lt; ?>">
                <a href="listtesting.php">
                    <i class="fa fa-calendar fa-lg" aria-hidden="true"></i>
                    <span>Jadwal Testing</span>
                </a>
            </li>
            <li class="<?php echo $r; ?>">
                <a href="report.php">
                    <i class="fa fa-flag-checkered fa-lg" aria-hidden="true"></i>
                    <span>Report Testing</span>
                </a>
            </li>
            <!-- <li class="<?php echo $ltr; ?>">
                <a href="listtraining.php">
                    <i class="fa fa-calendar fa-lg" aria-hidden="true"></i>
                    <span>Jadwal Training</span>
                </a>
            </li>
            <li class="<?php echo $rt; ?>">
                <a href="reporttraining.php">
                    <i class="fa fa-flag-checkered fa-lg" aria-hidden="true"></i>
                    <span>Report Training</span>
                </a>
            </li> -->
            <li class="<?php echo $jt; ?>">
                <a href="jenis_training.php">
                    <i class="fa fa-list fa-lg" aria-hidden="true"></i>
                    <span>List Jenis Testing</span>
                </a>
            </li>
            <li class="<?php echo $mt; ?>">
                <a href="materi_training.php">
                    <i class="fa fa-list fa-lg" aria-hidden="true"></i>
                    <span>List Materi Testing</span>
                </a>
            </li>
            <li class="<?php echo $dk; ?>">
                <a href="datakaryawan.php">
                    <i class="fa fa-group fa-lg" aria-hidden="true"></i>
                    <span>Grouping Data Karyawan</span>
                </a>
            </li>
            <li class="<?php echo $dka; ?>">
                <a href="datakaryawanall.php">
                    <i class="fa fa-group fa-lg" aria-hidden="true"></i>
                    <span>Data Calon/Karyawan All</span>
                </a>
            </li>
            <li class="<?php echo $dept; ?>">
                <a href="departemen.php">
                    <i class="fa fa-building-o fa-lg" aria-hidden="true"></i>
                    <span>Departemen</span>
                </a>
            </li>
            <li class="<?php echo $b; ?>">
                <a href="banner.php">
                    <i class="fa fa-file-image-o fa-lg" aria-hidden="true"></i>
                    <span>Banner</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
</aside>

    
