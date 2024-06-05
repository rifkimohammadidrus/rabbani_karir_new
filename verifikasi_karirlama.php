<script src="assets/jquery.js"></script>
<?php if(empty($_GET['token'])) { ?>
    <script type="text/javascript">
        document.location = 'index.php';
    </script>  
<?php } ?>
<script type="text/javascript">
	var id = <?php echo json_encode($_GET['token']) ?>;
    $.ajax({
        url: 'master/lokasi.php',
        type: 'post',
        data: {
            id : id,
            tanda : 'verifikasi' 
        },
        success: function(data){
            alert('akun anda sudah terverifikasi');
            document.location = 'neindex.php';
        },
        error: function (data) {
            alert('maaf terjadi kesalahan dalam sistem');
            document.location = 'index.php';
        }
    });
</script>