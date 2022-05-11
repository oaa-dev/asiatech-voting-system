<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$filter = $obj->filter;

$counter = 0;
$query = "SELECT * FROM tbl_Candidate_Position
WHERE candidate_position_name LIKE \"%$filter%\" OR 
candidate_position_description LIKE \"%$filter%\"";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$counter++;
}
echo $counter;
?>