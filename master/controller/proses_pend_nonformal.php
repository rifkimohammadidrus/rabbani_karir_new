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
        case 'simpan':

            $talent_id           = $_POST['talent_id'];
            $jenis_pendidikan  = $_POST['jenis_pendidikan'];
            $nama_lembaga       = $_POST['nama_lembaga'];
            $bidang_lembaga             = $_POST['bidang_lembaga'];
            $jabatan             = $_POST['jabatan'];
            $alamat_lembaga             = $_POST['alamat_lembaga'];
            $lama_pendidikan1           = $_POST['lama_pendidikan1'];
            $lama_pendidikan2           = $_POST['lama_pendidikan2'];
            $lama_pendidikan   = $lama_pendidikan1.' '.$lama_pendidikan2;
            
            $ijazah        = $_POST['ijazah'];
            $keterangan          = $_POST['keterangan']; 

            $sql = "INSERT INTO talent_pend_nonformal (talent_id, jenis_pendidikan, nama_lembaga, bidang_lembaga,alamat_lembaga, jabatan, lama_pendidikan, ijazah,  keterangan) VALUES ('$talent_id', '$jenis_pendidikan', '$nama_lembaga', '$bidang_lembaga', '$alamat_lembaga', '$jabatan', '$lama_pendidikan', '$ijazah', '$keterangan')";
            $aksi = mysqli_query($koneksi, $sql);  
            
        break;
        case 'edit':
            $id                  = $_POST['id'];
            $talent_id           = $_POST['talentid'];
            $jenis_pendidikan  = $_POST['jenis_pendidikan'];
            $nama_lembaga       = $_POST['nama_lembaga'];
            $bidang_lembaga             = $_POST['bidang_lembaga'];
            $alamat_lembaga             = $_POST['alamat_lembaga'];
            $jabatan             = $_POST['jabatan'];
            $lama_pendidikan1           = $_POST['lama_pendidikan1'];
            $lama_pendidikan2           = $_POST['lama_pendidikan2'];
            $lama_pendidikan   = $lama_pendidikan1.' '.$lama_pendidikan2;
            // $thn_lulus           = $_POST['thn_lulus'];
            $ijazah        = $_POST['ijazah'];
            $keterangan          = $_POST['keterangan'];
            
            $sql1 = "UPDATE talent_pend_nonformal SET  talent_id='$talent_id', jenis_pendidikan='$jenis_pendidikan', nama_lembaga='$nama_lembaga', bidang_lembaga='$bidang_lembaga', alamat_lembaga='$alamat_lembaga', jabatan='$jabatan', lama_pendidikan='$lama_pendidikan', ijazah='$ijazah', keterangan='$keterangan' where id='$id'";
            
            $aksi1 = mysqli_query($koneksi, $sql1);
        break;
        case 'delete':
            $data_id = $_POST['id'];
            $sql = "DELETE FROM talent_pend_nonformal WHERE id='$data_id'";
            $aksi = mysqli_query($koneksi, $sql);

            if ($aksi) { ?>
                <script language="javascript">
                    document.location = '../../dashboard/pend_nonformal.php?pesan=sukses';
                </script>
            <?php } else { ?>
                <script language="javascript">
                    document.location = '../../dashboard/pend_nonformal.php?pesan=gagal';
                </script>
            <?php 
            }
        break;
    }
     
?>


           
