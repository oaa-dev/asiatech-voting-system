<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$college_program_id = add_escape_character($obj->college_program_id);
$college_program_name = add_escape_character($obj->college_program_name);
$college_program_description = add_escape_character($obj->college_program_description);

$sql = "UPDATE tbl_College_Program 
SET college_program_name = '$college_program_name', 
college_program_description = '$college_program_description'
WHERE college_program_id = $college_program_id";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("UPDATE COlLEGE PROGRAM INFORMATIONn",$college_program_id, "", "UPDATE","College program information successfully changed<br>New Information<br>College Program Name: $college_program_name<br>College Program Description: $college_program_description",$signedin_person_id);
	// END OF LOGS

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}

?>