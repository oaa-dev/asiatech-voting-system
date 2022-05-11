<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>

<?php 
$user_college_program_id=0;
$queryGetCollegeProgram = "SELECT * FROM tbl_Person_Program";
$CollegePrograms = mysqli_query($connection, $queryGetCollegeProgram);
while ($CollegeProgram = mysqli_fetch_array($CollegePrograms)) {
	if($CollegeProgram['person_id'] == $signedin_person_id &&
		$CollegeProgram['person_program_status'] == "Activated"){
		$user_college_program_id=$CollegeProgram['college_program_id'];
		break;
	}
}

$voting_program_id=0;
$check_status=false;
$queryVotingProgram = "SELECT * FROM tbl_Voting_Program
INNER JOIN tbl_Voting_Program_Has_Party_List
ON tbl_Voting_Program.voting_program_id=tbl_Voting_Program_Has_Party_List.voting_program_id
INNER JOIN tbl_Party_List
ON tbl_Voting_Program_Has_Party_List.party_list_id=tbl_Party_List.party_list_id
WHERE tbl_Voting_Program.voting_status = \"Opened\"
AND tbl_Party_List.college_program_id=$user_college_program_id";
$VotingPrograms = mysqli_query($connection, $queryVotingProgram);
while ($VotingProgram = mysqli_fetch_array($VotingPrograms)) {
	$check_status=true;
	$voting_program_id=$VotingProgram['voting_program_id'];
	echo "<div class='row'>
		<div class='col-lg-12'>
			<h5><b>{$VotingProgram['voting_program_name']}</b></h5>	
			<h6><b>{$VotingProgram['voting_program_description']}</b><br>
				Voting Date & Time: 
				{$VotingProgram['voting_program_starting_date']} @ 
				{$VotingProgram['voting_program_starting_time']} TO 
				{$VotingProgram['voting_program_ending_date']} @ 
				{$VotingProgram['voting_program_ending_time']}
			</h6>	
		</div>
	</div>";
	break;
}

$checkMyVotes=false;
$queryCheckMyVotes = "SELECT * FROM tbl_Vote";
$CheckMyVotes = mysqli_query($connection, $queryCheckMyVotes);
while ($CheckMyVote = mysqli_fetch_array($CheckMyVotes)) {
	if($CheckMyVote['vote_added_by'] == $signedin_person_id &&
		$CheckMyVote['voting_program_id'] == $voting_program_id){
		$checkMyVotes=true;
		break;
	}
}

if($checkMyVotes){
	echo "<div class='row'>
		<div class='col-lg-12'>
			<div class='alert alert-success'><h6><b><i class='ik ik-alert-triangle'></i> Note:</b> Your vote was already taken.</h6>
			</div>
		</div>
	</div>";
}else{

if(!$check_status){
	echo "<div class='row'>
		<div class='col-lg-12'>
			<div class='alert alert-success'><h6><b><i class='ik ik-alert-triangle'></i> Note:</b> No voting line is open either your college / department has no candidate for any position or no voting program is open.</h6></div>
		</div>
	</div>";
}else{


$filterCounter = 0;
$queryCandidatePosition = "SELECT * FROM tbl_Candidate_Position";
$CandidatePositions = mysqli_query($connection, $queryCandidatePosition);
while ($CandidatePosition = mysqli_fetch_array($CandidatePositions)) {
	$filterCounter++;
	echo "<div class='row' style='text-align:center;font-weight:bold; color:black;' width='100%;'><div class='col-lg-12 alert alert-success'><h5><b>{$CandidatePosition['candidate_position_name']}</b></h5></div></div>";


	$voting_program_id=0;
	$queryVotingProgram = "SELECT * FROM tbl_Voting_Program
	WHERE voting_status = \"Opened\"";
	$VotingPrograms = mysqli_query($connection, $queryVotingProgram);
	while ($VotingProgram = mysqli_fetch_array($VotingPrograms)) {
		$voting_program_id=$VotingProgram['voting_program_id'];
		break;
	}

	// echo "<table class='table table-hover' 
	// style='color: black;text-align: center;width:100%;'>";
	// echo "<tr>";
	echo "<div class='row' style='color: black;text-align: center;width:100%;font-size:15px;'>";
	$queryPartyList = "SELECT * FROM tbl_Voting_Program_Has_Party_List
	INNER JOIN tbl_Party_List
	ON tbl_Voting_Program_Has_Party_List.party_list_id = tbl_Party_List.party_list_id
	WHERE tbl_Voting_Program_Has_Party_List.voting_program_id=$voting_program_id
	AND tbl_Party_List.college_program_id=$user_college_program_id
	AND tbl_Party_List.party_list_status=\"Activated\"";
	$PartyLists = mysqli_query($connection, $queryPartyList);
	while ($PartyList = mysqli_fetch_array($PartyLists)) {
		
		$candidate_name="";
		$get_program_description="";
		$action="";
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
				
			$action="<input type=\"radio\" style='font-size:15px;width:10%;height:18px;'
				value=\"{$Candidate['person_candidate_party_list_id']}\"
				class='radioButtonPartyList'
				name='radioButtonPartyList{$Candidate['candidate_position_id']}'>";
			}
		}
		
		echo "<div class='col-lg-4'>
			<div class='card-body'>
				$action<br>
				<b>$candidate_name</b><br>
				<span style='color:gray;'>$get_program_description</span><br>
				<i>{$PartyList['party_list_name']}</i>
			</div>
		</div>";
	}
	echo "</div>";
	echo "<div class='row'>
		<div class='col-lg-12'><br></div>
	</div>";
	// echo "</tr>";
	// echo "</table>";
}

	echo "<div class='row'>
		<div class='col-lg-12' style='text-align:center;'><br>
			<button class='btn alert-success btn-medium' onclick='Verify_Vote($voting_program_id)'><i class='ik ik-save'></i> Submit Vote</button>
		</div>
	</div>";


}//end of else $check_status
}//end of else if $checkMyVotes
?>
