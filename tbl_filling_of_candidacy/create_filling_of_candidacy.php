<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$candidate_position_id = add_escape_character($obj->candidate_position_id);
$position_platforms = add_escape_character($obj->position_platforms);

date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");

$filling_of_candidacy_id = 0;
$query = "SELECT * FROM tbl_Filling_Of_Candidacy
ORDER BY filling_of_candidacy_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$filling_of_candidacy_id = $User['filling_of_candidacy_id'];
}
$filling_of_candidacy_id++;

$generated_code = GenerateDisplayId("CANDIDACY", $filling_of_candidacy_id);

$sql = "INSERT INTO tbl_Filling_Of_Candidacy 
VALUES ($filling_of_candidacy_id,'$generated_code',$signedin_person_id,$candidate_position_id, '$position_platforms', '$Date @ $Time', 'Saved', $signedin_person_id)";
if(mysqli_query($connection, $sql)){
	Create_Logs("CREATE FILLING OF CANDIDACY",$filling_of_candidacy_id, $generated_code, "CREATE","New filling of candidacy successfully saved<br>New Information<br>Position Id: $candidate_position_id<br>Platforms: $position_platforms<br>Status: Saved",$signedin_person_id);

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}	

?>