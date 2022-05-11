<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$personId = $obj->personId;
$password = $obj->password;
$jsonArray = array();
$flag = false;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Account
ON tbl_Person.person_id = tbl_Account.person_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if(password_verify($password,$User['password'])
		&& $User['person_id'] == $personId){
		$flag = true;	
	}
}
	$jsonArrayItem=array();
	$jsonArrayItem['verified']=$flag;
	array_push($jsonArray, $jsonArrayItem);

	$connection->close();
    header('Content-type: application/json');		
	echo json_encode($jsonArray);
?>