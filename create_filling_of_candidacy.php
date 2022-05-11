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
                                <h5>Filling of Candidacy</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>

                    </div>  
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <label for="select_candidate_position">Select Candidate Position: <span class="required validation-area error_select_candidate_position">*</span></label>
                    <div class="input-group input-group-success">
                        <select id='select_candidate_position' class="form-control selectField"></select>
                    </div>                    
                  </div>
                  <div class="col-lg-12">
                    <label for="position_platforms">Platforms: <span class="required validation-area error_position_platforms">*</span></label>
                        <input type="text" id="position_platforms" class="form-control" name="position_platforms" required />
                  </div>
                  <div class="col-lg-12"><br>
                    <button class="btn alert-info" id="btnSave" onclick="VerifyCandidacy()"><i class="ik ik-save"></i> Save</button>
                  </div>
                </div>
            </div>
        </div>

<script type="text/javascript">
ComboBox_Candidate_Position();
function ComboBox_Candidate_Position(){
  var obj={"status":"Activated"};
  var parameter = JSON.stringify(obj); 
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#select_candidate_position").text("");
      $("#select_candidate_position").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_candidate_position/get_candidate_position_combo_box.php?data="+parameter, true);
  xmlhttp.send();
}

function VerifyCandidacy(){
  if($("#select_candidate_position").val() == ""){
  $(".error_select_candidate_position").text("* Field is required");
  }else{
    $(".error_select_candidate_position").text("*");

    if($("#position_platforms").val() == ""){
      $(".error_position_platforms").text("* Field is required");
    }else{
      $(".error_position_platforms").text("*");
      ToggleDIV("divVerifyFillingOfCandidacy", "block");
    }
  }
}

function Save_Records(){
  if($("#select_candidate_position").val() == ""){
  $(".error_select_candidate_position").text("* Field is required");
  }else{
    $(".error_select_candidate_position").text("*");

    if($("#position_platforms").val() == ""){
      $(".error_position_platforms").text("* Field is required");
    }else{
      $(".error_position_platforms").text("*");
      var obj={"candidate_position_id":$("#select_candidate_position").val(),
          "position_platforms":$("#position_platforms").val()};
          var parameter = JSON.stringify(obj); 
          ToggleDIV("divVerifyFillingOfCandidacy", "none");
          $.ajax({url:'tbl_filling_of_candidacy/create_filling_of_candidacy.php?data='+parameter,
          method:'GET',
          success:function(data){
            if(data == true){
              showToast("Success", "Filling of Candidacy successfully saved !.", "success", "#f96868");
              $("#position_platforms").val("");
            }
            else{
                showToast("Warning", "Saving of filling of candidacy was failed, Please try again !."+data, "warning", "#57c7d4");
            }
          },
          error:function(){
            showToast("Danger", "Registration went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
              $("#position_platforms").val("");
          }
        });//end of ajax
    }
  }
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

<div id="divVerifyFillingOfCandidacy" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">System Notification</h5>
                <button type="button" class="close" onclick="ToggleDIV('divVerifyFillingOfCandidacy','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <h5>Are you sure you want to file your candidacy?</h5>
              <button class="btn btn-medium alert-success" id="submitVote" type="submit" name="submit"
              onclick="Save_Records()" style="width: 100%;"><i class="fa fa-check"> Yes</i></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divVerifyFillingOfCandidacy','none')">Close</button>
            </div>
        </div>
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>


<!-- 
CONFIGURE IP ADDRESS:
tbl_accounts folder
    1. json_account.php
    2. read_profile.php
 -->