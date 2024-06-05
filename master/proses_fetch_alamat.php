<?php 
	
	include 'connect.php';

	$provinsi_id   = $_POST['id'];

    $prov_sql = "SELECT * FROM kabkota WHERE provinsi_id = '$provinsi_id' ORDER BY nama_kabkota";

    $prov_obj = mysqli_query($koneksi, $prov_sql);

    // if($prov_obj){
    	echo "<option>Pilih Kabupaten/Kota</option>";
        while ($row = mysqli_fetch_array($prov_obj)) {
            echo "<option value='".$row['id']."'>".$row['nama_kabkota']."</option>";
        }
    // }

    $koneksi->close();
?>