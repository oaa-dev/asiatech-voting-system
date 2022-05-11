<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$candidate_position_name = add_escape_character($obj->candidate_position_name);
$candidate_position_description = add_escape_character($obj->candidate_position_description);

date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");

$candidate_position_id = 0;
$query = "SELECT * FROM tbl_Candidate_Position
ORDER BY candidate_position_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$candidate_position_id = $User['candidate_position_id'];
}
$candidate_position_id++;

$generated_code = GenerateDisplayId("CANDIDATE-POSITION", $candidate_position_id);

$sql = "INSERT INTO tbl_Candidate_Position 
VALUES ($candidate_position_id,'$generated_code','$candidate_position_name', '$candidate_position_description', '$Date @ $Time', 'Activated', $signedin_person_id)";
if(mysqli_query($connection, $sql)){
	Create_Logs("CREATE CANDIDATE POSITION",$candidate_position_id, $generated_code, "CREATE","New candidate position successfully saved<br>New Information<br>Position Name: $candidate_position_name<br>Position Description: $candidate_position_description<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}	

?>