<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php include('../QR/libs/phpqrcode/qrlib.php');  ?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>

<?php 
$filterCounter = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Account
ON tbl_Person.person_id=tbl_Account.person_id 
WHERE tbl_Person.person_id = $signedin_person_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$statusColor = statusColor($User['account_status']);
	$program_description=Get_Person_Program_Description($User['person_id'], "Activated");

	$code=$User['person_code'];
	// QRcode::png("http://192.168.0.111:8080/Voting_System/sign_in_qrcode.php?id=$code", "../temp/account_code/".''.$code.'.png', QR_ECLEVEL_L, 5);
	QRcode::png("http://192.168.0.111:8080/Voting_System/sign_in_qrcode.php?id=".$code, "../temp/account_code/".''.$code.'.png', QR_ECLEVEL_L, 5);

	$qrCodeImage = '<img src="temp/account_code/'. @$code.'.png" style="width:200px; height:200px;" id="img_qrcode">';
	$qrCodeHref="temp/account_code/". @$code.".png";

	$barCode = "<img alt='testing' src='barcode.php?codetype=Code39&size=170&text=".$code."&print=true'/>";
	$barCodeHref="barcode.php?codetype=Code39&size=170&text=".$code."&print=true";

    echo "<div class='row'>
    	<div class='col-lg-12 text-center'><h5>QR CODE</h5>
    		<a href='$qrCodeHref' download>$qrCodeImage</a><br><b>$code</b> <br>
    		<p><b>Click the QR Code to download</b></p><br>
    		<p>This QR Code will be used to easily sign-in your account. Scan this QR Code and enter your MPIN to sign-in your account.</p>
    	</div>

    </div>";

}//end of while
?>
    	<!-- <div class='col-lg-6 text-center'><h5>BARCODE</h5><br>
    		<a href='$barCodeHref' download>$barCode</a> 
    		<p><b>Click the BarCode to download</b></p><br>
    		<p>This BarCode will be used to easily sign-in your account. Scan this BarCode and enter your MPIN to sign-in your account.</p>
    	</div> -->

<script type="text/javascript">
	// $('#saveQRCode').click(function(){
	// 	var img = document.getElementById("img_qrcode");
	// 	img.src = $("#img_qrcode").attr("src");
	// 	var newData = img.src.replace("image/png", "image/octet-stream");
	// 	$('#saveQRCode').attr("download", "qr_code.png").attr("href", newData);
	// });
</script>