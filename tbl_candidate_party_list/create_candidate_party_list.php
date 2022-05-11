<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$person_program_id = add_escape_character($obj->person_program_id);
$candidate_position_id = add_escape_character($obj->candidate_position_id);
$party_list_id = add_escape_character($obj->party_list_id);
$person_candidate_party_list_remarks = add_escape_character($obj->person_candidate_party_list_remarks);

$exist = false;
$query = "SELECT * FROM tbl_Person_Candidate_Party_List";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	// $User['person_program_id']==$person_program_id && 
	if($User['candidate_position_id']==$candidate_position_id && 
		$User['party_list_id']==$party_list_id && 
		$User['person_candidate_party_list_status']=="Activated"){
			$exist=true;
		}
}

if(!$exist){
date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");

$person_candidate_party_list_id = 0;
$query = "SELECT * FROM tbl_Person_Candidate_Party_List
ORDER BY person_candidate_party_list_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$person_candidate_party_list_id = $User['person_candidate_party_list_id'];
}
$person_candidate_party_list_id++;

$generated_code = GenerateDisplayId("CANDIDATE-PARTY-LIST", $person_candidate_party_list_id);

$sql = "INSERT INTO tbl_Person_Candidate_Party_List 
VALUES ($person_candidate_party_list_id,'$generated_code',$person_program_id,$candidate_position_id, $party_list_id, '$person_candidate_party_list_remarks', '$Date @ $Time', 'Activated', $signedin_person_id)";
if(mysqli_query($connection, $sql)){

	Create_Logs("CREATE CANDIDATE PARTY LIST",$person_candidate_party_list_id, $generated_code, "CREATE","New candidate on party list successfully saved<br>New Information<br>Party List ID: $party_list_id<br>Person ID: $person_program_id<br>Remarks: $person_candidate_party_list_remarks",$signedin_person_id);

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}	
}
else{
	echo "Existed";
}
?>