<script language="javascript">
	document.location = '../';
</script>
<?php
	ini_set('display_errors',1);   
    error_reporting(E_ALL); 
    date_default_timezone_set('Etc/UTC');
    include "../assets/PHPMailer/classes/class.phpmailer.php";
	include("connect.php"); 
	$sql = "select email,id,no_whatsapp from user 
	where tgldaftar > '2018-05-30' and verifikasi=0 limit 40,20";

    $datauser=mysqli_query($koneksi, $sql);

    $no=0;
    while($data=mysqli_fetch_array($datauser)){
    	$no++;

     	$subject = "Verifikasi email rabbani karir";    
	    $message = "<center><h3>Selamat</h3>Selamat anda sudah terdaftar di rabbani karir<br>Agar anda dapat masuk ke dalam rabbani karir dengan akun anda,Silahkan klik tombol di bawah ini untuk memverifikasi akun anda<br><br><a href='http://karir.rabbani.co.id/new_karir/verifikasi.html?token=".md5($data['id'])."'><button type='button' style='width: 25%'>Verifikasi</button></a><center>"; 
			
				 
			$data_whatsapp = new stdClass();
			$data_whatsapp->token = "M00zwEyiemojKR9ilsECaE81QUjpdfNP5Bdp";
			 $data_whatsapp->phone = $data['no_whatsapp'];
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


		$mail = new PHPMailer; 
	    $mail->IsSMTP();
	    $mail->SMTPSecure = 'ssl'; 
	    $mail->Host = "smtp.gmail.com";
	    $mail->SMTPDebug = 0;
	    $mail->Port = 465;
	    // $mail->Port = 587;
	    $mail->SMTPAuth = true;
	    $mail->Username = "rabbani.karir@gmail.com";
	    $mail->Password = "4Dm1nHc0";
	    $mail->setFrom("rabbani.karir@gmail.com","Rabbani Karir");
	    $mail->Subject = $subject; //subyek email
	    $mail->AddAddress($data['email']);  //tujuan email
	    $mail->MsgHTML($message);

	    if($mail->Send()){
	        echo $no.'. nip ini '.$data['id'].' = berhasil<br>';
	    }else{ 
	        echo $no.'. nip ini '.$data['id'].' = gagal<br>';
	    }
		

    } 

?>