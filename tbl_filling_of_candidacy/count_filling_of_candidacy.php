<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$filter = $obj->filter;

$counter = 0;
$query = "SELECT * FROM tbl_Candidate_Position INNER JOIN tbl_Filling_Of_Candidacy 
ON tbl_Candidate_Position.candidate_position_id = tbl_Filling_Of_Candidacy.candidate_position_id
INNER JOIN tbl_Person
ON tbl_Filling_Of_Candidacy.person_id = tbl_Person.person_id
WHERE tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR 
tbl_Person.last_name LIKE \"%$filter%\" OR 
tbl_Candidate_Position.candidate_position_name LIKE \"%$filter%\"
ORDER BY tbl_Person.last_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$counter++;
}
echo $counter;
?>