<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$voting_program_id = $obj->voting_program_id;
$college_program_id = $obj->college_program_id;
$filter = $obj->filter;

$counter = 0;
$queryVotes = "SELECT * FROM tbl_Vote INNER JOIN tbl_Person
ON tbl_Vote.vote_added_by = tbl_Person.person_id
INNER JOIN tbl_Person_Program
ON tbl_Person.person_id = tbl_Person_Program.person_id
WHERE tbl_Person.last_name LIKE \"%$filter%\" OR 
tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR 
tbl_Person.affiliation_name LIKE \"%$filter%\"";
$Votes = mysqli_query($connection, $queryVotes);
while ($Vote = mysqli_fetch_array($Votes)) {
	if($Vote['voting_program_id'] == $voting_program_id &&
		$Vote['college_program_id'] == $college_program_id){
		$counter++;
	}
}
echo $counter;
?>