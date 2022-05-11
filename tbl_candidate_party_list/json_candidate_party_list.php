<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include('../QR/libs/phpqrcode/qrlib.php');  ?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_Person_Candidate_Party_List";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$code=$User['person_candidate_party_list_code'];
	QRcode::png($code, "../temp/person_candidate_party_list_code/".''.$code.'.png', QR_ECLEVEL_L, 5);
	$qrCodeImage = '<img src="temp/person_candidate_party_list_code/'. @$code.'.png" style="width:200px; height:200px;">';

	$jsonArrayItem=array();
	$jsonArrayItem['person_candidate_party_list_id']="{$User['person_candidate_party_list_id']}";
	$jsonArrayItem['person_candidate_party_list_code']="{$User['person_candidate_party_list_code']}";
	$jsonArrayItem['person_candidate_party_list_code_image']="$qrCodeImage";
	$jsonArrayItem['person_program_id']="{$User['person_program_id']}";	
	$jsonArrayItem['candidate_position_id']="{$User['candidate_position_id']}";	
	$jsonArrayItem['party_list_id']="{$User['party_list_id']}";	
	$jsonArrayItem['person_candidate_party_list_remarks']="{$User['person_candidate_party_list_remarks']}";	
	$jsonArrayItem['person_candidate_party_list_created_at']="{$User['person_candidate_party_list_created_at']}";
	$jsonArrayItem['person_candidate_party_list_status']="{$User['person_candidate_party_list_status']}";
	$jsonArrayItem['person_candidate_party_list_added_by']="{$User['person_candidate_party_list_added_by']}";
	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');		
	echo json_encode($jsonArray);
?>