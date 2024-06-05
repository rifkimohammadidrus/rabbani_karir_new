<?php
error_reporting(0);
require_once "../lib/nusoap.php";
// echo "TEST KIRIM EMAIL <br>";
try{
	$soap = new nusoap_client('https://103.14.21.44/back_end/karir.co.id/kirim_email_ws.php?wsdl', true);
	$err = $soap->getError();

	if ($err) {
		echo 'Constructor error' . $err;
	}
	
	$proxy = $soap->getProxy();  
	//print_r($proxy);
	$hasil = $proxy->sendLinkAuth('myuser','5793475kdhkdhfg0983rtrtu3o45','$email','$message');
	echo "$hasil";
}catch(Exception $e){
   # $hasil=$e->getMessage();
	 echo 'Caught exception: ',  $e->getMessage(), "\n";
}	

// echo "ok";
?>