<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$person_id = add_escape_character($obj->person_id);
$first_name = add_escape_character($obj->first_name);
$middle_name = add_escape_character($obj->middle_name);
$last_name = add_escape_character($obj->last_name);
$affiliation_name = add_escape_character($obj->affiliation_name);
$date_of_birth = add_escape_character($obj->date_of_birth);
$sex = add_escape_character($obj->sex);
$civil_status = add_escape_character($obj->civil_status);
$region_option = add_escape_character($obj->region_option);
$province_option = add_escape_character($obj->province_option);
$city = add_escape_character($obj->city_option);
$barangay = add_escape_character($obj->barangay_option);
$houseNo = add_escape_character($obj->house_number);
$streetNo = add_escape_character($obj->street);
$email_address = add_escape_character($obj->email_address);
$contact_number = add_escape_character($obj->contact_number);
$telephone_number = add_escape_character($obj->telephone_number);

$sql = "UPDATE tbl_Person 
SET first_name = '$first_name', middle_name = '$middle_name',
last_name = '$last_name', affiliation_name = '$affiliation_name', 
date_of_birth = '$date_of_birth',
sex = '$sex', civil_status = '$civil_status',
house_no = '$houseNo', street = '$streetNo',region = '$region_option',
barangay = '$barangay', city = '$city', province = '$province_option',
email_address = '$email_address',
contact_number = '$contact_number', telephone_number = '$telephone_number'
WHERE person_id = $person_id";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("UPDATE ACCOUNT INFORMATION",$person_id, "", "UPDATE","Information successfully changed<br>New Information<br>Firstname: $first_name, Middlename:$middle_name, Lastname: $last_name, Affiliation: $affiliation_name, Date of Birth: $date_of_birth, Sex: $sex, Civil Status: $civil_status, House Number: $houseNo, Street: $streetNo, Barangay: $barangay, City: $city, Province: $province_option,Region: $region_option, Username: $email_address, Contact Number: $contact_number, Telephone Number: $telephone_number",$signedin_person_id);
	// END OF LOGS

	$sql = "UPDATE tbl_Account 
	SET username = '$email_address'
	WHERE person_id = $person_id";
	if(mysqli_query($connection, $sql)){
		echo true;
		// LOGS
		// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
		Create_Logs("UPDATE ACCOUNT EMAIL ADDRESS",$person_id, "", "UPDATE","Email successfully changed<br>Name: $last_name $affiliation_name, $first_name $middle_name<br>New Username<br>Username $email_address",$signedin_person_id);
		// END OF LOGS
	}else{
		echo "Account Error: ".$connection->error;
	}
}else{
	echo false;
}


?>