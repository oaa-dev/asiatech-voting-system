<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$change_by = UserPersonName($signedin_person_id);
$obj = json_decode($_GET["data"], false);
$personId = $obj->personId;
$newPassword = $obj->newPassword;

$password=password_hash(add_escape_character($newPassword),PASSWORD_DEFAULT);

$sql = "UPDATE tbl_Account 
SET password = '$password'
WHERE person_id = $personId";
if(mysqli_query($connection, $sql)){
	echo true;
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("CHANGE PASSWORD",$personId, "", "CHANGE","Password successfully changed<br>Password Information<br>Password: $newPassword, Encrypted Password: $password, Changed by: $change_by",$signedin_person_id);
	// END OF LOGS
}else{
	echo false;
}
?>