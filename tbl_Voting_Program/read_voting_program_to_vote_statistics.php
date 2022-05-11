<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 

$filterCounter = 0;
$query = "SELECT * FROM tbl_Voting_Program
ORDER BY voting_program_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$filterCounter++;
	$statusColor = statusColor($User['voting_program_status']);
	$statusColorVoting = statusColor($User['voting_status']);

	$dateFrom = GetMonthDescription($User['voting_program_starting_date']);
	$dateTo = GetMonthDescription($User['voting_program_ending_date']);
		// $Date >= {$User['voting_program_starting_date']}<br>
		// $Date <= {$User['voting_program_ending_date']}<br>
		// $check_date
echo "<div class='card'>
<div class='card-body'>
<div class='row'>
	<div class='col-lg-12'>
		<h5>{$User['voting_program_name']}</h5>
		<h6>{$User['voting_program_description']}</h6>
	</div>
</div>
<div class='row'>
	<div class='col-lg-8'>
		<h6>Party List</h6>";
	
	$queryPartyList = "SELECT * FROM tbl_Voting_Program_Has_Party_List
	INNER JOIN tbl_Party_List
	ON tbl_Voting_Program_Has_Party_List.party_list_id = tbl_Party_List.party_list_id";
	$PartyLists = mysqli_query($connection, $queryPartyList);
	while ($PartyList = mysqli_fetch_array($PartyLists)) {
		if($PartyList['voting_program_id']==$User['voting_program_id']){

			echo "<div class='row'>
				<div class='col-lg-7'>
					<p><i class='ik ik-check' style='color:green;'></i> {$PartyList['party_list_name']}</p>
				</div>
				<div class='col-lg-5'>
					<button class='btn alert-success btn-medium' onclick='View_Candidate({$PartyList['party_list_id']})'><i class='ik ik-eye' style='color:green;'></i> View Candidates & Platform</button>
				</div>";
			echo "</div>";//end of row
		}
	}

	echo "</div>
	<div class='col-lg-4'>
		<h6>Voting Date</h6>
		<b>Start</b>: $dateFrom @ {$User['voting_program_starting_time']}<br>
		<b>End:</b> $dateTo @ {$User['voting_program_ending_time']}
	<br>		
		<button class='btn alert-success btn-medium' onclick='View_Vote_Statistics({$User['voting_program_id']})'><i class='ik ik-info'></i> Vote Statistics</button>
	</div>
</div>
</div></div>";
}//end of while
	if($filterCounter == 0){
		echo "<div class='alert alert-success'>
				<i class='ik ik-warning'></i> No Records Found !.
			</div>";
	}
?>