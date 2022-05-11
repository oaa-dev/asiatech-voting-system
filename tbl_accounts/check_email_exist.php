<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$email = $obj->email;
$status = $obj->status;
$id = $obj->id;

$isExist = false;
if($id==0){
	$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Account
	ON tbl_Person.person_id=tbl_Account.person_id";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		if($User['email_address']==$email){
			$isExist = true;
			break;
		}
	}
}else{
	$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Account
	ON tbl_Person.person_id=tbl_Account.person_id";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		if($User['email_address']==$email && $User['person_id']!=$id){
			$isExist = true;
			break;
		}
	}
}
echo $isExist;
?>