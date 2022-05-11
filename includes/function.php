<?php 
function add_escape_character($value) {
// $magic_quotes_active = get_magic_quotes_gpc();
// $compatible_version = function_exists("mysql_real_escape_string");
 
// if($compatible_version) { // PHP v4.3.0 or higher
//   if($magic_quotes_active) {$value=stripslashes($value);}
//      // $value = mysql_real_escape_string($value);
// } else {
//   if(!$magic_quotes_active) {$value=addslashes($value,"'");}
// }
$value = addcslashes($value, "'");

return $value;
}

function GetMonthDescription($date){

	$months = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun",
		"Jul", "Aug", "Sept", "Oct", "Nov", "Dec");
	$dateYear = substr($date, 0,4);
	$monthDescription = $months[(int)(substr($date, 5,2))];
	$dateDays = substr($date, 8,2);
	$fullDate = $monthDescription."-".$dateDays."-".$dateYear;

	return $fullDate;
}

function VerifyBarCode($personCode, $mpin){
global $connection;

$isValid = false;
$query = "SELECT * FROM tbl_Account
  INNER JOIN  tbl_Person ON tbl_Account.person_id=tbl_Person.person_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['person_code'] == $personCode
		&& $User['mpin'] == $mpin){
		$isValid = true;
	}
}
return $isValid;
}//end of Function

function VerifyUserAccount($accountNumber, $accountPassword){
global $connection;

$isValid = false;
$query = "SELECT * FROM tbl_Account
  INNER JOIN  tbl_Person ON tbl_Account.person_id=tbl_Person.person_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['username'] == $accountNumber
		&& password_verify($accountPassword,$User['password'])){
		$isValid = true;
	}
}
return $isValid;
}//end of Function


function UserPersonName($personId){
	global $connection;
	$personCreated="";
	$query = "SELECT * FROM tbl_Person 
	WHERE person_id={$personId}";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$personCreated="{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} {$User['middle_name']}";
	}
	return $personCreated;
}

function CandidatePosition($candidate_position_id){
	global $connection;
	$candidate_position_name="";
	$query = "SELECT * FROM tbl_Candidate_Position 
	WHERE candidate_position_id={$candidate_position_id}";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$candidate_position_name="{$User['candidate_position_name']}";
	}
	return $candidate_position_name;
}

function Get_Type_Description($type_id){
	global $connection;
	$type_description="";
	$query = "SELECT * FROM  tbl_User_Type
	WHERE user_type_id={$type_id}";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$type_description="{$User['type_description']}";
	}
	return $type_description;
}

function Get_Program_Description($type_id){
	global $connection;
	$college_program_name="";
	$query = "SELECT * FROM  tbl_College_Program
	WHERE college_program_id={$type_id}";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$college_program_name="{$User['college_program_name']}";
	}
	return $college_program_name;
}

function Get_Candidate_Position($candidate_position_id){
	global $connection;
	$candidate_position_name="";
	$query = "SELECT * FROM  tbl_Candidate_Position
	WHERE candidate_position_id={$candidate_position_id}";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$candidate_position_name="{$User['candidate_position_name']}";
	}
	return $candidate_position_name;
}

function Get_Person_Program_Description($person_id, $status){
	global $connection;
	$college_program_name="";
	if($status=="All"){
		$query = "SELECT * FROM  tbl_College_Program INNER JOIN tbl_Person_Program
		ON tbl_College_Program.college_program_id = tbl_Person_Program.college_program_id
		WHERE tbl_Person_Program.person_id={$person_id}";
		$Users = mysqli_query($connection, $query);
		while ($User = mysqli_fetch_array($Users)) {
			$college_program_name.="<b>{$User['college_program_name']}</b>: {$User['college_program_description']}";
		}
	}else{
		$query = "SELECT * FROM  tbl_College_Program INNER JOIN tbl_Person_Program
		ON tbl_College_Program.college_program_id = tbl_Person_Program.college_program_id
		WHERE tbl_Person_Program.person_id={$person_id}";
		$Users = mysqli_query($connection, $query);
		while ($User = mysqli_fetch_array($Users)) {
			if($User['person_program_status'] == "Activated")
			$college_program_name.="<b>{$User['college_program_name']}:</b> {$User['college_program_description']}";
		}
	}
	return $college_program_name;
}

