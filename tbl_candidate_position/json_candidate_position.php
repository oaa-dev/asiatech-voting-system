<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include('../QR/libs/phpqrcode/qrlib.php');  ?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_Candidate_Position";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$code=$User['candidate_position_code'];
	QRcode::png($code, "../temp/candidate_position_code/".''.$code.'.png', QR_ECLEVEL_L, 5);
	$qrCodeImage = '<img src="temp/candidate_position_code/'. @$code.'.png" style="width:200px; height:200px;">';

	$jsonArrayItem=array();
	$jsonArrayItem['candidate_position_id']="{$User['candidate_position_id']}";
	$jsonArrayItem['candidate_position_code']="{$User['candidate_position_code']}";
	$jsonArrayItem['candidate_position_code_image']="$qrCodeImage";
	$jsonArrayItem['candidate_position_name']="{$User['candidate_position_name']}";	
	$jsonArrayItem['candidate_position_description']="{$User['candidate_position_description']}";	
	$jsonArrayItem['candidate_position_created_at']="{$User['candidate_position_created_at']}";	
	$jsonArrayItem['candidate_position_status']="{$User['candidate_position_status']}";	
	$jsonArrayItem['candidate_position_added_by']="{$User['candidate_position_added_by']}";	
	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');		
	echo json_encode($jsonArray);
?>