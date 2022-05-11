<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<div class="table-responsive">
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
</thead>
<?php 
$obj = json_decode($_GET["data"], false);
$filter = $obj->filter;
$start = $obj->start;
$end = $obj->end;

if($signedin_user_type_id==1){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Voting_Program
WHERE voting_program_name LIKE \"%$filter%\" OR 
voting_program_description LIKE \"%$filter%\"
ORDER BY voting_program_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){
	$statusColor = statusColor($User['voting_program_status']);
	$statusColorVoting = statusColor($User['voting_status']);

	$dateFrom = GetMonthDescription($User['voting_program_starting_date']);
	$dateTo = GetMonthDescription($User['voting_program_ending_date']);
	
echo "<tr>
	<td>{$filterCounter}</td>
	<td><b>{$User['voting_program_name']}</b><br>
		<span style='color:gray'>{$User['voting_program_code']}</span></td>";
	
	echo "<td>";
	$queryPartyList = "SELECT * FROM tbl_Voting_Program_Has_Party_List
	INNER JOIN tbl_Party_List
	ON tbl_Voting_Program_Has_Party_List.party_list_id = tbl_Party_List.party_list_id";
	$PartyLists = mysqli_query($connection, $queryPartyList);
	while ($PartyList = mysqli_fetch_array($PartyLists)) {
		if($PartyList['voting_program_id']==$User['voting_program_id']){
			echo "<i class='ik ik-check' style='color:green;'></i> {$PartyList['party_list_name']}<br>";
		}
	}
	echo "</td>
	<td><b>Start</b>: $dateFrom @ {$User['voting_program_starting_time']}<br>
		<b>End:</b> $dateTo @ {$User['voting_program_ending_time']}
	</td>
	<td>$statusColorVoting</td>
	<td>						
		<button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action <i class='ik ik-chevron-down'></i></button>
	    <div class='dropdown-menu'>
	        <a class='dropdown-item' 
	        	onclick='btnViewInformation({$User['voting_program_id']})' 
				data-toggle='tooltip' title='View Details'
				id='{$User['voting_program_id']}'>
				<i class='ik ik-eye'></i> View Details
	        </a>
	        <a class='dropdown-item'
	        	onclick='btnChangeStatus({$User['voting_program_id']})' 
				data-toggle='tooltip' title='Change Status'
				id='{$User['voting_program_id']}'>
				<i class='ik ik-refresh-cw'></i> Change Status
	        </a>
	    </div>
	</td>
</tr>";
	        // <div role='separator' class='dropdown-divider'></div>
	}//end of pagination
}//end of while
}//end of if
else if($signedin_user_type_id==2){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Voting_Program
WHERE voting_program_name LIKE \"%$filter%\" OR 
voting_program_description LIKE \"%$filter%\"
ORDER BY voting_program_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
if($User['voting_program_added_by']==$signedin_person_id){
	$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){
	$statusColor = statusColor($User['voting_program_status']);
	$statusColorVoting = statusColor($User['voting_status']);

echo "<tr>
	<td>{$filterCounter}</td>
	<td><b>{$User['voting_program_name']}</b><br>
		<span style='color:gray'>{$User['voting_program_code']}</span></td>";
	
	echo "<td>";
	$queryPartyList = "SELECT * FROM tbl_Voting_Program_Has_Party_List
	INNER JOIN tbl_Party_List
	ON tbl_Voting_Program_Has_Party_List.party_list_id = tbl_Party_List.party_list_id";
	$PartyLists = mysqli_query($connection, $queryPartyList);
	while ($PartyList = mysqli_fetch_array($PartyLists)) {
		if($PartyList['voting_program_id']==$User['voting_program_id']){
			echo "<i class='ik ik-check' style='color:green;'></i> {$PartyList['party_list_name']}<br>";
		}
	}
	echo "</td>
	<td><b>Start</b>: {$User['voting_program_starting_date']} @ {$User['voting_program_starting_time']}<br>
		<b>End:</b> {$User['voting_program_ending_date']} @ {$User['voting_program_ending_time']}
	</td>
	<td>$statusColorVoting</td>
	<td>						
		<button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action <i class='ik ik-chevron-down'></i></button>
	    <div class='dropdown-menu'>
	        <a class='dropdown-item' 
	        	onclick='btnViewInformation({$User['voting_program_id']})' 
				data-toggle='tooltip' title='View Details'
				id='{$User['voting_program_id']}'>
				<i class='ik ik-eye'></i> View Details
	        </a>
	        <a class='dropdown-item'
	        	onclick='btnChangeStatus({$User['voting_program_id']})' 
				data-toggle='tooltip' title='Change Status'
				id='{$User['voting_program_id']}'>
				<i class='ik ik-refresh-cw'></i> Change Status
	        </a>
	    </div>
	</td>
</tr>";
	}//end of pagination
}//end of if
}//end of while
}
	if($filterCounter == 0){
		echo "<tr>
			<td colspan='1000' class='alert alert-success'>
				<i class='ik ik-warning'></i> No Records Found !.
			</td>
		</tr>";
	}
?>
</table>
</div>