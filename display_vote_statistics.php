<?php include("includes/header.php"); ?>

<div class="wrapper">
    <?php include("includes/top.php"); ?>
    <div class="page-wrap">
        <div class="app-sidebar colored">
            <?php include("includes/sidebar.php"); ?>
        </div>
        <div class="main-content">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-users bg-green"></i>
                            <div class="d-inline">
                                <h5>Vote Statistics</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>

                    </div>  
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div id="displayListOfVotingProgram"></div>
                    </div>
                </div>

            </div>
        </div>

<script type="text/javascript">
DisplayVotingProgram();
function DisplayVotingProgram(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#displayListOfVotingProgram").text("");
      $("#displayListOfVotingProgram").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_Voting_Program/read_voting_program_to_vote_statistics.php", true);
  xmlhttp.send();
}

function View_Vote_Statistics(id){
  ToggleDIV("div_vote_statistics", "block");
  Display_Votes(id);
}
function Display_Votes(id){
  var obj = {"voting_program_id":id};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#divListOfVotes").text("");
      $("#divListOfVotes").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_Votes/read_vote_statistics.php?data=" + parameter, true);
  xmlhttp.send();    
}


function View_Candidate(party_list_id){
  ToggleDIV("div_view_candidate", "block");
  DisplayCandidatesSummary(party_list_id);
  DiplayPartyListPlatforms(party_list_id);
}

function DisplayCandidatesSummary(party_list_id){
  var obj = {"party_list_id":party_list_id};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $(".divListOfCandidateAndPlatforms1").text("");
      $(".divListOfCandidateAndPlatforms1").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_candidate_party_list/read_candidate_party_list_to_vote.php?data=" + parameter, true);
  xmlhttp.send();
}

function DiplayPartyListPlatforms(party_list_id){
  var obj = {"party_list_id":party_list_id};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $(".divListOfCandidateAndPlatforms2").text("");
      $(".divListOfCandidateAndPlatforms2").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_party_list_platform/read_party_list_platform_to_vote.php?data=" + parameter, true);
  xmlhttp.send();
}

function ToggleDIV(id,status){
    document.getElementById(id).style.display=status;
}

(function($) {
  showToast = function(heading, text, icon, loaderBg) {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: heading,
      text: text,
      showHideTransition: 'slide',
      icon: icon,
      loaderBg: loaderBg,
      position: 'top-right'
    })
  };

  resetToastPosition = function() {
    $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
    $(".jq-toast-wrap").css({
      "top": "",
      "left": "",
      "bottom": "",
      "right": ""
    }); //to remove previous position style
  }
})(jQuery);
</script>
        <?php include("includes/main_footer.php"); ?>  
    </div>
</div>


<div id="div_view_candidate" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Candidates and Platforms</h5>
                <button type="button" class="close" onclick="ToggleDIV('div_view_candidate','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <h6>Candidate</h6>
                  <div class="divListOfCandidateAndPlatforms1"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <h6>Party List Platforms</h6>
                  <div class="divListOfCandidateAndPlatforms2"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('div_view_candidate','none')">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="div_vote_statistics" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:800px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Cast Your Vote</h5>
                <button type="button" class="close" onclick="ToggleDIV('div_vote_statistics','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="divListOfVotes"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('div_vote_statistics','none')">Close</button>
            </div>
        </div>
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>