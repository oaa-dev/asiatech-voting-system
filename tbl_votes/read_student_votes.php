<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<!-- <div class="table-responsive"> -->
<table class="table table-hover" style="color: black;">
<thead>
	<tr>
	  <th style="width: 2%">#</th>
	  <th style="width: 15%">Student Details</th>
	  <th style="width: 15%">Voted Candidate</th>
	  <th style="width: 10%">Created At</th>
	</tr>
</thead>

<?php 

$obj = json_decode($_GET["data"], false);
$voting_program_id = $obj->voting_program_id;
$college_program_id = $obj->college_program_id;
$filter = $obj->filter;
$start = $obj->start;
$end = $obj->end;

echo Voting_Program_Details($voting_program_id);

$filterCounter = 0;
// GROUP BY tbl_Vote.vote_added_by
$queryVotes = "SELECT * FROM tbl_Vote INNER JOIN tbl_Person
ON tbl_Vote.vote_added_by = tbl_Person.person_id
INNER JOIN tbl_Person_Program
ON tbl_Person.person_id = tbl_Person_Program.person_id
WHERE tbl_Person.last_name LIKE \"%$filter%\" OR 
tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR 
tbl_Person.affiliation_name LIKE \"%$filter%\"
ORDER BY tbl_Vote.vote_created_at DESC";
$Votes = mysqli_query($connection, $queryVotes);
while ($Vote = mysqli_fetch_array($Votes)) {
	if($Vote['voting_program_id'] == $voting_program_id &&
		$Vote['college_program_id'] == $college_program_id){
		$filterCounter++;
		if($filterCounter>=$start && $filterCounter<=$end){

			$candidate_name="";
			$queryCandidates = "SELECT * FROM tbl_Person_Candidate_Party_List
			INNER JOIN tbl_Person_Program
			ON tbl_Person_Candidate_Party_List.person_program_id = tbl_Person_Program.person_program_id
			INNER JOIN tbl_Person 
			ON tbl_Person_Program.person_id = tbl_Person.person_id";
			$Candidates = mysqli_query($connection, $queryCandidates);
			while ($Candidate = mysqli_fetch_array($Candidates)) {
				if($Candidate['person_candidate_party_list_id']==$Vote['person_candidate_party_list_id']){
					$candidate_name = "{$Candidate['last_name']} {$Candidate['affiliation_name']}, {$Candidate['first_name']} {$Candidate['middle_name']}";
					break;
				}
			}
// {$Vote['last_name']} {$Vote['affiliation_name']}, {$Vote['first_name']} {$Vote['middle_name']}
echo "<tr>
	<td>{$filterCounter}</td>

	<td>********************</td>
	<td>$candidate_name</td>
	<td>{$Vote['vote_created_at']}</td>
</tr>";
		}

	}

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
<!-- </div> -->