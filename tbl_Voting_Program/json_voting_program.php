<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include('../QR/libs/phpqrcode/qrlib.php');  ?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_Voting_Program";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$code=$User['voting_program_code'];
	QRcode::png($code, "../temp/voting_program_code/".''.$code.'.png', QR_ECLEVEL_L, 5);
	$qrCodeImage = '<img src="temp/voting_program_code/'. @$code.'.png" style="width:200px; height:200px;">';

	$jsonArrayItem=array();
	$jsonArrayItem['voting_program_id']="{$User['voting_program_id']}";
	$jsonArrayItem['voting_program_code']="{$User['voting_program_code']}";
	$jsonArrayItem['voting_program_code_image']="$qrCodeImage";
	$jsonArrayItem['voting_program_name']="{$User['voting_program_name']}";	
	$jsonArrayItem['voting_program_description']="{$User['voting_program_description']}";
	$jsonArrayItem['voting_program_starting_date']="{$User['voting_program_starting_date']}";
	$jsonArrayItem['voting_program_starting_time']="{$User['voting_program_starting_time']}";
	$jsonArrayItem['voting_program_ending_date']="{$User['voting_program_ending_date']}";
	$jsonArrayItem['voting_program_ending_time']="{$User['voting_program_ending_time']}";
	$jsonArrayItem['voting_status']="{$User['voting_status']}";	
	$jsonArrayItem['voting_program_created_at']="{$User['voting_program_created_at']}";	
	$jsonArrayItem['voting_program_status']="{$User['voting_program_status']}";	
	$jsonArrayItem['voting_program_added_by']="{$User['voting_program_added_by']}";	
	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');		
	echo json_encode($jsonArray);
?>