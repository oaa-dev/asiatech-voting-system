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
                                <h5>Vote Now</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>

                    </div>  
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div id="divListOfCandidate"></div>
                    </div>
                </div>

            </div>
        </div>

<script type="text/javascript">
DisplayCandidates();
function DisplayCandidates(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#divListOfCandidate").text("");
      $("#divListOfCandidate").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_party_list/read_party_list_to_vote.php", true);
  xmlhttp.send();
}

function Verify_Vote(voting_program_id){
  var radioButtonPartyList = document.getElementsByClassName("radioButtonPartyList");
  var vote_counter=0;
  for(var index=0; index<radioButtonPartyList.length; index++){
      if(radioButtonPartyList[index].checked == true){
        vote_counter++;
      }
  }

  if(vote_counter == 0){
    showToast("Warning", "Please select at least one candidate to save your vote.", "warning", "#57c7d4");
  }else{
    // showToast("Success", "Vote successfully saved.", "success", "#f96868");
    ToggleDIV("divVerifyVote", "block");
    $("#submitVote").val(voting_program_id);    
  }
}

function Save_Vote(){    
  var radioButtonPartyList = document.getElementsByClassName("radioButtonPartyList");
  var objPartyListId = [];
  for(var index=0; index<radioButtonPartyList.length; index++){
      if(radioButtonPartyList[index].checked == true){
        objPartyListId.push(radioButtonPartyList[index].value);
        // alert(radioButtonPartyList[index].value);
      }
  }
  var parameterObjPartyListId=JSON.stringify(objPartyListId);

  var obj={"voting_program_id":$("#submitVote").val()};
  var parameter = JSON.stringify(obj); 
    ToggleDIV("divVerifyVote", "none");
    $.ajax({url:'tbl_Votes/create_votes.php?data='+parameter+"&dataobjPartyList="+parameterObjPartyListId,
    method:'GET',
    success:function(data){
      if(data == true){
        ToggleDIV("divSystemNotification2", "block");
          $(".modalMessage2").text("Success: Votes successfully saved !.");
      }
      else{
        showToast("Warning", "Saving of votes was failed, Please try again !."+data, "warning", "#57c7d4");
        $(".error").text("");
        $(".error").append(data);
        // Reload_Page();
      }
    },
    error:function(){
      showToast("Danger", "Registration went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
      // Reload_Page();
    }
  });//end of ajax
}

function Reload_Page(){
  location.reload();
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

<div id="divSystemNotification2" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">System Notification</h5>
                <button type="button" class="close" onclick="Reload_Page()"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <h4 class="modalMessage2"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="Reload_Page()">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="divVerifyVote" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">System Notification</h5>
                <button type="button" class="close" onclick="ToggleDIV('divVerifyVote','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <h5>Are you sure you want to submit your vote?</h5>
              <button class="btn btn-medium alert-success" id="submitVote" type="submit" name="submit"
              onclick="Save_Vote()" style="width: 100%;"><i class="fa fa-check"> Yes</i></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divVerifyVote','none')">Close</button>
            </div>
        </div>
    </div>
</div>
        <?php include("includes/main_footer.php"); ?>  
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>