function Voting_Program_Details($voting_program_id){
global $connection;

$description="";
$queryVotingProgram = "SELECT * FROM tbl_Voting_Program
WHERE voting_program_id=$voting_program_id";
$VotingPrograms = mysqli_query($connection, $queryVotingProgram);
while ($VotingProgram = mysqli_fetch_array($VotingPrograms)) {

	$dateFrom = GetMonthDescription($VotingProgram['voting_program_starting_date']);
	$dateTo = GetMonthDescription($VotingProgram['voting_program_ending_date']);
	$description = "<div class='row'>
		<div class='col-12'>
			<h5><b>{$VotingProgram['voting_program_name']}</b></h5>	
			<h6><b>{$VotingProgram['voting_program_description']}</b><br>
				Voting Date & Time: 
				$dateFrom @ 
				{$VotingProgram['voting_program_starting_time']} TO 
				$dateTo @ 
				{$VotingProgram['voting_program_ending_time']}
			</h6>	
		</div>
	</div>";
	break;
}
return $description;
}

function Create_Logs($category,$id,$code,$status,$description,$added_by){
global $connection;

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$logs_id = 0;
$query = "SELECT * FROM tbl_Logs
ORDER BY logs_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$logs_id = $User['logs_id'];
}
$logs_id++;
$logs_code=date("d")."".date("Y")."".date("m")."".date("i")."".date("s")."".date("h").$logs_id;

$sql = "INSERT INTO tbl_Logs VALUES ($logs_id,'$logs_code','$category',$id,'$code','$status','$description','$dateEncoded @ $timeEncoded',$added_by)";
mysqli_query($connection, $sql);

}

function statusColor($status){
	$arrayStatus = array("none","Saved","Activated","Deactivated","Registration","Closed", "Opened","Default MPIN","MPIN Changed");
	$arrayBadge = array("None",
		"<span class=\"w3-tag w3-round w3-green\">Saved</span>", 
		"<span class=\"w3-tag w3-round w3-green\">Activated</span>", 
		"<span class=\"w3-tag w3-round w3-red\">Deactivated</span>", 
		"<span class=\"w3-tag w3-round w3-yellow\">Registration</span>", 
		"<span class=\"w3-tag w3-round w3-red\">Closed</span>", 
		"<span class=\"w3-tag w3-round w3-green\">Opened</span>", 
		"<span class=\"w3-tag w3-round w3-blue\">Default MPIN</span>", 
		"<span class=\"w3-tag w3-round w3-yellow\">MPIN Changed</span>");

	$id = 0;
	for($index = 0; $index < COUNT($arrayStatus); $index++){
		if($status == $arrayStatus[$index]){
			$id = $index; break;
		}else{

		}
	}
	return "<span style=\"text-transform:uppercase\">".$arrayBadge[$id]."</span>";
}

function GenerateDisplayId($desc, $id){
	$newId = "";
	$zeroes = 6;
	$getZeroes = 0;
	$getZeroes = $zeroes-strlen($id);
	$generate = "";
	
	for($index = 0; $index < $getZeroes; $index++)
		$generate .= "0";

	$newId = $desc."-".$generate.$id;
	return $newId;
}

function addComma($number){
$counter = 0;
$whole = "";
$flipWhole = "";
$decimal = "";
$num_text = (string)$number; // convert into a string
$array = str_split($num_text);

//get whole numbers
foreach ($array as $char) {
	if($char != "."){
		$counter++; 
		$whole .= $char;
	}
	else
		break;
}

//get decimal numbers
for($index = $counter; $index <strlen($num_text); $index++){
	if($array[$index] != ".")
		$decimal .= $array[$index];
}

//flip whole numbers
$array2 = str_split($whole);
for($index2 = strlen($whole) - 1; $index2 >= 0; $index2--){
	$flipWhole .= $array2[$index2];
}

//add comma per 3 digits
$array3 = str_split($flipWhole, "3"); // break string in 3 character sets
$num_new_text = implode(",", $array3);  // implode array with comma
$array4 = str_split($num_new_text);
$whole = "";

//flip to the original 
for($index3 = strlen($num_new_text) - 1; $index3 >= 0; $index3--){
	$whole .= $array4[$index3];
}

if($decimal != "")
	return $whole . "." . $decimal;
else
	return $whole;
}

function AsOfDate(){
	date_default_timezone_set("Asia/Manila");
	$dateEncoded = GetMonthDescription(date("Y-m-d"));
	$timeEncoded = date("h:i:s A");
	echo "As of: $dateEncoded @ $timeEncoded<br>";
}
?>