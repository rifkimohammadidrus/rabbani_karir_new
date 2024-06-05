<div class="sidebar-overlay"></div>

<?php

if(!isset($_SESSION['bahasa'])){
    $_SESSION['bahasa'] = 'ina';
}

if ($_SESSION['bahasa'] == 'ina') { 
    $minfo = 'ISILAH BIODATA DENGAN LENGKAP';
    $mnotif = 'Notif/Undangan';
    $mcv = 'CV Anda';
    $mbio = 'Biodata Pribadi';
    $mformal = 'Pendidikan Formal';
    $mnonformal = 'Pendidikan Non Formal';
    $mkel = 'Data Keluarga';
    $mbahasa = 'Keahlian Bahasa';
    $mkerja = 'Pengalaman Kerja';
    $mlowongan = 'Lowongan Kerja';
    $mlamaran = 'Lamaran Anda';
    $mid = 'Anggota';
}else if ($_SESSION['bahasa'] == 'eng'){ 
    $minfo = 'FILL IT COMPLETELY AND CORRECTLY';
    $mnotif = 'Notif/invitation';
    $mcv = 'Your CV';
    $mbio = 'Personal Biodata';
    $mformal = 'Formal education';
    $mnonformal = 'Non Formal education';
    $mkel = 'Family Data';
    $mbahasa = 'Language Skills';
    $mkerja = 'Work experience';
    $mlowongan = 'Job vacancy';
    $mlamaran = 'Your application';  
    $mid = 'Member'; 
} ?>
<aside id="sidebar" class="sidebar sidebar-default open" role="navigation">
            <!-- User Info -->
            <div class="user-info">    
                <div>
                    <a href="../index.html"><img src="../assets/dashboard/images/user.png" width="52" height="48" alt="User" /> <b style="color: #fff;">DASHBOARD <?php echo strtoupper($mid); ?></b></a>
                </div>
                <div class="info-container" style="top:15px">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['nama'] ?></div>
                    <!-- <div class="email">ID <?php echo $mid; ?> : <strong><?php echo $_SESSION['nip'] ?></strong></div> -->
                    <div class="btn-group user-helper-dropdown" title="logout">
                        <i class="fa fa-chevron-down " aria-hidden="true" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="logout.php"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <?php
                $sql = "SELECT * from lowongan_kerja where status = 1";
                $datanya=mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
                $banyakrecordlowongan=mysqli_num_rows($datanya);

                $nip = $_SESSION['nip'];
                $sql = "SELECT * from pesan tbl1
                inner join lowongan_kerja tbl2 on tbl2.id = tbl1.id_lowongan
                where tbl1.nip = '$nip' and tbl2.status = 1 and tbl1.konfirmasi = 0";
                $datanya=mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
                $banyakrecordpesan=mysqli_num_rows($datanya);

                $sql = "SELECT * from pesanpribadi 
                where nip = '$nip' and status = 0";
                $datanya=mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
                $banyakrecordpesanpribadi=mysqli_num_rows($datanya);
                $totalpesan = $banyakrecordpesanpribadi + $banyakrecordpesan;
            
            ?>
            <!-- Menu -->
            <style type="text/css">
                a i {
                    padding-top: 10px;
                }
            </style>
            <div class="menu">
                <ul class="list">
                    <li class="header"><?php echo $minfo; ?></li>
                    <!-- Menu Lowongan Kerja -->
                    <li class="<?php echo $lk; ?>">
                        <a href="lowongankerja.php">
                            <i class="fa fa-handshake-o fa-lg" aria-hidden="true"></i><span><?php echo $mlowongan; ?></span>&nbsp;<button style="height: 20px;margin-top: 7px" class="btn btn-danger btn-xs" title="jumlah lowongan"><?php echo $banyakrecordlowongan; ?></button>
                        </a>
                    </li>
                    <li class="<?php echo $uw; ?>">
                        <a href="pesan.php">
                            <i class="fa fa-envelope fa-lg" aria-hidden="true"></i><span><?php echo $mnotif; ?></span>&nbsp;
                            <?php if($totalpesan > 0) { ?>
                                <img src="../images/notif.gif" width="30" height="20" alt="User" style="height: 20px;margin-top: 7px" />
                            <?php } ?>
                        </a>
                    </li>
                    <li class="<?php echo $cv; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-address-card fa-lg" aria-hidden="true"></i><span><?php echo $mcv; ?></span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo $bp; ?>">
                                <a href="index.php">
                                    <span><?php echo $mbio; ?></span> <b style="color: #f00">*</b>
                                    <?php
                                        $nip = $_SESSION['nip'];
                                        $sqlbpcek = "SELECT * from tbl_x_karyawan tbl1
                                        inner join karyawan_pribadi tbl2 on tbl2.nip = tbl1.nip
                                        where tbl1.nip = '$nip' and tbl2.foto != '' and tbl2.ktp != ''";
                                        $databpcek=mysqli_query($koneksi, $sqlbpcek) or die(mysqli_error($koneksi));
                                        $hasilbpcek=mysqli_fetch_array($databpcek);
                                    
                                    if (empty($hasilbpcek)) {?>
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true" style="color: #f00">
                                    <?php }else{ ?>
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: #13ff03">
                                    <?php } ?>
                                </a>
                            </li>
                            <li class="<?php echo $pf; ?>">
                                <a href="pendidikanformal.php">
                                    <span><?php echo $mformal; ?></span> <b style="color: #f00">*</b>
                                    <?php
                                        $nip = $_SESSION['nip'];
                                        $sqlpfcek = "SELECT tbl1.*,tbl2.nama as jp from karyawan_formal tbl1
                                        inner join pendidikan_formal tbl2 on tbl2.kode = tbl1.kode_formal
                                        where tbl1.nip = '$nip'
                                        order by ke asc";
                                        $datapfcek=mysqli_query($koneksi, $sqlpfcek) or die(mysqli_error($koneksi));
                                        $hasilpfcek=mysqli_fetch_array($datapfcek);
                                    
                                    if (empty($hasilpfcek)){?>
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true" style="color: #f00">
                                    <?php }else{ ?>
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: #13ff03">
                                    <?php } ?>
                                </a>
                            </li>
                            <li class="<?php echo $dk; ?>"> 
                                <a href="datakeluarga.php">
                                    <span><?php echo $mkel; ?></span> <b style="color: #f00">*</b>
                                    <?php
                                        $nip = $_SESSION['nip'];
                                        $sqldkcek = "SELECT * from karyawan_hubungan
                                        where nip = '$nip'";
                                        $datadkcek=mysqli_query($koneksi, $sqldkcek) or die(mysqli_error($koneksi));
                                        $hasildkcek=mysqli_fetch_array($datadkcek);
                                    
                                    if (empty($hasildkcek)){?>
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true" style="color: #f00">
                                    <?php }else{ ?>
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: #13ff03">
                                    <?php } ?>
                                </a>
                            </li>
                            <li class="<?php echo $kb; ?>">
                                <a href="keahlianbahasa.php">
                                    <span><?php echo $mbahasa; ?></span>
                                    <?php
                                        $nip = $_SESSION['nip'];
                                        $sqlkbcek = "SELECT * from karyawan_berbahasa 
                                        where nip = '$nip'";
                                        $datakbcek=mysqli_query($koneksi, $sqlkbcek) or die(mysqli_error($koneksi));
                                        $hasilkbcek=mysqli_fetch_array($datakbcek);
                                    
                                    if (empty($hasilkbcek)){?>
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true" style="color: #f00">
                                    <?php }else{ ?>
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: #13ff03">
                                    <?php } ?>
                                </a>
                            </li>
                            <li class="<?php echo $pk; ?>">
                                <a href="pengalamankerja.php">
                                    <span><?php echo $mkerja; ?></span>
                                    <?php
                                        $nip = $_SESSION['nip'];
                                        $sqldkcek = "SELECT * from karyawan_pengalaman
                                        where nip = '$nip'";
                                        $datadkcek=mysqli_query($koneksi, $sqldkcek) or die(mysqli_error($koneksi));
                                        $hasildkcek=mysqli_fetch_array($datadkcek);
                                    
                                    if (empty($hasildkcek)){?>
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true" style="color: #f00">
                                    <?php }else{ ?>
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: #13ff03">
                                    <?php } ?>
                                </a>
                            </li>
                            <li class="<?php echo $pnf; ?>">
                                <a href="pendidikannonformal.php">
                                    <span><?php echo $mnonformal; ?></span>
                                    <?php
                                        $nip = $_SESSION['nip'];
                                        $sqldkcek = "SELECT * from karyawan_non
                                        where nip = '$nip'";
                                        $datadkcek=mysqli_query($koneksi, $sqldkcek) or die(mysqli_error($koneksi));
                                        $hasildkcek=mysqli_fetch_array($datadkcek);
                                    
                                    if (empty($hasildkcek)){?>
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true" style="color: #f00">
                                    <?php }else{ ?>
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: #13ff03">
                                    <?php } ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo $la; ?>">
                        <a href="lamarananda.php">
                            <i class="fa fa-check-circle-o fa-lg" aria-hidden="true"></i><span><?php echo $mlamaran; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i><span>logout</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <!-- #Footer -->
</aside>

    
