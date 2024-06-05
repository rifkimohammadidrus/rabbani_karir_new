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

            $talent_id             = $_POST['talent_id'];
            $nama_perusahaan       = $_POST['nama_perusahaan'];
            $bidang_perusahaan     = $_POST['bidang_perusahaan'];
            $jabatan               = $_POST['jabatan'];
            $bidang_pekerjaan      = $_POST['bidang_pekerjaan'];
            $tgl_masuk             = $_POST['tgl_masuk'];
            $tgl_keluar            = $_POST['tgl_keluar'];
            $jml_gaji              = $_POST['jml_gaji'];
            $deskripsi             = $_POST['deskripsi'];

            $persentase_pengalaman       = 100;
            $nama_persentase       = "Pengalaman Kerja";
            $sql_cek= "select nama_persentase from talent_persentase where nama_persentase='$nama_persentase'";
            $aksi_cek = mysqli_query($koneksi, $sql_cek);
            $result=mysqli_fetch_array($aksi_cek);
            if (empty($result)) {
                $persentase_query = "INSERT INTO talent_persentase (talent_id, nama_persentase, persentase) VALUES ('$talent_id',  '$nama_persentase', '$persentase_pengalaman')";
                $aksi_persentase = mysqli_query($koneksi, $persentase_query);
            }
            $sql = "INSERT INTO talent_pengalaman_kerja (talent_id, nama_perusahaan, bidang_perusahaan,jabatan, bidang_pekerjaan, tgl_masuk,  tgl_keluar, jml_gaji, deskripsi) VALUES ('$talent_id', '$nama_perusahaan', '$bidang_perusahaan', '$jabatan', '$bidang_pekerjaan', '$tgl_masuk', '$tgl_keluar','$jml_gaji', '$deskripsi')";
            $aksi = mysqli_query($koneksi, $sql);
            
            
        break;
        case 'edit':
            $id                    = $_POST['id'];
            $talent_id             = $_POST['talent_id'];
            $nama_perusahaan       = $_POST['nama_perusahaan'];
            $bidang_perusahaan     = $_POST['bidang_perusahaan'];
            $jabatan               = $_POST['jabatan'];
            $bidang_pekerjaan      = $_POST['bidang_pekerjaan'];
            $tgl_masuk             = $_POST['tgl_masuk'];
            $tgl_keluar            = $_POST['tgl_keluar'];
            $jml_gaji              = $_POST['jml_gaji'];
            $deskripsi             = $_POST['deskripsi'];
            
            $sql1 = "UPDATE talent_pengalaman_kerja SET  talent_id='$talent_id', nama_perusahaan='$nama_perusahaan', bidang_perusahaan='$bidang_perusahaan', jabatan='$jabatan', bidang_pekerjaan='$bidang_pekerjaan', tgl_masuk='$tgl_masuk', tgl_keluar='$tgl_keluar', jml_gaji='$jml_gaji', deskripsi='$deskripsi' where id='$id'";
            
            $aksi1 = mysqli_query($koneksi, $sql1);
        break;
        case 'delete':
            $data_id = $_POST['id'];
            $sql = "DELETE FROM talent_pengalaman_kerja WHERE id='$data_id'";
            $aksi = mysqli_query($koneksi, $sql);

            if ($aksi) {
                echo "Hapus Data Berhasil";
                exit;
            } else {
                echo "Hapus Data Gagal :" . mysqli_error($koneksi);
            }
        break;
        case 'simpan_fresh':

            $talent_id             = $_POST['talent_id'];
            $jenis_pengalaman     = $_POST['jenis_pengalaman'];
            $nama       = $_POST['nama'];
            $tempat      = $_POST['tempat'];
            $jabatan               = $_POST['jabatan'];
            $lama_pengalaman1             = $_POST['lama_pengalaman1'];
            $lama_pengalaman2            = $_POST['lama_pengalaman2'];
            $lama_pengalaman              =$lama_pengalaman1.' '.$lama_pengalaman2;

            $persentase_pengalaman       = 100;
            $nama_persentase       = "Pengalaman Kerja";
            $sql_cek= "select nama_persentase from talent_persentase where nama_persentase='$nama_persentase'";
            $aksi_cek = mysqli_query($koneksi, $sql_cek);
            $result=mysqli_fetch_array($aksi_cek);
            if (empty($result)) {
                $persentase_query = "INSERT INTO talent_persentase (talent_id, nama_persentase, persentase) VALUES ('$talent_id',  '$nama_persentase', '$persentase_pengalaman')";
                $aksi_persentase = mysqli_query($koneksi, $persentase_query);
            }
            $sql = "INSERT INTO talent_fresh_graduate (talent_id, jenis_pengalaman, nama, tempat, jabatan, lama_pengalaman) VALUES ('$talent_id', '$jenis_pengalaman', '$nama', '$tempat', '$jabatan', '$lama_pengalaman')";
            $aksi = mysqli_query($koneksi, $sql);
            
            
        break;
        case 'edit_fresh':
            $id                    = $_POST['id'];
            $talent_id             = $_POST['talent_id'];
            $jenis_pengalaman     = $_POST['jenis_pengalaman'];
            $nama       = $_POST['nama'];
            $tempat      = $_POST['tempat'];
            $jabatan               = $_POST['jabatan'];
            $lama_pengalaman1             = $_POST['lama_pengalaman1'];
            $lama_pengalaman2            = $_POST['lama_pengalaman2'];
            $lama_pengalaman              =$lama_pengalaman1.' '.$lama_pengalaman2;
            
            $sql1 = "UPDATE talent_fresh_graduate SET  talent_id='$talent_id', jenis_pengalaman='$jenis_pengalaman', nama='$nama', tempat='$tempat', jabatan='$jabatan', lama_pengalaman='$lama_pengalaman' where id='$id'";
            
            $aksi1 = mysqli_query($koneksi, $sql1);
        break;
        case 'delete_fresh':
            $data_id = $_POST['id'];
            $sql = "DELETE FROM talent_fresh_graduate WHERE id='$data_id'";
            $aksi = mysqli_query($koneksi, $sql);

            if ($aksi) { ?>
                <script language="javascript">
                    document.location = '../../dashboard/peng_kerja.php?pesan=sukses';
                </script>
            <?php } else { ?>
                <script language="javascript">
                    document.location = '../../dashboard/peng_kerja.php?pesan=sukses';
                </script>
            <?php 
            }
        break;

    }
     
?>


           
