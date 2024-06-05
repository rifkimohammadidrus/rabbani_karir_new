<?php
    session_start();
    if(!isset($_SESSION['bahasa'])){
        $_SESSION['bahasa'] = 'ina';
        ?>
        <script type="text/javascript">
          document.location = '';
        </script>
        <?php
    }
    if ($_SESSION['bahasa'] == 'ina') { 
        $info1 = 'Cek email untuk melihat password anda';
        $info2 = 'terjadi keasalahan dalam sistem, silahkan ulangi kembali.';
        $info3 = 'email anda tidak terdaftar';
        $info4 = 'email dan kata sandi tidak sesuai atau blm terdaftar';
        $info5 = 'akun anda blm terverifikasi, silahkan cek email utk melihat email verifikasi';
        $info6 = 'Email yang anda masukan sudah terdaftar, silahkan ulangi kembali.';
        $info7 = 'email verifikasi gagal terkirim, silahkan hubungi cs rabbani (Recruitment@rabbani.co.id / (022) 7234254)';
    }else if ($_SESSION['bahasa'] == 'eng'){ 
        $info1 = 'Check email to see your password';
        $info2 = 'error occurred in the system, please repeat again.';
        $info3 = 'Your email is not listed';
        $info4 = 'emails and passwords are incompatible or unrecorded';
        $info5 = 'your account has not been verified, please check email to see verification email';
        $info6 = 'error occurred in the system / email you have registered, please repeat again.';
        $info7 = 'verification email failed to send, please contact cs rabbani (Recruitment@rabbani.co.id / (022) 7234254)';
    }
    // include("../lib/nusoap.php");
    include("../connect.php"); 
    include("../anti_in.php"); 
    switch ($_GET['action']) {
        
        case 'konf_tidak_hadir':
            $id_pesan   = $_POST['id_pesan'];
            $alasan   = $_POST['alasan'];
            $sql1 = "UPDATE pesan set konfirmasi=1, alasan='$alasan' where id='$id_pesan'"; 
            $aksi1 = mysqli_query($koneksi, $sql1);
            if ($aksi1) { ?>
                <script language="javascript">
                    document.location = '../../dashboard/undangan.php?pesan=sukses';
                </script>
            <?php } else { ?>
                <script language="javascript">
                    document.location = '../../dashboard/undangan.php?pesan=gagal';
                </script>
            <?php 
            }
        break;
        case 'konfirmasi':
            $id_pesan   = $_POST['id_pesan'];
            $sql = "update pesan set konfirmasi=1 where id = $id_pesan";
            $querykonfirmasi = mysqli_query($koneksi,$sql);
            if ($querykonfirmasi) { ?>
                <script language="javascript">
                    document.location = '../../dashboard/undangan.php?pesan=sukses';
                </script>
            <?php } else { ?>
                <script language="javascript">
                    document.location = '../../dashboard/undangan.php?pesan=gagal';
                </script>
            <?php 
            }
        break;
    }
    
    ?>  