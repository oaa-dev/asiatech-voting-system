<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include('../QR/libs/phpqrcode/qrlib.php');  ?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Account
ON tbl_Person.person_id = tbl_Account.person_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$code=$User['person_code'];
	QRcode::png("http://192.168.0.111:8080/Voting_System/sign_in_qrcode.php?id=".$code, "../temp/account_code/".''.$code.'.png', QR_ECLEVEL_L, 5);
	// QRcode::png($code, "../temp/account_code/".''.$code.'.png', QR_ECLEVEL_L, 5);
	$qrCodeImage = '<img src="temp/account_code/'. @$code.'.png" style="width:200px; height:200px;">';

	$jsonArrayItem=array();
	$jsonArrayItem['person_id']="{$User['person_id']}";
	$jsonArrayItem['person_code']="{$User['person_code']}";
	$jsonArrayItem['person_code_image']="$qrCodeImage";
	$jsonArrayItem['first_name']=$User['first_name'];
	$jsonArrayItem['middle_name']=$User['middle_name'];	
	$jsonArrayItem['last_name']=$User['last_name'];
	$jsonArrayItem['affiliation_name']=$User['affiliation_name'];
	$jsonArrayItem['date_of_birth']=$User['date_of_birth'];
	$jsonArrayItem['sex']=$User['sex'];
	$jsonArrayItem['civil_status']=$User['civil_status'];	
	$jsonArrayItem['house_no']="{$User['house_no']}";	
	$jsonArrayItem['street']="{$User['street']}";	
	$jsonArrayItem['barangay']=$User['barangay'];	
	$jsonArrayItem['city']=$User['city'];
	$jsonArrayItem['province']=$User['province'];	
	$jsonArrayItem['region']=$User['region'];	
	$jsonArrayItem['email_address']="{$User['email_address']}";	
	$jsonArrayItem['contact_number']="{$User['contact_number']}";	
	$jsonArrayItem['telephone_number']="{$User['telephone_number']}";	
	$jsonArrayItem['user_type_id']="{$User['user_type_id']}";	
	$jsonArrayItem['person_created_at']="{$User['person_created_at']}";	
	$jsonArrayItem['person_status']="{$User['person_status']}";	
	$jsonArrayItem['user_bar_code']="<img alt='{$User['person_code']}' src='generate_barcode.php?Code25&size=40&text={$User['person_code']}'>";	
	

	$jsonArrayItem['accountNumber']="{$User['username']}";	
	$jsonArrayItem['accountPassword']="{$User['password']}";	
	$jsonArrayItem['accountStatus']="{$User['account_status']}";	
	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');		
	echo json_encode($jsonArray);
?>