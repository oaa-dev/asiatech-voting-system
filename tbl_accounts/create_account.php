<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$first_name = add_escape_character($obj->first_name);
$middle_name = add_escape_character($obj->middle_name);
$last_name = add_escape_character($obj->last_name);
$affiliation_name = add_escape_character($obj->affiliation_name);
$date_of_birth = add_escape_character($obj->date_of_birth);
$sex = add_escape_character($obj->sex);
$civil_status = add_escape_character($obj->civil_status);
$region_option = add_escape_character($obj->region_option);
$province_option = add_escape_character($obj->province_option);
$city_option = add_escape_character($obj->city_option);
$barangay_option = add_escape_character($obj->barangay_option);
$house_number = add_escape_character($obj->house_number);
$street = add_escape_character($obj->street);
$email_address = add_escape_character($obj->email_address);
$contact_number = add_escape_character($obj->contact_number);
$telephone_number = add_escape_character($obj->telephone_number);
$user_type_id = add_escape_character($obj->user_type_id);
$status = add_escape_character($obj->status);
$access_status = add_escape_character($obj->access_status);
$password = add_escape_character($obj->password);
$personAddedBy = add_escape_character($obj->personAddedBy);
$college_program_id = add_escape_character($obj->college_program_id);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$person_id = 0;
$query = "SELECT * FROM tbl_Person
ORDER BY person_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$person_id = $User['person_id'];
}
$person_id++;

$account_id = 0;
$query = "SELECT * FROM tbl_Account
ORDER BY account_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$account_id = $User['account_id'];
}
$account_id++;

$generated_code = GenerateDisplayId("CODE", $person_id);

$sql = "INSERT INTO tbl_Person VALUES ($person_id,'$generated_code','$first_name','$middle_name','$last_name','$affiliation_name','$date_of_birth','$sex','$civil_status','$house_number','$street','$barangay_option','$city_option','$province_option','$region_option','$email_address','$contact_number','$telephone_number','$dateEncoded @ $timeEncoded','$status',$user_type_id,$personAddedBy)";
if(mysqli_query($connection, $sql)){
	
	// LOGS
	$type_description=Get_Type_Description($user_type_id);
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("NEW USER",$person_id, $generated_code, "CREATE","New $type_description user successfully saved<br>New Information<br>Firstname: $first_name, Middlename:$middle_name, Lastname: $last_name, Affiliation: $affiliation_name, Date of Birth: $date_of_birth, Sex: $sex, Civil Status: $civil_status, House Number: $house_number, Street: $street, Barangay: $barangay_option, City: $city_option, Province: $province_option,Region: $region_option, Username: $email_address, Contact Number: $contact_number, Telephone Number: $telephone_number, Status: $status",$personAddedBy);
	// END OF LOGS

	$hashpassword=password_hash(add_escape_character($password),PASSWORD_DEFAULT);
	$sql = "INSERT INTO tbl_Account 
	VALUES ($account_id,$person_id,'$email_address','$hashpassword','0000','$access_status')";
	if(mysqli_query($connection, $sql)){
		
		// LOGS
		// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
		Create_Logs("CREATE ACCOUNT",$account_id, $generated_code, "CREATE","New $type_description account successfully saved<br>Account Information<br>Name: $last_name $affiliation_name, $first_name $middle_name<br>Username: $email_address<br>Password: $password / $hashpassword<br>Access Status: $access_status",$personAddedBy);
		// END OF LOGS

			$person_program_id=0;
			$query = "SELECT * FROM tbl_Person_Program
			ORDER BY person_program_id ASC";
			$Users = mysqli_query($connection, $query);
			while ($User = mysqli_fetch_array($Users)) {
				$person_program_id = $User['person_program_id'];
			}
			$person_program_id++;
			$generated_code = GenerateDisplayId("PERSON-PROGRAM", $person_program_id);

			$sql = "INSERT INTO tbl_Person_Program 
			VALUES ($person_program_id,'$generated_code',$person_id,$college_program_id,'','$dateEncoded @ $timeEncoded','Activated',$personAddedBy)";
			if(mysqli_query($connection, $sql)){
				
				// LOGS
				// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
				$program_description=Get_Program_Description($college_program_id);
				Create_Logs("CREATE PERSON COLLEGE PROGRAM",$person_program_id, $generated_code, "CREATE","New person has college program successfully saved<br>New Information<br>Name: $last_name $affiliation_name, $first_name $middle_name<br>Program: $program_description",$personAddedBy);
				echo true;
			}else{

			}
	}else{
		echo "Account Error: ".$connection->error;
	}
}else{
	echo "Person Error: ".$connection->error." || ".$sql;
}
?>