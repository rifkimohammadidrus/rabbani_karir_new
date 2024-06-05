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

    include("../lib/nusoap.php");
    include("connect.php"); 
    include("anti_in.php"); 
    if(isset($_GET['user'])){
        $cari = $_GET['q'];
        $id = $_GET['jenistraining'];
        $tgl = $_GET['tgl'];
        if ($id != 'training') {
            $sql = "
            select tbl1.* 
            from pesan tbl2 
            inner join user tbl1 on tbl1.id = tbl2.nip
            WHERE (tbl2.jenis_training = '$id' and tbl2.tgl_pelaksanaan = '$tgl') and (tbl1.id LIKE '%$cari%' or tbl1.nama_depan LIKE '%$cari%' or tbl1.nama_belakang LIKE '%$cari%') limit 5";
        }else{
            $sql = "
            select * 
            from user 
            WHERE karyawan=1 and (id LIKE '%$cari%' or nama_depan LIKE '%$cari%' or nama_belakang LIKE '%$cari%') limit 5";
        }
        $datauser=mysqli_query($koneksi, $sql);

        $json = [];
        while($data=mysqli_fetch_array($datauser)){
            $json[] = ['id'=>$data['id'], 'text'=>$data['nama_depan'].' '.$data['nama_belakang'].' ('.$data['id'].') ' ];
        }
        echo json_encode($json);
    }else{
        $fungsi   = $_POST['tanda'];
        if(!empty($fungsi)){

            
            /* ################### ALAMAT - DOMISILI ################## */

            if($fungsi == 'kab'){
                $provinsi_id   = $_POST['id'];
                $kab_sql = "SELECT * FROM kabkota WHERE provinsi_id = '$provinsi_id' ORDER BY nama_kabkota";
                $kab_obj = mysqli_query($koneksi, $kab_sql);

                echo "<option>Pilih Kabupaten/Kota</option>";
                while ($row = mysqli_fetch_array($kab_obj)) {
                    echo "<option value='".$row['id']."'>".$row['nama_kabkota']."</option>";
                }
            }

            if($fungsi == 'kec'){
                $kabkota_id = $_POST['id'];
                $kec_sql = "SELECT * FROM kecamatan WHERE kabkota_id = '$kabkota_id' ORDER BY nama_kecamatan";
                $kec_obj = mysqli_query($koneksi, $kec_sql);

                echo "<option>Pilih Kecamatan</option>";
                while($row = mysqli_fetch_array($kec_obj)){
                    echo "<option value='".$row['id']."'>".$row['nama_kecamatan']."</option>";
                }
            }

            if($fungsi == 'kel'){
                $kecamatan_id   = $_POST['id'];
                $kel_query = "SELECT k.*, p.no_kodepos 
                    FROM kelurahan k
                    LEFT JOIN kodepos p ON(p.kelurahan_id=k.id)
                    WHERE k.kecamatan_id = '$kecamatan_id'
                    ORDER BY k.nama_kelurahan";

                $kel_obj = mysqli_query($koneksi, $kel_query);

                echo "<option>Pilih Kelurahan</option>";
                while($row = mysqli_fetch_array($kel_obj)){
                    echo "<option value='".$row['id']."-".$row['no_kodepos']." '>".$row['nama_kelurahan']." (".$row['no_kodepos'].")</option>";
                }
            }

            /* ################### ALAMAT - KTP ################## */

            if($fungsi == 'kab_ktp'){
                $provinsi_id   = $_POST['id'];
                $kab_sql = "SELECT * FROM kabkota WHERE provinsi_id = '$provinsi_id' ORDER BY nama_kabkota";
                $kab_obj = mysqli_query($koneksi, $kab_sql);

                echo "<option>Pilih Kabupaten/Kota</option>";
                while ($row = mysqli_fetch_array($kab_obj)) {
                    echo "<option value='".$row['id']."'>".$row['nama_kabkota']."</option>";
                }
            }

            if($fungsi == 'kec_ktp'){
                $kabkota_id = $_POST['id'];
                $kec_sql = "SELECT * FROM kecamatan WHERE kabkota_id = '$kabkota_id' ORDER BY nama_kecamatan";
                $kec_obj = mysqli_query($koneksi, $kec_sql);

                echo "<option>Pilih Kecamatan</option>";
                while($row = mysqli_fetch_array($kec_obj)){
                    echo "<option value='".$row['id']."'>".$row['nama_kecamatan']."</option>";
                }
            }

            if($fungsi == 'kel_ktp'){
                $kecamatan_id   = $_POST['id'];
                $kel_query = "SELECT k.*, p.no_kodepos 
                    FROM kelurahan k
                    LEFT JOIN kodepos p ON(p.kelurahan_id=k.id)
                    WHERE k.kecamatan_id = '$kecamatan_id'
                    ORDER BY k.nama_kelurahan";

                $kel_obj = mysqli_query($koneksi, $kel_query);

                echo "<option>Pilih Kelurahan</option>";
                while($row = mysqli_fetch_array($kel_obj)){
                    echo "<option value='".$row['id']."-".$row['no_kodepos']." '>".$row['nama_kelurahan']." (".$row['no_kodepos'].")</option>";
                }
            }

            /* #################################################### */

            if($fungsi == 'pf'){
                $sql = "select * from pendidikan_formal";
                $datapendidikan=mysqli_query($koneksi, $sql);
                    ?><option value="">Pilih/select</option><?php
                    while($data=mysqli_fetch_array($datapendidikan)){ ?>
                        <?php if($_SESSION['bahasa'] == 'ina') { ?>
                            <option value="<?php echo $data['kode'] ?>"><?php echo $data['nama'] ?></option>
                        <?php }else if ($_SESSION['bahasa'] == 'eng'){ ?>
                            <option value="<?php echo $data['kode'] ?>"><?php echo $data['nama_eng'] ?></option>
                        <?php } ?>
            <?php   }
            }

            if($fungsi == 'pnf'){
                $sql = "select * from pendidikan_nonformal";
                $datapendidikan=mysqli_query($koneksi, $sql);
                    ?><option value="">Pilih/select</option><?php
                    while($data=mysqli_fetch_array($datapendidikan)){ ?>
                        <option value="<?php echo $data['kode'] ?>"><?php echo $data['nama'] ?></option>
            <?php   }
            }

            if($fungsi == 'b'){
                $sql = "select * from pendidikan_bahasa";
                $databahasa=mysqli_query($koneksi, $sql);
                    ?><option value="">Pilih/select</option><?php
                    while($data=mysqli_fetch_array($databahasa)){ ?>
                        <option value="<?php echo $data['kode'] ?>">
                            <?php 
                                if($_SESSION['bahasa'] == 'ina') { 
                                    echo $data['nama'];
                                }else if ($_SESSION['bahasa'] == 'eng'){
                                    echo $data['nama_eng'];
                                }
                            ?>  
                        </option>
            <?php   }
            }

            if($fungsi == 'k'){
                $sql = "select * from karyawan_kemampuan";
                $datakemampuan=mysqli_query($koneksi, $sql);
                    ?><option value="">Pilih/select</option><?php
                    while($data=mysqli_fetch_array($datakemampuan)){ ?>
                        <option value="<?php echo $data['kode'] ?>">
                            <?php 
                                if($_SESSION['bahasa'] == 'ina') { 
                                    echo $data['nama'];
                                }else if ($_SESSION['bahasa'] == 'eng'){
                                    echo $data['nama_eng'];
                                }
                            ?>
                        </option>
            <?php   }
            }

            if($fungsi == 'jh'){
                $sql = "select * from jenis_hubungan";
                $datahubungan=mysqli_query($koneksi, $sql);
                    ?><option value="">Pilih/select</option><?php
                    while($data=mysqli_fetch_array($datahubungan)){ ?>
                        <option value="<?php echo $data['kode'] ?>">
                            <?php 
                                if($_SESSION['bahasa'] == 'ina') { 
                                    echo $data['nama'];
                                }else if ($_SESSION['bahasa'] == 'eng'){
                                    echo $data['nama_eng'];
                                }
                            ?>
                        </option>
            <?php   }
            }

            // ###################################################################
            // Updated by Afif
            // ###################################################################
            if($fungsi == 'update_namatalent'){
                $talentId       = $_POST['in_talentid'];
                $namaDepan      = $_POST['in_namadepan'];
                $namaBelakang   = $_POST['in_namabelakang'];

                $nama_query = "UPDATE user SET nama_depan='$namaDepan', nama_belakang='$namaBelakang'
                    WHERE id='$talentId'";
                $aksi_update = mysqli_query($koneksi, $nama_query);

                if($aksi_update){
                    $_SESSION['nama']           = $namaDepan.' '.$namaBelakang;
                    $_SESSION['nama_depan']     = $namaDepan;
                    $_SESSION['nama_belakang']  = $namaBelakang;

                    echo json_encode(array('status' => 'success'));
                } else {
                    echo json_encode(array('status' => 'error'));
                }              
            }

            if($fungsi == 'lamar'){
                $nip   = $_POST['nip'];
                $id_lowongan   = $_POST['id_lowongan'];
                $sqltest = "select * from lamaran where nip = '$nip' and id_lowongan = $id_lowongan";
                $datasqltest = mysqli_query($koneksi,$sqltest);
                $jumlah=mysqli_num_rows($datasqltest);
                if($jumlah == 0){
                    $sql = "insert into lamaran (nip,id_lowongan,tgl_lamar)
                    values('$nip',$id_lowongan,now())";
                    $querytambah = mysqli_query($koneksi,$sql);
                }else{
                    $querytambah = true;
                }
                return $querytambah;
            }

            if($fungsi == 'lamarlagi'){
                $nip   = $_POST['nip'];
                $id_lowongan   = $_POST['id_lowongan'];
                $sql = "update lamaran set tarikberkas=null where nip = '$nip' and id_lowongan = $id_lowongan";
                $hasil = mysqli_query($koneksi,$sql);
                return $hasil;
            }

            if($fungsi == 'gantibahasa'){
                $bahasa   = $_POST['bahasa'];
                if($bahasa == 'ina'){
                    $_SESSION["bahasa"] = 'ina'; 
                }else{
                    $_SESSION["bahasa"] = 'eng'; 
                }
                return true;
            }

            if($fungsi == 'freelance'){
                $freelance  = $_POST['freelance'];
                $id         = $_POST['id'];
                $sql = "update user set freelance=$freelance where id = '$id'";
                $query = mysqli_query($koneksi,$sql);
                return $query;
            }

            if($fungsi == 'konfirmasi'){
                $id_pesan   = $_POST['id_pesan'];
                $sql = "update pesan set konfirmasi=1 where id = $id_pesan";
                $querykonfirmasi = mysqli_query($koneksi,$sql);
                return $querykonfirmasi;
            }

            if($fungsi == 'verifikasi'){
                $id   = $_POST['id'];
                $sql = "update user set verifikasi=1 where md5(id) = '$id'";
                $queryver = mysqli_query($koneksi,$sql);
                return $queryver;
            }

            if($fungsi == 'konfirmasitidakhadir'){
                $id_pesan   = $_POST['id_pesan'];
                $alasan   = $_POST['alasan'];
                $sql = "update pesan set konfirmasi=1, alasan='$alasan' where id = $id_pesan";
                $querykonfirmasi = mysqli_query($koneksi,$sql);
                return $querykonfirmasi;
            }

            if($fungsi == 'nonaktif'){
                $nip = $_SESSION['nip'];
                $id_lowongan   = $_POST['id_lowongan'];
                $sql = "update lowongan_kerja set status=0,nonaktif='$nip' where id = $id_lowongan";
                $querykonfirmasi = mysqli_query($koneksi,$sql);
                return $querykonfirmasi;
            }

            if($fungsi == 'aktif'){
                $nip = $_SESSION['nip'];
                $id_lowongan   = $_POST['id_lowongan'];
                 $sql = "update lowongan_kerja set status=1,aktif='$nip' where id = $id_lowongan";
                $querykonfirmasi = mysqli_query($koneksi,$sql);
                return $querykonfirmasi;
            }

            if($fungsi == 'nonaktifbanner'){
                $id_banner = $_POST['id_banner'];
                $sql = "update banner set status=0 where id = $id_banner";
                $querykonfirmasi = mysqli_query($koneksi,$sql);
                return $querykonfirmasi;
            }

            if($fungsi == 'aktifbanner'){
                $id_banner = $_POST['id_banner'];
                 $sql = "update banner set status=1 where id = $id_banner";
                $querykonfirmasi = mysqli_query($koneksi,$sql);
                return $querykonfirmasi;
            }

            if($fungsi == 'simpanpesan'){
                ini_set('display_errors',1);   
                error_reporting(E_ALL); 
                date_default_timezone_set('Etc/UTC');
                include "../assets/PHPMailer/classes/class.phpmailer.php";
                $id_lowongan        = $_POST['lowongan'];
                $jenis_training     = $_POST['jenis_training'];
                $isi                = $_POST['isi'];
                $subject            = $_POST['subject'];
                $nip                = $_POST['nipnya'];
                $tgl_pelaksanaan    = $_POST['tgl_pelaksanaan'];
                $jam                = $_POST['jam'];
                $pengirim  = $_SESSION['nip'];

                if (!empty($nip)) {
                    foreach ($nip as $key => $value) {
                        $semua = explode('+', $value);
                        $nipnya = $semua[0];
                        $email = $semua[1];
                        $no_wa = $semua[2];

                    // var_dump($semua);
                    // var_dump($nipnya);
                    // var_dump($email);
                    // var_dump($no_wa);
                    // die();
                        $sqltest = "select nip from pesan where nip = '$nipnya' and id_lowongan = $id_lowongan and jenis_training = $jenis_training";
                        $datasqltest = mysqli_query($koneksi,$sqltest);
                        $jumlah=mysqli_num_rows($datasqltest);
                        if ($jumlah == 0) {
                            $sql = "insert into pesan (id_lowongan, nip,pengirim, subject,jenis_training,isi,tgl_pesan,tgl_pelaksanaan,jam) values ($id_lowongan,'$nipnya','$pengirim','$subject',$jenis_training,'$isi',now(),'$tgl_pelaksanaan','$jam')";
                            mysqli_query($koneksi,$sql); 
                            $st=2;
                            $sql1 = "update lamaran set status='$st' where nip='$nipnya' and id_lowongan = $id_lowongan";
                            mysqli_query($koneksi,$sql1);

                            $subject = $subject;    
                            $message = "Anda mendapat pesan dari rabbani karir, silahkan buka akun rabbani karir anda"; 

                            $mail = new PHPMailer; 
                            $mail->IsSMTP();
                            $mail->SMTPSecure = 'ssl'; 
                            $mail->Host = "smtp.gmail.com";
                            $mail->SMTPDebug = 0;
                            $mail->Port = 465;
                            // $mail->Port = 587;
                            $mail->SMTPAuth = true;
                            $mail->Username = "rabbani.karir@gmail.com";
                            $mail->Password = "212rabbani2018karir";
                            $mail->setFrom("rabbani.karir@gmail.com","Rabbani Karir");
                            $mail->Subject = $subject; //subyek email
                            $mail->AddAddress($email);  //tujuan email
                            $mail->MsgHTML($message);  
                            $mail->send();


                            $data_whatsapp = new stdClass();
                            $data_whatsapp->token = "M00zwEyiemojKR9ilsECaE81QUjpdfNP5Bdp";
                            $data_whatsapp->phone = $no_wa;
                            $data_whatsapp->msg = $message;
                    
                            $dataJSON = json_encode($data_whatsapp);
                    
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://103.14.21.57/back_end/microservices/wha/send',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_SSL_VERIFYPEER => false,
                                CURLOPT_SSL_VERIFYHOST => false,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => array('data' =>$dataJSON),
                            ));
                            $response = curl_exec($curl);
                            curl_close($curl); 
                        } 
                    }
                } ?>

                <script language="javascript">
                    document.location = '../link4dm1n/formwawancara.php?lowongan='+<?php echo $id_lowongan ?>+'&notif=1';
                </script><?php    
            }

            // ###################################################################
            // Updated by afif
            // ###################################################################
            if($fungsi == "simpanbiodata"){

                $status_form                = $_POST['statusform'];
                $talent_id                  = $_POST['talentid'];
                $nama_lengkap               = $_POST['nama_lengkap'];
                $nik                        = $_POST['nik'];
                $tempat_lahir               = $_POST['tempat_lahir'];
                $tgl_lahir                  = $_POST['tgl_lahir'];

                if($status_form == 'kosong'){
                    $biodata_query = "INSERT INTO talent_biodata (talent_id, nama, nik, tempat_lahir, tgl_lahir) VALUES ('$talent_id', '$nama_lengkap', '$nik', '$tempat_lahir', '$tgl_lahir')";
                } else {
                    $biodata_query = "UPDATE talent_biodata SET nama='$nama_lengkap', nik='$nik', tempat_lahir='$tempat_lahir', tgl_lahir='$tgl_lahir'";
                }

                $aksi_biodata = mysqli_query($koneksi, $biodata_query);
                if($aksi_biodata){
                    $data_talent = array(
                        'status'        => 1,
                        'nik'           => $nik,
                        'tempat_lahir'  => $tempat_lahir,
                        'tgl_lahir'     => $tgl_lahir,
                    );
                } else {
                    $data_talent = array(
                        'status'        => 2
                    );
                }

                echo json_encode($data_talent);
            } 

            if ($fungsi == "simpanbiodatapribadi2") {
                $errorpp = 2;
                $gambar = $_FILES['gambar']['name'];   
                if($gambar == ''){
                    $foto        = $_POST['fotolama'];
                } else {
                    $ekstensi_diperbolehkan = array('png','jpg','jpeg');
                    $filebaru= $_FILES['gambar']['name'];
                    $x = explode('.', $filebaru);
                    $ekstensi = strtolower($x[1]);
                    $ukuran = $_FILES['gambar']['size'];
                    if($ukuran < 1000000){ 
                        $file_tmp = $_FILES['gambar']['tmp_name'];
                        if(in_array($ekstensi, $ekstensi_diperbolehkan) == true){
                            $namabaru = "pp-".round(microtime(true)) . '.' .$ekstensi;
                            move_uploaded_file($file_tmp, '../images/pp/'.$namabaru);
                            $foto = "images/pp/".$namabaru;
                            if($_POST['fotolama'] != ''){
                                unlink("../".$_POST['fotolama']);
                            }
                        }else{
                            $errorpp = 0;
                            if($_POST['fotolama'] == ''){
                                $foto = "";
                            }else{
                                $foto = $_POST['fotolama'];
                            }
                        }
                    } else {
                        $errorpp = 1;
                        if($_POST['fotolama'] == ''){
                            $foto = "";
                        }else{
                            $foto = $_POST['fotolama'];
                        }
                    }
                }

                $errorktp=2;
                $ktp = $_FILES['ktp']['name'];   
                if($ktp == ''){
                    $fotoktp        = $_POST['ktplama'];
                }else{
                    $ekstensi_diperbolehkan = array('png','jpg','jpeg');
                    $filebaru= $_FILES['ktp']['name'];
                    $x = explode('.', $filebaru);
                    $ekstensi = strtolower($x[1]);
                    $ukuran = $_FILES['ktp']['size'];
                    if($ukuran < 1000000){ 
                        $file_tmp = $_FILES['ktp']['tmp_name'];
                        if(in_array($ekstensi, $ekstensi_diperbolehkan) == true){
                            $namabaru = "ktp-".round(microtime(true)) . '.' .$ekstensi;
                            move_uploaded_file($file_tmp, '../images/ktp/'.$namabaru);
                            $fotoktp = "images/ktp/".$namabaru;
                            if($_POST['ktplama'] != ''){
                                unlink("../".$_POST['ktplama']);
                            }
                        }else{
                            $errorktp = 0;
                            if($_POST['ktplama'] == ''){
                                $fotoktp = "";
                            }else{
                                $fotoktp = $_POST['ktplama'];
                            }
                        }
                    }else{
                        $errorktp = 1;
                        if($_POST['ktplama'] == ''){
                            $fotoktp = "";
                        }else{
                            $fotoktp = $_POST['ktplama'];
                        }
                    }
                }

                $nip        = $_POST['nip'];
                $nama       = $_POST['nama'];
                $jenis      = $_POST['jenis'];
                $alamat     = $_POST['alamat'];
                $tgllahir   = $_POST['tanggal'];
                $tmptlahir  = $_POST['tempat'];
                $status     = $_POST['status'];
                $jumlahanak = $_POST['jumlahanak'];
                $agama      = $_POST['agama'];

                $no_ktp     = $_POST['ktp'];
                $tlp        = $_POST['tlpn'];
                $hp         = $_POST['nohp'];
                $golongan   = $_POST['golongan'];
                $email      = $_POST['email'];
                $tinggal    = $_POST['tinggal'];

                if($tinggal == '0'){
                    $provinsi   = '35';
                    $kabkota    = '502';
                    $kecamatan  = '6981';
                    $kelurahan = '80939';
                    $pos = '70287';
                }else{
                    $provinsi   = $_POST['provinsi'];
                    $kabkota    = $_POST['kabupaten'];
                    $kecamatan  = $_POST['kecamatan'];
                    $dataposkel = $_POST['pos'];
                    $bagi = explode('-', $dataposkel);
                    $kelurahan = $bagi[0];
                    $pos = $bagi[1];
                }

                $levelform        = $_POST['levelform'];
                if($levelform == 'kosong'){

                    $sql1 = "insert into tbl_x_karyawan 
                    (nip,nama,jenis,alamat,provinsi,kabkota,kecamatan,kelurahan,pos,tgllahir,tmptlahir,status,jumlahanak,tinggal)
                    values('$nip','$nama',$jenis,'$alamat',$provinsi,$kabkota,$kecamatan,$kelurahan,'$pos','$tgllahir','$tmptlahir',$status,$jumlahanak,$tinggal)";
                    
                    $sql2 = "insert into karyawan_pribadi 
                    (nip,no_ktp,ktp,tlp,hp,foto,golongan,email,agama)
                    values('$nip','$no_ktp','$fotoktp','$tlp','$hp','$foto','$golongan','$email','$agama')";
                }else{
                    $sql1 = "update tbl_x_karyawan set nama='$nama',jenis=$jenis,alamat='$alamat',provinsi=$provinsi,kabkota=$kabkota,kecamatan=$kecamatan,kelurahan=$kelurahan,pos='$pos',tgllahir='$tgllahir',tmptlahir='$tmptlahir',status=$status,jumlahanak=$jumlahanak,tinggal=$tinggal where nip ='$nip'";
                    $sql2 = "update karyawan_pribadi set no_ktp='$no_ktp',tlp='$tlp',hp='$hp',foto='$foto',golongan='$golongan',email='$email', agama='$agama', ktp='$fotoktp' where nip ='$nip'";
                }

                $querytambah1 = mysqli_query($koneksi,$sql1);
                $querytambah2 = mysqli_query($koneksi,$sql2);
                if($querytambah1 and $querytambah2) { ?>
                    <script language="javascript">
                       document.location = '../dashboard/index.php?notif=1&pp='+<?php echo $errorpp; ?>+'&ktp='+<?php echo $errorktp; ?>;
                    </script>
                    <?php
                }else{
                    ?>
                    <script language="javascript">
                        document.location = '../dashboard/index.php?notif=2&pp='+<?php echo $errorpp; ?>+'&ktp='+<?php echo $errorktp; ?>;
                    </script>
                    <?php
                }
            }

            if($fungsi == "simpanpendidikanformal"){
                mysqli_autocommit($koneksi,FALSE);
                $no = 0;
                $nip = $_SESSION['nip'];

                $waktu       = round(microtime(true));
                $ekstensi_diperbolehkan = array('pdf');

                if(empty($_POST['filelama'])){
                    $filebaru= $_FILES['filebaru']['name'];
                    $x = explode('.', $filebaru);
                    $ekstensi = strtolower($x[1]);
                    $ukuran = $_FILES['filebaru']['size'];
                    $file_tmp = $_FILES['filebaru']['tmp_name']; 

                    if($ukuran <= 1000000){ 
                        $namabaru = 'file/ijazah/ijz-'.$waktu.'.'.$ekstensi;
                        move_uploaded_file($file_tmp,'../'.$namabaru);
                        $sql1 = "insert into berkas (nip,nama,file)
                        values('$nip','ijazah terakhir','$namabaru')";
                    }else{
                        $sql1 = "kosong";
                    }
                }else{
                    if(!empty($_FILES['filebaru']['name'])){
                        $filebaru= $_FILES['filebaru']['name'];
                        $x = explode('.', $filebaru);
                        $ekstensi = strtolower($x[1]);
                        $ukuran = $_FILES['filebaru']['size'];
                        $file_tmp = $_FILES['filebaru']['tmp_name']; 
                        $namabaru = 'file/ijazah/ijz-'.$waktu.'.'.$ekstensi;
                        move_uploaded_file($file_tmp,'../'.$namabaru);
                        $sql1 = "update berkas set file='$namabaru' where nip='$nip'";
                        unlink('../'.$_POST['filelama']);
                    }else{
                        $sql1 = "kosong";
                    }
                }
                if($sql1=="kosong"){
                    $tambah1 = true;
                }else{
                    $tambah1 = mysqli_query($koneksi,$sql1);
                }

                $hapus = mysqli_query($koneksi, "delete from karyawan_formal WHERE nip='$nip'");
                if(isset($_POST['jp'])){
                    $filesCount = count($_POST['jp']);
                    $kode_formal = $_POST['jp'];
                    $nama        = $_POST['nama'];
                    $dari        = $_POST['dari'];
                    $sampai      = $_POST['sampai'];
                    $status      = $_POST['status'];
                    $catatan     = $_POST['catatan'];
                    $jurusan     = $_POST['jurusan'];

                    for($i = 0; $i < $filesCount; $i++){
                        $catatannya = str_replace("'","&#39;", $catatan[$i]);
                        $catatannya= str_replace('"',"&#34;", $catatannya);
                        $jurusannya = str_replace("'","&#39;", $jurusan[$i]);
                        $jurusannya= str_replace('"',"&#34;", $jurusannya);
                        $namanya = str_replace("'","&#39;", $nama[$i]);
                        $namanya= str_replace('"',"&#34;", $namanya);
                        $arr[]="('$nip',$kode_formal[$i],'$namanya','$dari[$i]-01-01','$sampai[$i]-01-01','$status[$i]','$catatannya',$i,'$jurusannya')";
                    }
                    $valuenya=implode(",", $arr);
                    $sql1 = "insert into karyawan_formal values".$valuenya;
                    $tambah2 = mysqli_query($koneksi,$sql1);
                }else{
                    $tambah2 = true;
                }

                if($tambah1 and $hapus and $tambah2){
                    mysqli_commit($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../dashboard/pendidikanformal.php?notif=1';
                    </script>
                    <?php
                }else{
                    mysqli_rollback($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../dashboard/pendidikanformal.php?notif=2';
                    </script>
                    <?php
                }   
            }

            if($fungsi == "simpandatakeluarga"){
                mysqli_autocommit($koneksi,FALSE);
                $no = 0;
                $nip = $_SESSION['nip'];
                $hapus = mysqli_query($koneksi, "delete from karyawan_hubungan WHERE nip='$nip'");
                if(isset($_POST['nama'])){
                    $filesCount = count($_POST['nama']);
                    $nama            = $_POST['nama'];
                    $jenis_hubungan  = $_POST['jenis_hubungan'];
                    $jenis_kelamin   = $_POST['jenis_kelamin'];
                    $tempat_lahir    = $_POST['tempat_lahir'];
                    $tanggal_lahir   = $_POST['tanggal_lahir'];
                    $catatan         = $_POST['catatan'];

                    for($i = 0; $i < $filesCount; $i++){
                        if(!empty($nama[$i])){
                            $catatannya = str_replace("'","&#39;", $catatan[$i]);
                            $catatannya= str_replace('"',"&#34;", $catatannya);
                            $namanya = str_replace("'","&#39;", $nama[$i]);
                            $namanya= str_replace('"',"&#34;", $namanya);
                            $tempatlahir = str_replace("'","&#39;", $tempat_lahir[$i]);
                            $tempatlahir= str_replace('"',"&#34;", $tempatlahir);
                            $arr[] = "('$nip','$namanya',$jenis_hubungan[$i],$jenis_kelamin[$i],'$tempatlahir','$tanggal_lahir[$i]','$catatannya',$i)";
                        }
                    }
                    $valuenya=implode(',', $arr);
                    $sql1 = "insert into karyawan_hubungan values".$valuenya;
                    $querytambah1 = mysqli_query($koneksi,$sql1);
                }else{
                    $querytambah1 = true;
                }

                if($querytambah1 and $hapus) { 
                    mysqli_commit($koneksi);
                    ?>
                    <script language="javascript">
                       document.location = '../dashboard/datakeluarga.php?notif=1';
                    </script>
                    <?php
                }else{
                    mysqli_rollback($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../dashboard/datakeluarga.php?notif=2';
                    </script>
                    <?php
                }
            }

            if($fungsi == "simpankeahlianbahasa" ){
                mysqli_autocommit($koneksi,FALSE);
                $no = 0;
                $nip = $_SESSION['nip'];
                $hapus = mysqli_query($koneksi, "delete from karyawan_berbahasa WHERE nip='$nip'");
                if(isset($_POST['bahasa'])){
                    $filesCount = count($_POST['bahasa']);
                    $bahasa = $_POST['bahasa'];
                    $kemampuan       = $_POST['kemampuan'];
                    for($i = 0; $i < $filesCount; $i++){
                        if(!empty($bahasa[$i])){
                            $arr[] = "($bahasa[$i],$kemampuan[$i],'$nip')";
                        }
                    }
                    $valuenya = implode(',', $arr);
                    $sql1 = "insert into karyawan_berbahasa values".$valuenya;
                    $querytambah1 = mysqli_query($koneksi,$sql1);
                }else{
                    $querytambah1 = true;
                }

                if($querytambah1 and $hapus) { 
                    mysqli_commit($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../dashboard/keahlianbahasa.php?notif=1';
                    </script>
                    <?php
                }else{
                    mysqli_rollback($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../dashboard/keahlianbahasa.php?notif=2';
                    </script>
                    <?php
                }
            }

            if($fungsi == "datapengalamankerja" ){
                mysqli_autocommit($koneksi,FALSE);
                $no = 0;
                $nip = $_SESSION['nip'];
                $hapus = mysqli_query($koneksi, "delete from karyawan_pengalaman WHERE nip='$nip'");
                if(isset($_POST['pekerjaan'])){
                    $filesCount = count($_POST['pekerjaan']);
                    $nama_prusahaan = $_POST['nama_prusahaan'];
                    $pekerjaan      = $_POST['pekerjaan'];
                    $dari           = $_POST['dari'];
                    $sampai         = $_POST['sampai'];
                    $sallary        = $_POST['sallary'];
                    $alasan         = $_POST['alasan'];
                    $banyakrecordlevel = $_POST['banyakrecordlevel'];

                    for($i = 0; $i < $filesCount; $i++){
                        if(!empty($nama_prusahaan[$i])){
                            $alasannya = str_replace("'","&#39;", $alasan[$i]);
                            $alasannya= str_replace('"',"&#34;", $alasannya);
                            $namanya = str_replace("'","&#39;", $nama_prusahaan[$i]);
                            $namanya= str_replace('"',"&#34;", $namanya);
                            $pekerjaannya = str_replace("'","&#39;", $pekerjaan[$i]);
                            $pekerjaannya= str_replace('"',"&#34;", $pekerjaannya);
                            $arr[] = "('$nip',$i,'$namanya','$pekerjaannya','$dari[$i]','$sampai[$i]',$sallary[$i],'$alasannya')";
                        }
                    }
                    $valuenya = implode(',', $arr);
                    $sql1 = "insert into karyawan_pengalaman (nip,seq,nama_perusahaan,pekerjaan,dari,sampai,sallary,alasan) values".$valuenya;
                    $querytambah1 = mysqli_query($koneksi,$sql1);
                }else{
                    $querytambah1 = true;
                }

                if($querytambah1 and $hapus) { 
                    mysqli_commit($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../dashboard/pengalamankerja.php?notif=1';
                    </script>
                    <?php
                }else{
                    mysqli_rollback($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../dashboard/pengalamankerja.php?notif=2';
                    </script>
                    <?php
                }
            }

            if($fungsi == "datapendidikannonformal" ){
                mysqli_autocommit($koneksi,FALSE);
                $no = 0;
                $nip = $_SESSION['nip'];
                $sqldelet = "delete from karyawan_non WHERE nip='$nip'";
                $hapus = mysqli_query($koneksi, $sqldelet);
                if(isset($_POST['jeniskursus']) ){
                    $filesCount = count($_POST['jeniskursus']);
                    $non         = $_POST['jeniskursus'];
                    $nama        = $_POST['namatempat'];
                    $alamat      = $_POST['alamat'];
                    $lama        = $_POST['lama'];
                    $jenis_lama  = $_POST['satuan'];
                    $berijazah   = $_POST['berijazah'];
                    $lulusan     = $_POST['lulusan'];

                    for($i = 0; $i < $filesCount; $i++){
                        if(!empty($non[$i])){
                            $nonnya = str_replace("'","&#39;", $non[$i]);
                            $nonnya= str_replace('"',"&#34;", $nonnya);
                            $namanya = str_replace("'","&#39;", $nama[$i]);
                            $namanya= str_replace('"',"&#34;", $namanya);
                            $alamatnya = str_replace("'","&#39;", $alamat[$i]);
                            $alamatnya= str_replace('"',"&#34;", $alamatnya);
                            $arr[]="('$nip','$nonnya','$namanya','$alamatnya','$lama[$i]','$jenis_lama[$i]','$berijazah[$i]',$i,$lulusan[$i])";
                        }
                    }

                    $valuenya=implode(",", $arr);
                    $sql1 = "insert into karyawan_non values".$valuenya;
                    $querytambah1 = mysqli_query($koneksi,$sql1);
                }else{
                    $querytambah1 = true;
                }

                if($querytambah1 and $hapus) { 
                    mysqli_commit($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../dashboard/pendidikannonformal.php?notif=1';
                    </script>
                    <?php
                }else{
                    mysqli_rollback($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../dashboard/pendidikannonformal.php?notif=2';
                    </script>
                    <?php
                }
            }

            if($fungsi == "datatambahlowongan"){
                $departemen     = $_POST['departemen'];
                $posisi         = $_POST['posisi'];
                $level          = $_POST['level'];
                $penempatan     = $_POST['penempatan'];
                $tgl_awal       = $_POST['tgl_awal'];
                $tgl_akhir      = $_POST['tgl_akhir'];
                $deskripsi      = $_POST['deskripsi'];
                $persyaratan    = $_POST['persyaratan'];
                $deskripsieng   = $_POST['deskripsieng'];
                $persyarataneng = $_POST['persyarataneng'];
                $waktu          = round(microtime(true));
                $penginput      = $_SESSION['nip'];

                $ekstensi_diperbolehkan = array('png','jpg','jpeg');
                $cekposter = 1;
                if(isset($_POST['lowongan'])){
                    $id = $_POST['lowongan'];
                    $sql1 = "update lowongan_kerja set departemen='$departemen', posisi='$posisi',level=$level,penempatan='$penempatan',tgl_awal='$tgl_awal',tgl_akhir='$tgl_akhir',deskripsi='$deskripsi',persyaratan='$persyaratan',deskripsieng='$deskripsieng',persyarataneng='$persyarataneng',pengedit='$penginput'";
                    if(empty($_FILES['poster']['name'])){
                        if(isset($_POST['hapus'])){
                            unlink('../'.$_POST['posterlama']);
                            $sql1 .= ",poster=null where id =$id";
                        }else{
                            $sql1 .= " where id =$id";
                        }
                        
                    }else{
                        $poster = $_FILES['poster']['name'];
                        $x = explode('.', $poster);
                        $ekstensi = strtolower($x[1]);
                        $ukuran = $_FILES['poster']['size'];
                        $file_tmp = $_FILES['poster']['tmp_name']; 
                        
                        if($ukuran <= 200000){ 
                            $namabaru = 'images/lowongan/PL-'.$waktu.'.'.$ekstensi;
                            move_uploaded_file($file_tmp,'../'.$namabaru);
                            $sql1 .= ",poster='$namabaru' where id =$id";
                            if($_POST['posterlama'] != ''){
                                unlink('../'.$_POST['posterlama']);
                            }
                        }else{
                            $sql1 .= " where id =$id";
                            $cekposter = 0;
                        }
                        
                    }
                }else{
                    if(empty($_FILES['poster']['name'])){
                        $sql1 = "insert into lowongan_kerja (departemen, posisi,level,penempatan,tgl_awal,tgl_akhir,deskripsi,persyaratan,deskripsieng,persyarataneng,penginput)
                            values('$departemen','$posisi',$level,'$penempatan','$tgl_awal','$tgl_akhir','$deskripsi','$persyaratan','$deskripsieng','$persyarataneng','$penginput')";
                    }else{
                        $poster = $_FILES['poster']['name'];
                        $x = explode('.', $poster);
                        $ekstensi = strtolower($x[1]);
                        $ukuran = $_FILES['poster']['size'];
                        $file_tmp = $_FILES['poster']['tmp_name']; 

                        if($ukuran <= 200000){ 
                            $namabaru = 'images/lowongan/PL-'.$waktu.'.'.$ekstensi;
                            move_uploaded_file($file_tmp,'../'.$namabaru);
                            $sql1 = "insert into lowongan_kerja (departemen, posisi,level,penempatan,tgl_awal,tgl_akhir,deskripsi,persyaratan,deskripsieng,persyarataneng,poster,penginput)
                            values('$departemen','$posisi',$level,'$penempatan','$tgl_awal','$tgl_akhir','$deskripsi','$persyaratan','$deskripsieng','$persyarataneng','$namabaru','$penginput')";
                        }else{
                            $sql1 = "insert into lowongan_kerja (departemen, posisi,level,penempatan,tgl_awal,tgl_akhir,deskripsi,persyaratan,deskripsieng,persyarataneng,penginput)
                            values('$departemen','$posisi',$level,'$penempatan','$tgl_awal','$tgl_akhir','$deskripsi','$persyaratan','$deskripsieng','$persyarataneng','$penginput')";
                            $cekposter = 0;
                        }
                    }
                }
                $querytambah1 = mysqli_query($koneksi,$sql1);
                
                if($querytambah1) { ?>
                    <?php if ($cekposter == 1) { ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/home.php?notif=4';
                        </script>
                    <?php } else { ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/home.php?notif=5';
                        </script>
                    <?php } ?>
                        
                    ?>
                <?php }else{ ?>
                    <script language="javascript">
                        document.location = '../link4dm1n/home.php?notif=2';
                    </script>
                <?php
                }
            }

            if($fungsi == "databanner"){
                $seq      = $_POST['seq'];
                $bahasa   = $_POST['bahasa']; 
                $waktu    = round(microtime(true));
                $ekstensi_diperbolehkan = array('png','jpg','jpeg');
                $upfile=$_FILES['foto']['tmp_name'];

                $size = getimagesize($upfile);
                $width = $size[0];
                $height = $size[1];
                if (($width >= 4400 || $height >= 1700)&&($width <= 4490 || $height <= 1756)) {
                    if(isset($_POST['id_banner'])){
                        $id = $_POST['id_banner'];
                        $sql1 = "update banner set seq=$seq, bahasa='$bahasa'";
                        if(empty($_FILES['foto']['name'])){
                            $sql1 .= " where id =$id";
                        }else{
                            $foto = $_FILES['foto']['name'];
                            $x = explode('.', $foto);
                            $ekstensi = strtolower($x[1]);
                            $ukuran = $_FILES['foto']['size'];
                            $file_tmp = $_FILES['foto']['tmp_name']; 
                            $namabaru = 'images/banner/banner-'.$waktu.'.'.$ekstensi;
                            move_uploaded_file($file_tmp,'../'.$namabaru);
                            $sql1 .= ",foto='$namabaru' where id =$id";
                            if($_POST['fotolama'] != ''){
                                unlink('../'.$_POST['fotolama']);
                            }
                        }
                    }else{
                        $foto = $_FILES['foto']['name'];
                        $x = explode('.', $foto);
                        $ekstensi = strtolower($x[1]);
                        $ukuran = $_FILES['foto']['size'];
                        $file_tmp = $_FILES['foto']['tmp_name']; 
    
                        if($ukuran <= 1000000){ 
                            $namabaru = 'images/banner/banner-'.$waktu.'.'.$ekstensi;
                            move_uploaded_file($file_tmp,'../'.$namabaru);
                            $sql1 = "insert into banner (foto,seq,status,bahasa)
                            values('$namabaru',$seq,1,'$bahasa')";
                        }else{
                            $sql1 = "kosong";
                        }
                    }
                    $querybanner = mysqli_query($koneksi,$sql1);
                    if($querybanner) { ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/banner.php?notif=4';
                        </script>
                    <?php }else{ ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/banner.php?notif=2';
                        </script>
                    <?php
                    }
                    // echo $width;
                    // echo " x ";
                    // echo  $height;
                    
                }else{
                    ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/banner.php?notif=6';
                        </script>
                    <?php
                    // echo $width;
                    // echo " x ";
                    // echo  $height;
                }
            }
            if($fungsi == "datadepartemen"){
                $nama_departemen      = $_POST['nama_departemen']; 
                $waktu    = round(microtime(true));
                $ekstensi_diperbolehkan = array('png','jpg','jpeg');
                $upfile=$_FILES['foto']['tmp_name'];

                $size = getimagesize($upfile);
                $width = $size[0];
                $height = $size[1];
                if (($width >= 400 || $height >= 400)&&($width <= 500 || $height <= 500)) {
                    if(isset($_POST['id_departemen'])){
                        $id = $_POST['id_departemen'];
                        $sql_dept = "update departemen set nama_departemen='$nama_departemen'";
                        if(empty($_FILES['foto']['name'])){
                            $sql_dept .= " where id =$id";
                        }else{
                            $foto = $_FILES['foto']['name'];
                            $x = explode('.', $foto);
                            $ekstensi = strtolower($x[1]);
                            $ukuran = $_FILES['foto']['size'];
                            $file_tmp = $_FILES['foto']['tmp_name']; 
                            $namabaru = 'images/departemen/departemen-'.$waktu.'.'.$ekstensi;
                            move_uploaded_file($file_tmp,'../'.$namabaru);
                            $sql_dept .= ",foto='$namabaru' where id =$id";
                            if($_POST['fotolama'] != ''){
                                unlink('../'.$_POST['fotolama']);
                            }
                        }
                    }else{
                        $foto = $_FILES['foto']['name'];
                        $x = explode('.', $foto);
                        $ekstensi = strtolower($x[1]);
                        $ukuran = $_FILES['foto']['size'];
                        $file_tmp = $_FILES['foto']['tmp_name']; 
    
                        if($ukuran <= 1000000){ 
                            $namabaru = 'images/departemen/departemen-'.$waktu.'.'.$ekstensi;
                            move_uploaded_file($file_tmp,'../'.$namabaru);
                            $sql_dept = "insert into departemen (nama_departemen, foto)
                            values('$nama_departemen', '$namabaru')";
                        }else{
                            $sql_dept = "kosong";
                        }
                    }
                    $querydepartemen = mysqli_query($koneksi,$sql_dept);
                    if($querydepartemen) { ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/departemen.php?notif=4';
                        </script>
                    <?php }else{ ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/departemen.php?notif=2';
                        </script>
                    <?php
                    }
                    // echo $width;
                    // echo " x ";
                    // echo  $height;
                    
                }else{
                    ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/departemen.php?notif=6';
                        </script>
                    <?php
                    // echo $width;
                    // echo " x ";
                    // echo  $height;
                }
            }

            if($fungsi == "datatambahtraining"){
                mysqli_autocommit($koneksi,FALSE);
                $jenis      = $_POST['jenis'];
                $tempat       = $_POST['tempat'];
                $tgl_pelaksanaan  = $_POST['tgl_pelaksanaan'];
                $jam_mulai    = $_POST['jam_mulai'];
                $jam_akhir   = $_POST['jam_akhir'];
                $penginput  = $_SESSION['nip'];

                if(isset($_POST['training'])){
                    $id = $_POST['training'];
                    $sql1 = "update training set jenis=$jenis,tempat='$tempat',tgl_pelaksanaan='$tgl_pelaksanaan',jam_mulai='$jam_mulai',jam_akhir='$jam_akhir',pengedit='$penginput' where id =$id";
                    $querytambah1 = mysqli_query($koneksi,$sql1);
                    $idtraining = $id;
                }else{
                    $sql1 = "insert into training (jenis,tempat,tgl_pelaksanaan,jam_mulai,jam_akhir,penginput,kategori)
                    values('$jenis','$tempat','$tgl_pelaksanaan','$jam_mulai','$jam_akhir','$penginput','2')";
                    $querytambah1 = mysqli_query($koneksi,$sql1);
                    $idtraining = mysqli_insert_id($koneksi);
                }

                $hapus = mysqli_query($koneksi, "delete from detailtraining WHERE id_training='$idtraining'");
                if(isset($_POST['d_jam_mulai'])){
                    $filesCount = count($_POST['d_jam_mulai']);
                    $jam_mulai  = $_POST['d_jam_mulai'];
                    $jam_akhir  = $_POST['d_jam_akhir'];
                    $materi     = $_POST['d_materi'];
                    $pemateri   = $_POST['d_pemateri'];
    
                    for($i = 0; $i < $filesCount; $i++){
                        if(!empty($jam_mulai[$i])){
                            $arr[] = "($idtraining,'$jam_mulai[$i]','$jam_akhir[$i]','$materi[$i]','$pemateri[$i]')";
                        }
                    }
                    $valuenya=implode(',', $arr);
                    $sql = "insert into detailtraining (id_training,jam_mulai,jam_akhir,materi,pemateri)
                            values".$valuenya;
                    $querytambah2 = mysqli_query($koneksi,$sql);
                }else{
                    $querytambah2 = true;
                }

                if($querytambah1 and $hapus and $querytambah2) { 
                    mysqli_commit($koneksi);
                    if(isset($_POST['d_jam_mulai'])){
                        ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/tambahtraining.php?training='+ <?php echo $idtraining; ?> +'&notif=4';
                        </script>
                        <?php
                    }else{
                        ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/tambahtraining.php?training='+ <?php echo $idtraining; ?> +'&notif=3';
                        </script>
                        <?php
                    }
                }else{
                    mysqli_rollback($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../link4dm1n/tambahtraining.php?training='+ <?php echo $idtraining; ?> +'&notif=2';
                    </script>
                    <?php
                }
            }

            if($fungsi == "datatambahtesting"){
                mysqli_autocommit($koneksi,FALSE);
                $jenis      = $_POST['jenis'];
                $tempat       = $_POST['tempat'];
                $tgl_pelaksanaan  = $_POST['tgl_pelaksanaan'];
                $jam_mulai    = $_POST['jam_mulai'];
                $jam_akhir   = $_POST['jam_akhir'];
                $penginput  = $_SESSION['nip'];

                if(isset($_POST['training'])){
                    $id = $_POST['training'];
                    $sql1 = "update training set jenis=$jenis,tempat='$tempat',tgl_pelaksanaan='$tgl_pelaksanaan',jam_mulai='$jam_mulai',jam_akhir='$jam_akhir',pengedit='$penginput' where id =$id";
                    $querytambah1 = mysqli_query($koneksi,$sql1);
                    $idtraining = $id;
                }else{
                    $sql1 = "insert into training (jenis,tempat,tgl_pelaksanaan,jam_mulai,jam_akhir,penginput,kategori)
                    values('$jenis','$tempat','$tgl_pelaksanaan','$jam_mulai','$jam_akhir','$penginput','1')";
                    $querytambah1 = mysqli_query($koneksi,$sql1);
                    $idtraining = mysqli_insert_id($koneksi);
                }

                $hapus = mysqli_query($koneksi, "delete from detailtraining WHERE id_training='$idtraining'");
                if(isset($_POST['d_jam_mulai'])){
                    $filesCount = count($_POST['d_jam_mulai']);
                    $jam_mulai  = $_POST['d_jam_mulai'];
                    $jam_akhir  = $_POST['d_jam_akhir'];
                    $materi     = $_POST['d_materi'];
                    $pemateri   = $_POST['d_pemateri'];
    
                    for($i = 0; $i < $filesCount; $i++){
                        if(!empty($jam_mulai[$i])){
                            $arr[] = "($idtraining,'$jam_mulai[$i]','$jam_akhir[$i]','$materi[$i]','$pemateri[$i]')";
                        }
                    }
                    $valuenya=implode(',', $arr);
                    $sql = "insert into detailtraining (id_training,jam_mulai,jam_akhir,materi,pemateri)
                            values".$valuenya;
                    $querytambah2 = mysqli_query($koneksi,$sql);
                }else{
                    $querytambah2 = true;
                }

                if($querytambah1 and $hapus and $querytambah2) { 
                    mysqli_commit($koneksi);
                    if(isset($_POST['d_jam_mulai'])){
                        ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/tambahtesting.php?testing='+ <?php echo $idtraining; ?> +'&notif=4';
                        </script>
                        <?php
                    }else{
                        ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/tambahtesting.php?testing='+ <?php echo $idtraining; ?> +'&notif=3';
                        </script>
                        <?php
                    }
                }else{
                    mysqli_rollback($koneksi);
                    ?>
                    <script language="javascript">
                        document.location = '../link4dm1n/tambahtesting.php?testing='+ <?php echo $idtraining; ?> +'&notif=2';
                    </script>
                    <?php
                }
            }

            if($fungsi == 'tambahabsen'){
                $nip   = $_POST['nip'];
                $id_training   = $_POST['id_training'];
                $sql = "
                select * from training
                where id = $id_training";
                $cek=mysqli_query($koneksi, $sql);
                $datatra=mysqli_fetch_array($cek);
                if($datatra['tgl_pelaksanaan'] == date('Y-m-d')){
                    $sql = "
                    select count(*) as jumlah from absen tbl1
                    inner join training tbl2 on tbl2.id = tbl1.id_training 
                    where id_training = $id_training and nip = '$nip' and tbl2.tgl_pelaksanaan = DATE_FORMAT(tbl1.hadir, '%Y-%m-%d')";
                    $cek=mysqli_query($koneksi, $sql);
                    $dataabsen=mysqli_fetch_array($cek);
                    if($dataabsen['jumlah'] == 0){
                        $sql = "insert into absen (nip,id_training,hadir)
                        values('$nip',$id_training,now())";
                        $querytambah = mysqli_query($koneksi,$sql);
                        if($querytambah) { 
                            $sql = "select materi from detailtraining where id_training = '$id_training'";
                            $datamateri=mysqli_query($koneksi, $sql);
                            while($datam=mysqli_fetch_array($datamateri)){ 
                                $materi = $datam['materi'];
                                $sql = "select count(*) as jumlah from matericalon where materi = $materi and nip = '$nip'";
                                $cekmateri=mysqli_query($koneksi, $sql);
                                $hasilcekmateri=mysqli_fetch_array($cekmateri);
                                if($hasilcekmateri['jumlah'] == 0){
                                    $sql = "insert into matericalon (nip,materi)
                                    values('$nip',$materi)";
                                    $querytambahmateri = mysqli_query($koneksi,$sql);
                                }
                            } ?>

                            <script language="javascript">
                                document.location = '../link4dm1n/formabsensi.php?notif=4&testing='+<?php echo $id_training; ?>;
                            </script>
                        <?php }else{ ?>
                            <script language="javascript">
                                document.location = '../link4dm1n/formabsensi.php?notif=2&testing='+<?php echo $id_training; ?>;
                            </script>
                        <?php
                        }
                    }else{ 
                        $sql = "update absen set pulang=now()
                            where id_training = $id_training and nip = '$nip' and DATE_FORMAT(hadir, '%Y-%m-%d')= DATE_FORMAT(now(), '%Y-%m-%d')";
                        $querytambah = mysqli_query($koneksi,$sql);
                        if($querytambah) { ?>
                            <script language="javascript">
                                document.location = '../link4dm1n/formabsensi.php?notif=2&testing='+<?php echo $id_training; ?>;
                            </script>
                        <?php }else{ ?>
                            <script language="javascript">
                                document.location = '../link4dm1n/formabsensi.php?notif=3&testing='+<?php echo $id_training; ?>;
                            </script>
                        <?php
                        }
                    }
                }else{ ?>
                    <script language="javascript">
                        document.location = '../link4dm1n/formabsensi.php?notif=3&testing='+<?php echo $id_training; ?>;
                    </script>
                <?php
                } 
            }

            if($fungsi == 'tambahabsenn'){
                $nip   = $_POST['nip'];
                $id_training   = $_POST['id_training'];
                $sql = "
                select * from training
                where id = $id_training";
                $cek=mysqli_query($koneksi, $sql);
                $datatra=mysqli_fetch_array($cek);
                $tanggalpel = $datatra['tgl_pelaksanaan'];
                $sql = "
                select count(*) as jumlah from absen tbl1
                inner join training tbl2 on tbl2.id = tbl1.id_training 
                where id_training = $id_training and nip = '$nip' and tbl2.tgl_pelaksanaan = DATE_FORMAT(tbl1.hadir, '%Y-%m-%d')";
                $cek=mysqli_query($koneksi, $sql);
                $dataabsen=mysqli_fetch_array($cek);
                if($dataabsen['jumlah'] == 0){
                    $sql = "insert into absen (nip,id_training,hadir)
                    values('$nip',$id_training,'$tanggalpel')";
                    $querytambah = mysqli_query($koneksi,$sql);
                    if($querytambah) { 
                        $sql = "select materi from detailtraining where id_training = '$id_training'";
                        $datamateri=mysqli_query($koneksi, $sql);
                        while($datam=mysqli_fetch_array($datamateri)){ 
                            $materi = $datam['materi'];
                            $sql = "select count(*) as jumlah from matericalon where materi = $materi and nip = '$nip'";
                            $cekmateri=mysqli_query($koneksi, $sql);
                            $hasilcekmateri=mysqli_fetch_array($cekmateri);
                            if($hasilcekmateri['jumlah'] == 0){
                                $sql = "insert into matericalon (nip,materi)
                                values('$nip',$materi)";
                                $querytambahmateri = mysqli_query($koneksi,$sql);
                            }
                        } ?>

                        <script language="javascript">
                            document.location = '../link4dm1n/formabsensi.php?notif=4&testing='+<?php echo $id_training; ?>;
                        </script>
                    <?php }else{ ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/formabsensi.php?notif=2&testing='+<?php echo $id_training; ?>;
                        </script>
                    <?php
                    }
                }else{ 
                    $sql = "update absen set pulang='$tanggalpel'
                        where id_training = $id_training and nip = '$nip' and DATE_FORMAT(hadir, '%Y-%m-%d')= DATE_FORMAT('$tanggalpel', '%Y-%m-%d')";
                    $querytambah = mysqli_query($koneksi,$sql);
                    if($querytambah) { ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/formabsensi.php?notif=2&testing='+<?php echo $id_training; ?>;
                        </script>
                    <?php }else{ ?>
                        <script language="javascript">
                            document.location = '../link4dm1n/formabsensi.php?notif=3&testing='+<?php echo $id_training; ?>;
                        </script>
                    <?php
                    }
                }
            }

            if($fungsi == 'tambahabsentraining'){
                $nip   = $_POST['nip'];
                $id_training   = $_POST['id_training'];
                $sql = "
                select * from training
                where id = $id_training";
                $cek=mysqli_query($koneksi, $sql);
                $datatra=mysqli_fetch_array($cek);
                if($datatra['tgl_pelaksanaan'] == date('Y-m-d')){
                    $sql = "
                    select count(*) as jumlah from absen tbl1
                    inner join training tbl2 on tbl2.id = tbl1.id_training 
                    where id_training = $id_training and nip = '$nip' and tbl2.tgl_pelaksanaan = DATE_FORMAT(tbl1.hadir, '%Y-%m-%d')";
                    $cek=mysqli_query($koneksi, $sql);
                    $dataabsen=mysqli_fetch_array($cek);
                    if($dataabsen['jumlah'] == 0){
                        $sql = "insert into absen (nip,id_training,hadir)
                        values('$nip',$id_training,now())";
                        $querytambah = mysqli_query($koneksi,$sql);
                        if($querytambah) { 
                            $sql = "select materi from detailtraining where id_training = '$id_training'";
                            $datamateri=mysqli_query($koneksi, $sql);
                            while($datam=mysqli_fetch_array($datamateri)){ 
                                $materi = $datam['materi'];
                                $sql = "select count(*) as jumlah from matericalon where materi = $materi and nip = '$nip'";
                                $cekmateri=mysqli_query($koneksi, $sql);
                                $hasilcekmateri=mysqli_fetch_array($cekmateri);
                                if($hasilcekmateri['jumlah'] == 0){
                                    $sql = "insert into matericalon (nip,materi)
                                    values('$nip',$materi)";
                                    $querytambahmateri = mysqli_query($koneksi,$sql);
                                }
                            } ?>

                            <script language="javascript">
                                document.location = '../link4dm1n/formabsensitraining.php?notif=4&training='+<?php echo $id_training; ?>;
                            </script>
                        <?php }else{ ?>
                            <script language="javascript">
                                document.location = '../link4dm1n/formabsensitraining.php?notif=2&training='+<?php echo $id_training; ?>;
                            </script>
                        <?php
                        }
                    }else{ 
                        $sql = "update absen set pulang=now()
                            where id_training = $id_training and nip = '$nip' and DATE_FORMAT(hadir, '%Y-%m-%d')= DATE_FORMAT(now(), '%Y-%m-%d')";
                        $querytambah = mysqli_query($koneksi,$sql);
                        if($querytambah) { ?>
                            <script language="javascript">
                                document.location = '../link4dm1n/formabsensitraining.php?notif=2&training='+<?php echo $id_training; ?>;
                            </script>
                        <?php }else{ ?>
                            <script language="javascript">
                                document.location = '../link4dm1n/formabsensitraining.php?notif=3&training='+<?php echo $id_training; ?>;
                            </script>
                        <?php
                        }
                    }
                }else{ ?>
                    <script language="javascript">
                        document.location = '../link4dm1n/formabsensitraining.php?notif=3&training='+<?php echo $id_training; ?>;
                    </script>
                <?php
                } 
            }

            if($fungsi == 'ttdkontrak'){
                $id_lamaran   = $_POST['id_lamaran'];
                $sql = "update lamaran set ttdkontrak=1 where id = $id_lamaran";
                $ttdkontrak = mysqli_query($koneksi,$sql);
                return $ttdkontrak;
            }

            if($fungsi == 'tarikberkas'){
                $id_lowongan   = $_POST['id_lowongan'];
                $nip   = $_POST['nip'];
                $sql = "update lamaran set tarikberkas=1 where id_lowongan = $id_lowongan and nip = '$nip'";
                $tarikberkas = mysqli_query($koneksi,$sql);
                return $tarikberkas;
            }

            if($fungsi == 'tarikberkashc'){
                $id   = $_POST['id'];
                $sql = "update lamaran set tarikberkas=2 where id = $id";
                $tarikberkas = mysqli_query($koneksi,$sql);
                return $tarikberkas;
            }

            if($fungsi == 'kembalikanberkashc'){
                $id   = $_POST['id'];
                $sql = "update lamaran set tarikberkas=null where id = $id";
                $kembaliberkas = mysqli_query($koneksi,$sql);
                return $kembaliberkas;
            }

            if($fungsi == 'sudahttdkontrak'){
                $id_lamaran   = $_POST['id_lamaran'];
                $nip  = $_POST['nip'];
                $sql = "update lamaran set hasilakhir=1 where id = $id_lamaran";
                echo $sql;
                $ttdkontrak = mysqli_query($koneksi,$sql);
                $sql = "update user set karyawan=1 where id = '$nip'";
                $karyawan = mysqli_query($koneksi,$sql);
                return $karyawan;
            }

            if($fungsi == 'batalkontrak'){
                $id_lamaran   = $_POST['id_lamaran'];
                $nip  = $_POST['nip'];
                $sql = "update lamaran set hasilakhir=null where id = $id_lamaran";
                echo $sql;
                $batalkontrak = mysqli_query($koneksi,$sql);
                $sql = "update user set karyawan=0 where id = '$nip'";
                $karyawan = mysqli_query($koneksi,$sql);
                return $karyawan;
            }

            if($fungsi == 'materitraining'){
                $sql = "select * from materitraining where status=1 and kategori=2";
                $datamateri=mysqli_query($koneksi, $sql);
                    ?><option value="">Pilih/select</option><?php
                    while($data=mysqli_fetch_array($datamateri)){ ?>
                        <option value="<?php echo $data['id'] ?>"><?php echo $data['nama'] ?></option>
            <?php   }
            }

            if($fungsi == 'materitesting'){
                $sql = "select * from materitraining where status=1 and kategori=1";
                $datamateri=mysqli_query($koneksi, $sql);
                    ?><option value="">Pilih/select</option><?php
                    while($data=mysqli_fetch_array($datamateri)){ ?>
                        <option value="<?php echo $data['id'] ?>"><?php echo $data['nama'] ?></option>
            <?php   }
            }

            if($fungsi == 'updatematercalon'){
                $datanya = explode('-', $_POST['datanya']);
                $nip = $datanya[0];
                $materi = $datanya[1];
                $printah = $_POST['printah'];
                if($printah == '1'){
                    $sql = "insert into matericalon (nip,materi) values('$nip','$materi')";
                }else if($printah == '0'){
                    $sql = "delete from matericalon where nip='$nip' and materi = '$materi'";
                }else{
                    return false;
                }
                $hasil = mysqli_query($koneksi, $sql);
                return $hasil;
            }

            if($fungsi == 'updatematercalontraining'){
                $nip  = $_POST['nip'];
                $sql = "delete from matericalon where nip = '$nip'";
                $delet=mysqli_query($koneksi, $sql);
                if($delet){
                    if(isset($_POST['idmateri'.$nip])) {
                        $materi = $_POST['idmateri'.$nip];
                        foreach ($materi as $key => $value) {
                            $sql = "insert into matericalon (nip,materi) values('$nip',$value)";
                            mysqli_query($koneksi, $sql);
                        }
                    }
                    ?><script language="javascript">
                        document.location = '../link4dm1n/reporttraining.php?notif=4';
                    </script><?php
                }else{
                    ?><script language="javascript">
                        document.location = '../link4dm1n/reporttraining.php?notif=2';
                    </script><?php
                }
            }




            if($fungsi == 'loginadmin'){
                $email  = anti_injection($koneksi,$_POST['email']);
                $pass   = anti_injection($koneksi,$_POST['pass']);

                $sql = "select * from admin where email = '$email' and pass = '$pass' and level = 'Administrator'" ;
                $queryceklogin = mysqli_query($koneksi,$sql);
                $banyakrecord=mysqli_num_rows($queryceklogin);
            
                if($banyakrecord > 0){
                  $datauser=mysqli_fetch_array($queryceklogin);
                  $_SESSION['nama'] = $datauser['nama_depan'].' '.$datauser['nama_belakang'];
                  $_SESSION['status'] = true;
                  $_SESSION['verifikasi'] = $datauser['verifikasi'];
                  $_SESSION['email'] = $datauser['email'];
                  $_SESSION['nip'] = $datauser['id'];
                  $_SESSION['level'] = $datauser['level'];
                  $_SESSION['LAST_ACTIVITY'] = time();
                  ?>
                    <script language="javascript">
                        document.location = '../link4dm1n/home.php';
                    </script>
                  <?php
                }else{
                   ?>
                    <script language="javascript">
                        alert(<?php echo json_encode($info4); ?>);
                        document.location = '../link4dm1n';
                    </script>
                  <?php
                }
            }

            





            if($fungsi == 'editjenistraining'){
                $id_jenis   = $_POST['id_jenis'];
                $sql = "update jenis_training set status=0 where id = $id_jenis";
                $update = mysqli_query($koneksi,$sql);
                return $update;
            }

            if ($fungsi == 'simpaneditalljenistraining') {
                $id_jenis   = $_POST['id_jenis'];
                $jenis  = $_POST['jenis'];
                $kategori  = $_POST['kategori'];
                $penginput  = $_SESSION['nip'];
                $sql = "update jenis_training set nama='$jenis',kategori='$kategori',penginput='$penginput' where id = $id_jenis";
                $update = mysqli_query($koneksi,$sql);
                if($update){
                    ?><script language="javascript">
                        document.location = '../link4dm1n/jenis_training.php?notif=4';
                    </script><?php
                }else{
                    ?><script language="javascript">
                        document.location = '../link4dm1n/jenis_training.php?notif=3';
                    </script><?php
                }
            }

            if($fungsi == 'formeditjenistraning'){
                $id  = $_POST['id'];
                $sql = "select * from jenis_training where id = '$id'";
                $query = mysqli_query($koneksi,$sql);
                $data=mysqli_fetch_array($query);
                if ($data['kategori']==1) {
                    $kategori = '<option value="1" selected>Testing</option><option value="2">Traning</option>';
                }else if($data['kategori']==2){
                    $kategori = '<option value="1">Testing</option><option value="2" selected>Traning</option>';
                }
                echo '
                    <input type="hidden" name="id_jenis" value="'.$data['id'].'">
                    <div class="row clearfix">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Masukan Nama Jenis</label>
                                <div class="form-line">
                                    <input type="text" name="jenis" class="form-control" required="" placeholder="Nama Jenis" value="'.$data['nama'].'">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kategori</label>
                                <div class="form-line">
                                    <select name="kategori" class="form-control" required="" placeholder="Nama Jenis">
                                        <option value="">Pilih/select</option>
                                        '.$kategori.'
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }

            if($fungsi == 'formpesan'){
                $id  = $_POST['id']; 
                echo '
                    <input type="hidden" name="nip" value="'.$id.'">
                    <div class="form-group">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Subject</label>
                                <div class="form-line">
                                    <input type="text" name="subject" class="form-control" required="" placeholder="Subject">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Isi Pesan</label>
                                <div class="form-line">
                                    <textarea rows="3" name="isipesan" class="form-control" placeholder="Isi Pesan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        CKEDITOR.replace( "isipesan" );             
                    </script>
                ';
            }

            if($fungsi == 'historipesan'){
                $nip  = $_POST['nip'];
                $lowongan= $_POST['lowongan'];
                $sql = "select * from pesanpribadi where nip = '$nip' and lowongan='$lowongan' order by id desc";
                $query = mysqli_query($koneksi,$sql);
                $banyakrecord=mysqli_num_rows($query);
                if($banyakrecord == 0){
                    $pesan = 'blm ada pesan di kirim';
                }else{
                    $pesan = '';
                }
                while($data=mysqli_fetch_array($query)){
                    if ($data['status'] == 0) {
                        $status = '<b style="color:red">Blm di Baca</b>';
                    }else{
                        $status = '<b style="color:green">Sudah di Baca</b>';
                    }
                    $pesan .='<b>Subject :</b> '.$data['subject'].'<br><b>Status Baca : </b>'.$status.'<br>'.$data['isi'].'<hr>' ;
                }
                echo $pesan;
            }

            if($fungsi == 'historiundangan'){
                $id  = $_POST['id'];
                $sql = "
                select subject,isi,tbl2.nama,tgl_pelaksanaan from pesan tbl1
                inner join jenis_training tbl2 on tbl2.id = tbl1.jenis_training
                where tbl1.id = '$id'";
                $query = mysqli_query($koneksi,$sql);
                while($data=mysqli_fetch_array($query)){
                    $pesan ='<b>Subject :</b> '.$data['subject'].'<br><b>Jenis training : </b>'.$data['nama'].'<br><b>Tgl pelaksanaan : </b>'.$data['tgl_pelaksanaan'].'<hr>'.$data['isi'].'<hr>' ;
                }
                echo $pesan;
            }

            if ($fungsi == 'simpanpesanpribadi') {
                $nip  = $_POST['nip'];
                $isi  = $_POST['isipesan'];
                $subject = $_POST['subject'];
                $lowongan = $_POST['lowongan'];
                $pengirim  = $_SESSION['nip'];
                $sql = "insert into pesanpribadi (nip,subject,pengirim,tgl_pesan,isi,lowongan)
                values('$nip','$subject','$pengirim',now(),'$isi','$lowongan')";
                $querytambah = mysqli_query($koneksi,$sql); 
                // return $querytambah;
                $sql_no= "SELECT no_whatsapp from user where id='$nip'";
                $queryselect = mysqli_query($koneksi,$sql_no);
                $que = list($no_whatsapp)=mysqli_fetch_array($queryselect); 
                // if ($querytambah) {
                    $message = "Anda mendapatkan pesan baru dari Rabbani Karir. Silahkan cek akun Rabbani Karir Anda.";  
                    $data_whatsapp = new stdClass();
                    $data_whatsapp->token = "M00zwEyiemojKR9ilsECaE81QUjpdfNP5Bdp";
                    $data_whatsapp->phone = $no_whatsapp;
                    $data_whatsapp->msg = $message;
            
                    $dataJSON = json_encode($data_whatsapp);
            
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://103.14.21.57/back_end/microservices/wha/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('data' =>$dataJSON),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl); 
                // }
            }

            if ($fungsi == 'ubahstatuspp') {
                $id  = $_POST['id'];
                $sql = "update pesanpribadi set status=1 where id = $id";
                $query = mysqli_query($koneksi,$sql);
                return $query;
            }
            if ($fungsi == 'ubahstatuslamaran') {
                
                $data = explode("-" , $_POST['nip']);
                $nip  = $data[0];
                $id_lowongan=$data[1];

                $st  = $_POST['status'];

                $sql = "update lamaran set status='$st' where nip='$nip' and id_lowongan = $id_lowongan";
                $query = mysqli_query($koneksi,$sql);
                return $query;
            }

            if($fungsi == 'datatambahjenistraining'){
                $jenis  = $_POST['jenis'];
                $kategori  = $_POST['kategori'];
                $penginput  = $_SESSION['nip'];
                $sql = "insert into jenis_training (nama,penginput,kategori)
                values('$jenis','$penginput','$kategori')";
                $querytambah = mysqli_query($koneksi,$sql);
                if($querytambah){
                    ?><script language="javascript">
                        document.location = '../link4dm1n/jenis_training.php?notif=2';
                    </script><?php
                }else{
                    ?><script language="javascript">
                        document.location = '../link4dm1n/jenis_training.php?notif=3';
                    </script><?php
                }
            }

            if($fungsi == 'datatambahmateritraining'){
                $materi  = $_POST['materi'];
                $penginput  = $_SESSION['nip'];
                $kategori  = $_POST['kategori'];
                $sql = "insert into materitraining (nama,penginput,kategori)
                values('$materi','$penginput','$kategori')";
                $querytambah = mysqli_query($koneksi,$sql);
                if($querytambah){
                    ?><script language="javascript">
                        document.location = '../link4dm1n/materi_training.php?notif=2';
                    </script><?php
                }else{
                    ?><script language="javascript">
                        document.location = '../link4dm1n/materi_training.php?notif=3';
                    </script><?php
                }
            }

            if($fungsi == 'editmateritraining'){
                $id_materi   = $_POST['id_materi'];
                $sql = "update materitraining set status=0 where id = $id_materi";
                $update = mysqli_query($koneksi,$sql);
                return $update;
            }

            if ($fungsi == 'simpaneditallmateritraining') {
                $id_materi   = $_POST['id_materi'];
                $materi  = $_POST['materi'];
                $kategori  = $_POST['kategori'];
                $penginput  = $_SESSION['nip'];
                $sql = "update materitraining set nama='$materi',kategori='$kategori',penginput='$penginput' where id = $id_materi";
                $update = mysqli_query($koneksi,$sql);
                if($update){
                    ?><script language="javascript">
                        document.location = '../link4dm1n/materi_training.php?notif=4';
                    </script><?php
                }else{
                    ?><script language="javascript">
                        document.location = '../link4dm1n/materi_training.php?notif=3';
                    </script><?php
                }
            }

            if($fungsi == 'formeditmateritraining'){
                $id  = $_POST['id'];
                $sql = "select * from materitraining where id = '$id'";
                $query = mysqli_query($koneksi,$sql);
                $data=mysqli_fetch_array($query);
                if ($data['kategori']==1) {
                    $kategori = '<option value="1" selected>Testing</option><option value="2">Traning</option>';
                }else if($data['kategori']==2){
                    $kategori = '<option value="1">Testing</option><option value="2" selected>Traning</option>';
                }
                echo '
                    <input type="hidden" name="id_materi" value="'.$data['id'].'">
                    <div class="row clearfix">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Masukan Nama Materi</label>
                                <div class="form-line">
                                    <input type="text" name="materi" class="form-control" required="" placeholder="Nama Jenis" value="'.$data['nama'].'">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kategori</label>
                                <div class="form-line">
                                    <select name="kategori" class="form-control" required="" placeholder="Nama Jenis">
                                        <option value="">Pilih/select</option>
                                        '.$kategori.'
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }

            if ($fungsi == 'lupapass') {
                $email  = $_POST['email'];
                
                $sql = "select * from user where email = '$email'";
                $cekpass = mysqli_query($koneksi,$sql);
                $data=mysqli_fetch_array($cekpass);
                if($data['pass'] != '') {

                    $subject = "Lupa Password RABBANI KARIR";    
                    $message = "<center><h2>Hallo ".$data['nama_depan']." ".$data['nama_belakang']." ,Password anda </h2><br><h1>".$data['pass']."</h1></center>";   

                   
                    try{
                        $soap = new nusoap_client('https://103.14.21.44/back_end/karir.co.id/kirim_email_ws.php?wsdl', true);
                        $err = $soap->getError();

                        if ($err) {
                            echo 'Constructor error' . $err;
                        }
                        $proxy = $soap->getProxy();  
                        print_r($proxy);
                        $hasil = $proxy->sendLinkAuth('myuser','5793475kdhkdhfg0983rtrtu3o45',$email,$message,$subject);
                        echo "$hasil";
                    }catch(Exception $e){
                    $hasil=$e->getMessage();
                         echo 'Caught exception: ',  $e->getMessage(), "\n";
                    }   

                    $pecah_hasil=explode("#",$hasil);
                    $sukses=$pecah_hasil[0];

                    if(trim($sukses=='Ok'))
                    { ?>
                      <script language="javascript">
                          alert(<?php echo json_encode($info1); ?>);
                          window.close();
                      </script>
                    <?php }else{ ?>
                      <script language="javascript">
                        alert(<?php echo json_encode($info2); ?>);
                        document.location = '../lupapassword.php';
                      </script>
                    <?php } 
                }else{
                    ?>
                    <script language="javascript">
                        alert(<?php echo json_encode($info3); ?>);
                        document.location = '../lupapassword.php';
                    </script>
                    <?php
                }
            }

           
            if($fungsi == "hapusbanner" ){
                $id = $_POST['id_banner'];
                $hapus = mysqli_query($koneksi, "delete from banner WHERE id=$id");
                if($hapus){
                    unlink("../".$_POST['fotolama']);
                }
                echo $hapus;
            }

            if($fungsi == 'updatenilai'){
                $nipkar = $_POST['nipkar'];
                $id     = $_POST['id'];
                $nilai  = $_POST['nilai'];
                $filesCount = count($_POST['id']);
                for($i = 0; $i < $filesCount; $i++){
                    if(!empty($nilai[$i])){
                        $nilainya = $nilai[$i];
                    }else{
                        $nilainya = null;
                    }
                    $sql    = "update matericalon set nilai='$nilainya' where id = $id[$i]";
                    $update = mysqli_query($koneksi,$sql);
                }
                ?>
                    <script language="javascript">
                        document.location = "../link4dm1n/nilai.php?nip="+ <?php echo '"'.$nipkar.'"'; ?> +"&notif=1";
                    </script>
                <?php
            }

            if($fungsi == 'updatenilaitraining'){
                $nipkar = $_POST['nipkar'];
                $id     = $_POST['id'];
                $nilai  = $_POST['nilai'];
                $filesCount = count($_POST['id']);
                for($i = 0; $i < $filesCount; $i++){
                    if(!empty($nilai[$i])){
                        $nilainya = $nilai[$i];
                    }else{
                        $nilainya = null;
                    }
                    $sql    = "update matericalon set nilai='$nilainya' where id = $id[$i]";
                    $update = mysqli_query($koneksi,$sql);
                }
                ?>
                    <script language="javascript">
                        document.location = "../link4dm1n/nilaitraining.php?nip="+ <?php echo '"'.$nipkar.'"'; ?> +"&notif=1";
                    </script>
                <?php
            }
        }else{ ?>
            <script type="text/javascript">
                window.history.back();
            </script> 
<?php   }
    } ?>  


           
