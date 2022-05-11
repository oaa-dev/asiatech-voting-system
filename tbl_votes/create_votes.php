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
$voting_program_id = $obj->voting_program_id;

date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");

$error = "";		
$counter=0;
for($index=0; $index < COUNT($objPartyList); $index++){
	
	$partyListId = $objPartyList[$index];

	$vote_id = 0;
	$queryPartyList = "SELECT * FROM tbl_Vote
	ORDER BY vote_id ASC";
	$PartyLists = mysqli_query($connection, $queryPartyList);
	while ($PartyList = mysqli_fetch_array($PartyLists)) {
		$vote_id = $PartyList['vote_id'];
	}
	$vote_id++;

	$generated_code = GenerateDisplayId("VOTE", $vote_id);
	$sqlVoting = "INSERT INTO tbl_Vote 
	VALUES ($vote_id,'$generated_code',$voting_program_id, $partyListId,'$Date @ $Time', 'Saved', $signedin_person_id)";
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

?>