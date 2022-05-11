<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<!-- <div class="table-responsive">
<table class="table table-hover" style="color: black;">
<thead>
	<tr>
	  <th style="width: 5%">#</th>
	  <th style="width: 25%">Voting Program Details</th>
	  <th style="width: 25%">Party List</th>
	  <th style="width: 25%">Voting Time</th>
	  <th style="width: 15%">Voting Status</th>
	  <th style="width: 5%">Action</th>
	</tr>
</thead> -->
<?php 

$filterCounter = 0;
$query = "SELECT * FROM tbl_Voting_Program
ORDER BY voting_program_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$filterCounter++;
	$statusColor = statusColor($User['voting_program_status']);
	$statusColorVoting = statusColor($User['voting_status']);

	date_default_timezone_set("Asia/Manila");
	$Date = date("Y-m-d");
	$Time = date("h:i:sa");

	$check_date=false;
	if($Date >= $User['voting_program_starting_date'] &&
		$Date <= $User['voting_program_starting_date']){
		$check_date=true;
	}

	$dateFrom = GetMonthDescription($User['voting_program_starting_date']);
	$dateTo = GetMonthDescription($User['voting_program_ending_date']);
		// $Date >= {$User['voting_program_starting_date']}<br>
		// $Date <= {$User['voting_program_ending_date']}<br>
		// $check_date

	$checkMyVotes=false;
	$queryCheckMyVotes = "SELECT * FROM tbl_Vote";
	$CheckMyVotes = mysqli_query($connection, $queryCheckMyVotes);
	while ($CheckMyVote = mysqli_fetch_array($CheckMyVotes)) {
		if($CheckMyVote['vote_added_by'] == $signedin_person_id &&
			$CheckMyVote['voting_program_id'] == $User['voting_program_id']){
			$checkMyVotes=true;
			break;
		}
	}

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
	<br>";
	if($checkMyVotes){
		echo "<button class='btn alert-warning btn-medium' disabled><i class='ik ik-info'></i> Vote was already taken !</button>";
	}else{
		if($check_date){		
			echo "<button class='btn alert-success btn-medium' onclick='View_Voting_Balot({$User['voting_program_id']})'><i class='ik ik-info'></i> Vote Now !</button>";
		}else{
			echo "<button class='btn alert-success btn-medium' disabled><i class='ik ik-info'></i> Vote Now !</button>";
		}
	}
	echo "</div>
</div>
</div></div>";
}//end of while
	if($filterCounter == 0){
		echo "<div class='alert alert-success'>
				<i class='ik ik-warning'></i> No Records Found !.
			</div>";
	}
?>