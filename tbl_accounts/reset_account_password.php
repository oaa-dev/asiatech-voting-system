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
$password=password_hash(add_escape_character("admin123"),PASSWORD_DEFAULT);
$staff_name = UserPersonName($personId);

$sql = "UPDATE tbl_Account 
SET password = '$password'
WHERE person_id = $personId";
if(mysqli_query($connection, $sql)){
	echo true;
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("RESET PASSWORD",$personId, "", "RESET","Password successfully reset<br>Name: $staff_name<br>Password: secret123 / $password",$signedin_person_id);
	// END OF LOGS

}else{
	echo false;
}
?>