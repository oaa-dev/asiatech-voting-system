<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$objPartyList = json_decode($_GET["dataobjPartyList"], false);

$obj = json_decode($_GET["data"], false);
$voting_program_name = add_escape_character($obj->voting_program_name);
$voting_program_description = add_escape_character($obj->voting_program_description);
$voting_program_starting_date = add_escape_character($obj->voting_program_starting_date);
$voting_program_starting_time = add_escape_character($obj->voting_program_starting_time);
$voting_program_ending_date = add_escape_character($obj->voting_program_ending_date);
$voting_program_ending_time = add_escape_character($obj->voting_program_ending_time);

date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");

$error = "";

$voting_program_id = 0;
$query = "SELECT * FROM tbl_Voting_Program
ORDER BY voting_program_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$voting_program_id = $User['voting_program_id'];
}
$voting_program_id++;

$generated_code = GenerateDisplayId("VOTING-PROGRAM", $voting_program_id);

$sql = "INSERT INTO tbl_Voting_Program 
VALUES ($voting_program_id,'$generated_code','$voting_program_name', '$voting_program_description','$voting_program_starting_date', '$voting_program_starting_time', '$voting_program_ending_date', '$voting_program_ending_time', 'Closed', '$Date @ $Time', 'Activated', $signedin_person_id)";
if(mysqli_query($connection, $sql)){
	Create_Logs("CREATE VOTING PROGRAM",$voting_program_id, $generated_code, "CREATE","New voting program successfully saved<br>New Information<br>Voting Program Name: $voting_program_name<br>Voting Program Description: $voting_program_description<br>Status: Activated",$signedin_person_id);
		
		$counter=0;
		for($index=0; $index < COUNT($objPartyList); $index++){
			
			$partyListId = $objPartyList[$index];

			$voting_program_has_party_list_id = 0;
			$queryPartyList = "SELECT * FROM tbl_Voting_Program_Has_Party_List
			ORDER BY voting_program_has_party_list_id ASC";
			$PartyLists = mysqli_query($connection, $queryPartyList);
			while ($PartyList = mysqli_fetch_array($PartyLists)) {
				$voting_program_has_party_list_id = $PartyList['voting_program_has_party_list_id'];
			}
			$voting_program_has_party_list_id++;

			$generated_code = GenerateDisplayId("VOTING-PROGRAM-PARTY-LIST", $voting_program_has_party_list_id);
			$sqlVoting = "INSERT INTO tbl_Voting_Program_Has_Party_List 
			VALUES ($voting_program_has_party_list_id,'$generated_code',$voting_program_id, $partyListId,'$Date @ $Time', 'Activated', $signedin_person_id)";
			if(mysqli_query($connection, $sqlVoting)){
				$counter++;
			}else{
				$error.=$connection->error." || ".$sqlVoting."<br>";
			}
		}
		if($counter==COUNT($objPartyList))
			echo true;
		else 
			echo $error;
}else{
	echo "Error: ".$connection->error." || ".$sql."<br>".$error;
}	

?>