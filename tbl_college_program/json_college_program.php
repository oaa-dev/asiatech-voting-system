<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include('../QR/libs/phpqrcode/qrlib.php');  ?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_College_Program
ON tbl_Person.person_id = tbl_College_Program.college_program_added_by";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$code=$User['college_program_code'];
	QRcode::png($code, "../temp/college_program_code/".''.$code.'.png', QR_ECLEVEL_L, 5);
	$qrCodeImage = '<img src="temp/college_program_code/'. @$code.'.png" style="width:200px; height:200px;">';

	$jsonArrayItem=array();
	$jsonArrayItem['first_name']=$User['first_name'];
	$jsonArrayItem['middle_name']=$User['middle_name'];	
	$jsonArrayItem['last_name']=$User['last_name'];
	$jsonArrayItem['affiliation_name']=$User['affiliation_name'];
	
	$jsonArrayItem['college_program_id']="{$User['college_program_id']}";
	$jsonArrayItem['college_program_code']="{$User['college_program_code']}";
	$jsonArrayItem['college_program_code_image']="$qrCodeImage";
	$jsonArrayItem['college_program_name']="{$User['college_program_name']}";	
	$jsonArrayItem['college_program_description']="{$User['college_program_description']}";	
	$jsonArrayItem['college_program_created_at']="{$User['college_program_created_at']}";	
	$jsonArrayItem['college_program_status']="{$User['college_program_status']}";	
	$jsonArrayItem['college_program_added_by']="{$User['college_program_added_by']}";	
	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');		
	echo json_encode($jsonArray);
?>