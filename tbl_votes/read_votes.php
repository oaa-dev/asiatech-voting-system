<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>

<button class="btn alert-success" title='Print' onclick="printThis('print_vote')"><i class="fa fa-print"></i> Print</button>
<div id="print_vote">
<?php 

$obj = json_decode($_GET["data"], false);
$voting_program_id = $obj->voting_program_id;
$college_program_id = $obj->college_program_id;

echo Voting_Program_Details($voting_program_id);

$filterCounter = 0;
$queryCandidatePosition = "SELECT * FROM tbl_Candidate_Position";
$CandidatePositions = mysqli_query($connection, $queryCandidatePosition);
while ($CandidatePosition = mysqli_fetch_array($CandidatePositions)) {
	$filterCounter++;
	
	$dataCounter=0;

	echo "<div class='row' style='color: black;text-align: center;width:100%;font-size:15px;'>";
	$queryPartyList = "SELECT * FROM tbl_Voting_Program_Has_Party_List
	INNER JOIN tbl_Party_List
	ON tbl_Voting_Program_Has_Party_List.party_list_id = tbl_Party_List.party_list_id
	WHERE tbl_Voting_Program_Has_Party_List.voting_program_id=$voting_program_id
	AND tbl_Party_List.college_program_id=$college_program_id";
	$PartyLists = mysqli_query($connection, $queryPartyList);
	while ($PartyList = mysqli_fetch_array($PartyLists)) {
		
		$candidate_name="";
		$get_program_description="";
		$VoteCount=0;
		$OtherVote=0;
		$queryCandidates = "SELECT * FROM tbl_Person_Candidate_Party_List
		INNER JOIN tbl_Person_Program
		ON tbl_Person_Candidate_Party_List.person_program_id = tbl_Person_Program.person_program_id
		INNER JOIN tbl_Person 
		ON tbl_Person_Program.person_id = tbl_Person.person_id
		WHERE tbl_Person_Candidate_Party_List.person_candidate_party_list_status = \"Activated\"";
		$Candidates = mysqli_query($connection, $queryCandidates);
		while ($Candidate = mysqli_fetch_array($Candidates)) {
			if($Candidate['party_list_id']==$PartyList['party_list_id'] && 
				$Candidate['candidate_position_id']==$CandidatePosition['candidate_position_id']){

				$dataCounter++;
				$get_program_description = Get_Program_Description($Candidate['college_program_id']);
				$candidate_name = "{$Candidate['last_name']} {$Candidate['affiliation_name']}, {$Candidate['first_name']} {$Candidate['middle_name']}";			

				$queryVotes = "SELECT COUNT(person_candidate_party_list_id) AS VoteCount
				FROM tbl_Vote
				WHERE voting_program_id=$voting_program_id AND person_candidate_party_list_id = {$Candidate['person_candidate_party_list_id']}
				GROUP BY person_candidate_party_list_id";
				$Votes = mysqli_query($connection, $queryVotes);
				while ($Vote = mysqli_fetch_array($Votes)) {
					$VoteCount=$Vote['VoteCount'];
					break;
				}			
			}
		}
		

		if($dataCounter == 1){
			echo "<div class='alert alert-success col-lg-12' style='text-align:center;font-weight:bold; color:black;' width='100%;'><h5><b>{$CandidatePosition['candidate_position_name']}</b></h5></div>";
		}

		if($dataCounter != 0){
			$label="Vote";
			if($VoteCount>1) $label="Votes";

			echo "<div class='col-lg-4'>
				<div class='card-body'>
					$VoteCount $label<br>
					<b>$candidate_name</b><br>
					<span style='color:gray;'>$get_program_description</span><br>
					<i>{$PartyList['party_list_name']}</i>
				</div>
			</div>";
		}
	}
	echo "</div>";
	echo "<div class='row'>
		<div class='col-lg-12'><br></div>
	</div>";
}

?>
</div>