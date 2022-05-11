<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$personId = $obj->personId;
$mpin = $obj->mpin;
$staff_name = UserPersonName($personId);

$sql = "UPDATE tbl_Account 
SET mpin = '$mpin'
WHERE person_id = $personId";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$mpin,$description,$added_by(person_id)
	Create_Logs("UPDATE ACCOUNT MPIN",$personId, "", "UPDATE","Account mpin successfully changed<br>Name: $staff_name<br>mpin: $mpin",$signedin_person_id);
	// END OF LOGS

	echo true;
}else{
	echo false;
}
?>