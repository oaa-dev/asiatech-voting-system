<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>

<!-- <button class="btn alert-success" title='Print' onclick="printThis('print_vote_statistics')"><i class="fa fa-print"></i> Print</button>
<div id="print_vote_statistics"> -->
<?php 

$voting_program_id=0;
$check_status=false;
$queryVotingProgram = "SELECT * FROM tbl_Voting_Program
INNER JOIN tbl_Voting_Program_Has_Party_List
ON tbl_Voting_Program.voting_program_id=tbl_Voting_Program_Has_Party_List.voting_program_id
INNER JOIN tbl_Party_List
ON tbl_Voting_Program_Has_Party_List.party_list_id=tbl_Party_List.party_list_id
WHERE tbl_Voting_Program.voting_status = \"Opened\"";
$VotingPrograms = mysqli_query($connection, $queryVotingProgram);
while ($VotingProgram = mysqli_fetch_array($VotingPrograms)) {
	$check_status=true;
	$voting_program_id=$VotingProgram['voting_program_id'];
	echo "	<h5><b>{$VotingProgram['voting_program_name']}</b></h5>	
			<h6><b>{$VotingProgram['voting_program_description']}</b><br>
				Voting Date & Time: 
				{$VotingProgram['voting_program_starting_date']} @ 
				{$VotingProgram['voting_program_starting_time']} TO 
				{$VotingProgram['voting_program_ending_date']} @ 
				{$VotingProgram['voting_program_ending_time']}
			</h6>";
	break;
}

if(!$check_status){
	echo "<div class='row'>
		<div class='col-12'>
			<div class='alert alert-success'><h6><b><i class='ik ik-alert-triangle'></i> Note:</b> No voting line is open either your college / department has no candidate for any position or no voting program is open.</h6></div>
		</div>
	</div>";
}else{

$queryCollegeProgram = "SELECT * FROM tbl_College_Program";
$CollegePrograms = mysqli_query($connection, $queryCollegeProgram);
while ($CollegeProgram = mysqli_fetch_array($CollegePrograms)) {


	echo "<div class='alert alert-success' style='text-align:center;font-weight:bold; color:black;'>
		<h5><b>{$CollegeProgram['college_program_description']} ({$CollegeProgram['college_program_name']})</b></h5>
	</div>";
$filterCounter = 0;
$queryCandidatePosition = "SELECT * FROM tbl_Candidate_Position";
$CandidatePositions = mysqli_query($connection, $queryCandidatePosition);
while ($CandidatePosition = mysqli_fetch_array($CandidatePositions)) {
	
	$arrayLetter = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
	$counter=-1;
	echo "<div class='row' style='text-align:center;font-weight:bold; color:black;'><div class='col-lg-12'><h5><b>{$CandidatePosition['candidate_position_name']}</b></h5></div></div>";

	echo "<div class='row' style='color: black;text-align: center;width:100%;font-size:15px;'>";
	$queryPartyList = "SELECT * FROM tbl_Voting_Program_Has_Party_List
	INNER JOIN tbl_Party_List
	ON tbl_Voting_Program_Has_Party_List.party_list_id = tbl_Party_List.party_list_id
	WHERE tbl_Voting_Program_Has_Party_List.voting_program_id=$voting_program_id
	AND tbl_Party_List.college_program_id={$CollegeProgram['college_program_id']}";
	$PartyLists = mysqli_query($connection, $queryPartyList);
	while ($PartyList = mysqli_fetch_array($PartyLists)) {

		$counter++;
		$candidateLabel = $arrayLetter[$counter];
		$filterCounter++;
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
		
		$label="Vote";
		if($VoteCount>1) $label="Votes";
		echo "<div class='col-lg-4'>
			<div class='card-body'>
				$VoteCount $label<br>
				<i>CANDIDATE $candidateLabel</i><br>
			</div>
		</div>";
	}
	echo "</div>";
	echo "<div class='row'>
		<div class='col-lg-12'><br></div>
	</div>";
}	
	echo "<div class='col-12'><br></div>";
}
}//end of else

?>
<!-- </div> -->