<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include('../QR/libs/phpqrcode/qrlib.php');  ?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_Party_List";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$code=$User['party_list_code'];
	QRcode::png($code, "../temp/party_list_code/".''.$code.'.png', QR_ECLEVEL_L, 5);
	$qrCodeImage = '<img src="temp/party_list_code/'. @$code.'.png" style="width:200px; height:200px;">';

	$jsonArrayItem=array();
	$jsonArrayItem['party_list_id']="{$User['party_list_id']}";
	$jsonArrayItem['party_list_code']="{$User['party_list_code']}";
	$jsonArrayItem['party_list_code_image']="$qrCodeImage";
	$jsonArrayItem['party_list_name']="{$User['party_list_name']}";	
	$jsonArrayItem['party_list_description']="{$User['party_list_description']}";	
	$jsonArrayItem['party_list_created_at']="{$User['party_list_created_at']}";	
	$jsonArrayItem['party_list_status']="{$User['party_list_status']}";	
	$jsonArrayItem['party_list_added_by']="{$User['party_list_added_by']}";	
	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');		
	echo json_encode($jsonArray);
?>