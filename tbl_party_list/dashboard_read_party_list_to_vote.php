<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
    $signedin_user_type_id = $_SESSION['userTypeId'];
    $signedin_person_id = $_SESSION['personId'];
?>

<?php 
$voting_program_id=0;
$check_status=false;
$queryVotingProgram = "SELECT * FROM tbl_Voting_Program
INNER JOIN tbl_Voting_Program_Has_Party_List
ON tbl_Voting_Program.voting_program_id=tbl_Voting_Program_Has_Party_List.voting_program_id
INNER JOIN tbl_Party_List
ON tbl_Voting_Program_Has_Party_List.party_list_id=tbl_Party_List.party_list_id
WHERE tbl_Voting_Program.voting_status = \"Opened\"";
$VotingPrograms = mysqli_query($connection, $queryVotingProgram);
while ($VotingProgram = mysqli_fetch_array($VotingPrograms)) {
    $check_status=true;
    $voting_program_id=$VotingProgram['voting_program_id'];
    $dateFrom = GetMonthDescription($VotingProgram['voting_program_starting_date']);
    $dateTo = GetMonthDescription($VotingProgram['voting_program_ending_date']);
    echo "  <h5><b>{$VotingProgram['voting_program_name']}</b></h5> 
        <h6><b>{$VotingProgram['voting_program_description']}</b><br>
            Voting Date & Time: 
            $dateFrom @ 
            {$VotingProgram['voting_program_starting_time']} TO 
            $dateTo @ 
            {$VotingProgram['voting_program_ending_time']}
        </h6>";
    break;
}

if(!$check_status){
    // echo "<div class='row'>
    //     <div class='col-lg-12'>
    //         <div class='alert alert-success'><h6><b><i class='ik ik-alert-triangle'></i> Note:</b> No voting line is open either your college / department has no candidate for any position or no voting program is open.</h6></div>
    //     </div>
    // </div>";
}else{
echo "<div class='owl-container'>
        <div class='owl-carousel single'>";
    $queryPartyList = "SELECT * FROM tbl_Voting_Program_Has_Party_List
    INNER JOIN tbl_Party_List
    ON tbl_Voting_Program_Has_Party_List.party_list_id = tbl_Party_List.party_list_id
    WHERE tbl_Voting_Program_Has_Party_List.voting_program_id=$voting_program_id
    AND tbl_Party_List.party_list_status=\"Activated\"";
    $PartyLists = mysqli_query($connection, $queryPartyList);
    while ($PartyList = mysqli_fetch_array($PartyLists)) {

   echo "<div class='card d-flex flex-row'>
        <div class='pl-2 d-flex flex-grow-1 min-width-zero'>
            <div class='card-body'>
                <div class='col-lg-12'><h5 style='text-align:center;'>{$PartyList['party_list_name']}</h5></div>";
        $candidate_name="";
        $get_program_description="";
        $action="";

        echo "<div class='row'>";
        $queryCandidates = "SELECT * FROM tbl_Person_Candidate_Party_List
        INNER JOIN tbl_Person_Program
        ON tbl_Person_Candidate_Party_List.person_program_id = tbl_Person_Program.person_program_id
        INNER JOIN tbl_Person 
        ON tbl_Person_Program.person_id = tbl_Person.person_id
        WHERE tbl_Person_Candidate_Party_List.person_candidate_party_list_status = \"Activated\"";
        $Candidates = mysqli_query($connection, $queryCandidates);
        while ($Candidate = mysqli_fetch_array($Candidates)) {
            if($Candidate['party_list_id']==$PartyList['party_list_id']){
                $get_program_description = Get_Program_Description($Candidate['college_program_id']);
                $candidate_position_name=Get_Candidate_Position($Candidate['candidate_position_id']);
                echo "";

                echo "<div class='col-lg-4' style='text-align:center;'>
                    <b>{$Candidate['last_name']} {$Candidate['affiliation_name']}, {$Candidate['first_name']} {$Candidate['middle_name']}</b><br>
                    <span style='color:gray;'><b>$candidate_position_name</b>
                    (<i>$get_program_description</i>)</span>
                </div>";                
            }
        }
        echo "</div>";

        echo "<div class='row'><div class='col-lg-12 block-title-text'><br><h6>PLATFORMS</h6><ul>";
        $queryPlatform = "SELECT * FROM tbl_Party_List_Platform";
        $Platforms = mysqli_query($connection, $queryPlatform);
        while ($Platform = mysqli_fetch_array($Platforms)) {
            if($Platform['party_list_id']==$PartyList['party_list_id']){
                echo "<li><b>{$Platform['party_list_platform_title']}: </b> {$Platform['party_list_platform_content']}</li>";
            }   
        }
        echo "</ul></div></div>";
                     
            echo "</div>
        </div>
    </div>";
    }

    echo "    </div>
        <div class='slider-nav text-center'>
            <a href='#' class='left-arrow owl-prev'>
                <i class='ik ik-chevron-left'></i>
            </a>
            <div class='slider-dot-container'></div>
            <a href='#' class='right-arrow owl-next'>
                <i class='ik ik-chevron-right'></i>
            </a>
        </div>
    </div>";
}
?>


       <!--  <div class='card d-flex flex-row'>
            <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                    <a href="#">
                        <p class="list-item-heading mb-1 truncate">Hey, You wanna join me and Fred at the lake tomorrow?</p>
                    </a>
                    <p class="mb-0 text-muted text-small">Concept</p>
                    <p class="mb-0 text-muted text-small">09.04.2018</p>
                    <div>
                        <span class="badge badge-pill badge-primary">New</span>
                        <span class="badge badge-pill badge-secondary">On Hold</span>
                    </div>
                </div>
            </div>
        </div> -->

        
<!-- 

        <div class="card d-flex flex-row">
            <a class="d-flex" href="#">
                <img alt="Thumbnail" src="img/portfolio-9.jpg" class="list-thumbnail responsive border-0">
            </a>
            <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                    <a href="#">
                        <p class="list-item-heading mb-1 truncate">Eff that place, you might as well stay here with us instead</p>
                    </a>
                    <p class="mb-1 text-muted text-small">Projects</p>
                    <p class="mb-1 text-muted text-small">09.04.2018</p>
                    <div>
                        <span class="badge badge-pill badge-primary">New</span>
                        <span class="badge badge-pill badge-secondary">On Hold</span>
                    </div>
                </div>
            </div>
        </div> -->