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
                                <h5>New Voting Program</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>

                    </div>  
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <label for="voting_program_name">Voting Program Name: <span class="required validation-area error_voting_program_name">*</span></label>
                    <input type="text" id="voting_program_name" class="form-control" name="voting_program_name" required />
                  </div>
                  <div class="col-lg-12">
                    <label for="voting_program_description">Voting Program description: <span class="required validation-area error_voting_program_description">*</span></label>
                    <input type="text" id="voting_program_description" class="form-control" name="voting_program_description" required />
                  </div>
                </div>

                <div class="row">
                    <div class="col-lg-12"><br></div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <label for="starting_date">Starting Date: <span class="required validation-area error_starting_date">*</span></label>
                    <input type="date" id="starting_date" class="form-control" name="starting_date" required />
                  </div>
                  <div class="col-lg-6">
                    <label for="starting_time">Starting Time: <span class="required validation-area error_starting_time">*</span></label>
                    <input type="time" id="starting_time" class="form-control" name="starting_time" required />
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <label for="ending_date">Ending Date: <span class="required validation-area error_ending_date">*</span></label>
                    <input type="date" id="ending_date" class="form-control" name="ending_date" required />
                  </div>
                  <div class="col-lg-6">
                    <label for="ending_time">Ending Time: <span class="required validation-area error_ending_time">*</span></label>
                    <input type="time" id="ending_time" class="form-control" name="ending_time" required />
                  </div>
                </div>

                <div class="row">
                    <div class="col-lg-12"><br>
                        <h5>Available Party List</h5>
                        <div id="divListOfPartyList"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12"><hr>
                         <button class="btn alert-success btn-medium" onclick="Verify_Records()"><i class="ik ik-save"></i> Submit</button>

                         <p class="error"></p>
                    </div>
                </div>


            </div>
        </div>

<script type="text/javascript">
DisplayListOfPartyList();
function DisplayListOfPartyList(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#divListOfPartyList").text("");
      $("#divListOfPartyList").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_party_list/read_party_list_for_new_voting_program.php", true);
  xmlhttp.send();
}

function Verify_Records(){
  if($("#voting_program_name").val() == "" || 
        $("#voting_program_description").val() == "" || 
        $("#starting_date").val() == "" || $("#starting_time").val() == "" ||
        $("#ending_date").val() == "" || $("#ending_time").val() == ""){
  $(".error_voting_program_name").text("* Field is required");
  $(".error_voting_program_description").text("* Field is required");
  $(".error_starting_date").text("* Field is required");
  $(".error_ending_date").text("* Field is required");
  $(".error_starting_time").text("* Field is required");
  $(".error_ending_time").text("* Field is required");
}else{
    $(".error_voting_program_name").text("*");
    $(".error_voting_program_description").text("*");
    $(".error_starting_date").text("*");
    $(".error_ending_date").text("*");
    $(".error_starting_time").text("*");
    $(".error_ending_time").text("*");
      
      ToggleDIV("divVerifyVotingProgram", "block");
  }
}

function Save_Records(){
if($("#voting_program_name").val() == "" || 
        $("#voting_program_description").val() == "" || 
        $("#starting_date").val() == "" || $("#starting_time").val() == "" ||
        $("#ending_date").val() == "" || $("#ending_time").val() == ""){
  $(".error_voting_program_name").text("* Field is required");
  $(".error_voting_program_description").text("* Field is required");
  $(".error_starting_date").text("* Field is required");
  $(".error_ending_date").text("* Field is required");
  $(".error_starting_time").text("* Field is required");
  $(".error_ending_time").text("* Field is required");
}else{
    $(".error_voting_program_name").text("*");
    $(".error_voting_program_description").text("*");
    $(".error_starting_date").text("*");
    $(".error_ending_date").text("*");
    $(".error_starting_time").text("*");
    $(".error_ending_time").text("*");

    var chkPartyList = document.getElementsByClassName("chkPartyList");
    var objPartyListId = [];
    for(var index=0; index<chkPartyList.length; index++){
        if(chkPartyList[index].checked == true){
          objPartyListId.push(chkPartyList[index].value);
          // alert(chkPartyList[index].value);
        }
    }
    var parameterObjPartyListId=JSON.stringify(objPartyListId);

    var obj={"voting_program_name":$("#voting_program_name").val(), 
      "voting_program_description":$("#voting_program_description").val(), 
      "voting_program_starting_date":$("#starting_date").val(), 
      "voting_program_starting_time":$("#starting_time").val(), 
      "voting_program_ending_date":$("#ending_date").val(), 
      "voting_program_ending_time":$("#ending_time").val()};
      var parameter = JSON.stringify(obj); 
      ToggleDIV("divVerifyVotingProgram", "none");
      $.ajax({url:'tbl_Voting_Program/create_voting_program.php?data='+parameter+"&dataobjPartyList="+parameterObjPartyListId,
      method:'GET',
      success:function(data){
        if(data == true){
          ToggleDIV("divSystemNotification2", "block");
            $(".modalMessage2").text("Success: Registration successfully saved !.");
        }
        else{
          showToast("Warning", "Saving of voting program was failed, Please try again !."+data, "warning", "#57c7d4");
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

<div id="divVerifyVotingProgram" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">System Notification</h5>
                <button type="button" class="close" onclick="ToggleDIV('divVerifyVotingProgram','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <h5>Are you sure you want to save this voting program and party list?</h5>
              <button class="btn btn-medium alert-success" type="submit" name="submit"
              onclick="Save_Records()" style="width: 100%;"><i class="fa fa-check"> Yes</i></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divVerifyVotingProgram','none')">Close</button>
            </div>
        </div>
    </div>
</div>

        <?php include("includes/main_footer.php"); ?>  
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>