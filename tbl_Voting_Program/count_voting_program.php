<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$filter = $obj->filter;

$counter = 0;
$query = "SELECT * FROM tbl_Voting_Program
WHERE voting_program_name LIKE \"%$filter%\" OR 
voting_program_description LIKE \"%$filter%\"
ORDER BY voting_program_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$counter++;
}
echo $counter;
?>