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
                                <h5>Profile</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                      </div>                        
                    </div>  
                </div>

                <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="divProfileSide"></div>
                            </div>
                            <div class="col-lg-8 col-md-7">
                                <div class="card">
                                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active show" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Get Your Code</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="false">Activity Logs</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="true">Account Settings</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <div class="card-body">
                                                <div class="divProfile"></div>
                                                <hr>
                                                
                                              
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                            <div class="card-body">

                                                <span id="itemFrom" style="display: none;"></span>
                                                <span id="itemTo" style="display: none;"></span>

                                                <div class="divLogs"></div>
                                                <div class="divPagination w3-center"></div>

                                            </div>
                                        </div>                                        
                                        <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                                            <div class="card-body">
                                              <div class="row">
                                                <div class="col-lg-6">
                                                  <img src="img/change_password.jpg" style="width: 100%;">
                                                </div>
                                                <div class="col-lg-6">
                                                  <button class="btn alert-success btn-medium" onclick="Change_MPIN()"><i class="ik ik-edit"></i> CHANGE MPIN</button><br><br> 
                                                  <button class="btn alert-success btn-medium" onclick="Change_Password()"><i class="ik ik-edit"></i> CHANGE PASSWORD</button>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

            </div>
        </div>

        <?php include("includes/main_footer.php"); ?>  
    </div>
</div>

<?php 
  $id = $_SESSION['personId'];
?>
<script type="text/javascript">
DisplayProfile();
function DisplayProfile(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $(".divProfile").text("");
      $(".divProfile").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_accounts/read_profile.php", true);
  xmlhttp.send();
}

DisplayProfileSide();
function DisplayProfileSide(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $(".divProfileSide").text("");
      $(".divProfileSide").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_accounts/read_profile_side.php", true);
  xmlhttp.send();
}

Pagination();
function Pagination(){
  GeneratePagination();
  DisplayLogs();
}

function GeneratePagination(){
$(".divPagination").text("");
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
  var transactionCount = JSON.parse(this.responseText);
  
  $(".divPagination").text("");
  var totalItems=transactionCount;
  
  var perItem=10; 
  var paginator = totalItems/perItem;
  var textCounter=0;
  var start=1;
  var end=perItem;
  Next(start, end);
  for(var index=0; index<paginator; index++){
    textCounter++;
    $(".divPagination").append("<button class='btn alert-success btnPagination' onclick=\"Next("+start+","+end+")\">"+(index+1)+"</button> ");
    start+=perItem;
    end+=perItem;
  }
}//end of if
};
xmlhttp.open("GET", "tbl_logs/count_logs_per_user.php", true);
xmlhttp.send();
}

function Next(start, end){
  $("#itemFrom").text(start);
  $("#itemTo").text(end);
  DisplayLogs();
}

function DisplayLogs(){
  var start = $("#itemFrom").text();
  var end = $("#itemTo").text();
  var obj = {"start":start,"end":end};
  var parameter = JSON.stringify(obj);
   
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $(".divLogs").text("");
      $(".divLogs").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_logs/read_logs_per_user.php?data=" + parameter, true);
  xmlhttp.send();
}

function Change_MPIN(){
  ToggleDIV("divUpdateMPIN", "block");
  $("#current_password").val("");
  $("#new_mpin").val("");
  $("#re_enter_mpin").val("");
}

function Check_MPIN(){
  if($("#current_password").val() == ""){
    $(".error_current_password").text("* Field is required.");
  }else{
    $(".error_current_password").text("*");
    if($("#new_mpin").val() == "" || $("#re_enter_mpin").val() == ""){
      $(".error_new_mpin").text("* Field is required.");
      $(".error_re_enter_mpin").text("* Field is required.");
    }else{      
      $(".error_new_mpin").text("*");
      $(".error_re_enter_mpin").text("*");
      if($("#new_mpin").val() != $("#re_enter_mpin").val()){
        $(".error_new_mpin").text("* MPIN does not match.");
        $(".error_re_enter_mpin").text("*  MPIN does not match.");
      }else{
        $(".error_new_mpin").text("*");
        $(".error_re_enter_mpin").text("*");

        var id = "<?php echo $id; ?>";
        var  obj = {"personId":id, "password":$("#current_password").val()};
        var parameter = JSON.stringify(obj);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
              if(data[0].verified == false){
                $(".error_current_password").text("* Invalid password.");
              }else{
                Save_MPIN();
              }
          }
        };
        xmlhttp.open("GET", "tbl_accounts/verify_password.php?data="+parameter, true);
        xmlhttp.send(); 

      }
    }
  }
}

function Save_MPIN(){
  var id = "<?php echo $id; ?>";
  var  obj = {"personId":id, "mpin":$("#new_mpin").val()};
  var parameter = JSON.stringify(obj);
  $.ajax({url:'tbl_accounts/update_account_mpin.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        showToast("Success", "Account mpin successfully updated !.", "success", "#f96868");
        ToggleDIV("divUpdateMPIN", "none");
      }
      else{
        showToast("Warning", "Updating account mpin was failed, Please try again !.", "warning", "#57c7d4");
        ToggleDIV("divUpdateMPIN", "none");
      }
    },
    error:function(){
        showToast("Danger", "Updating account mpin went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
      ToggleDIV("divUpdateMPIN", "none");
    }
  });//end of ajax
}

function Change_Password(){
  ToggleDIV("divUpdatePassword", "block");
  $("#current_password_").val("");
  $("#new_password").val("");
  $("#re_enter_password").val("");
}

function Check_Password(){
  if($("#current_password_").val() == ""){
    $(".error_current_password_").text("* Field is required.");
  }else{
    $(".error_current_password_").text("*");
    if($("#new_password").val() == "" || $("#re_enter_password").val() == ""){
      $(".error_new_password").text("* Field is required.");
      $(".error_re_enter_password").text("* Field is required.");
    }else{      
      $(".error_new_password").text("*");
      $(".error_re_enter_password").text("*");
      if($("#new_password").val() != $("#re_enter_password").val()){
        $(".error_new_password").text("* Password does not match.");
        $(".error_re_enter_password").text("*  Password does not match.");
      }else{
        $(".error_new_password").text("*");
        $(".error_re_enter_password").text("*");

        var id = "<?php echo $id; ?>";
        var  obj = {"personId":id, "password":$("#current_password_").val()};
        var parameter = JSON.stringify(obj);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
              if(data[0].verified == false){
                $(".error_current_password_").text("* Invalid password.");
              }else{
                Save_Password();
              }
          }
        };
        xmlhttp.open("GET", "tbl_accounts/verify_password.php?data="+parameter, true);
        xmlhttp.send(); 

      }
    }
  }
}

function Save_Password(){
  var id = "<?php echo $id; ?>";
  var  obj = {"personId":id, "newPassword":$("#new_password").val()};
  var parameter = JSON.stringify(obj);
  $.ajax({url:'tbl_accounts/update_password.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        showToast("Success", "Account password successfully updated !.", "success", "#f96868");
        ToggleDIV("divUpdatePassword", "none");
      }
      else{
        showToast("Warning", "Updating account password was failed, Please try again !.", "warning", "#57c7d4");
        ToggleDIV("divUpdatePassword", "none");
      }
    },
    error:function(){
        showToast("Danger", "Updating account password went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
      ToggleDIV("divUpdatePassword", "none");
    }
  });//end of ajax
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

function ToggleDIV(id,status){
    document.getElementById(id).style.display=status;
}
</script>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>

<div id="divUpdateMPIN" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">CHANGE MPIN</h5>
                <button type="button" class="close" onclick="ToggleDIV('divUpdateMPIN','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <label for="current_password">Current Password: <span class="required validation-area error_current_password">*</span></label>
                  <input type="password" id="current_password" class="form-control" name="current_password" required />
                </div>
                <div class="col-lg-12">
                  <label for="new_mpin">New MPIN: <span class="required validation-area error_new_mpin">*</span></label>
                  <input type="password" id="new_mpin" class="form-control" name="new_mpin" required />
                </div>
                <div class="col-lg-12">
                  <label for="re_enter_mpin">Re-enter MPIN: <span class="required validation-area error_re_enter_mpin">*</span></label>
                  <input type="password" id="re_enter_mpin" class="form-control" name="re_enter_mpin" required />
                </div>
                <div class="col-lg-12"> <br>
                    <button class="btn alert-success btn-medium" onclick="Check_MPIN()"><i class="ik ik-save"></i> SAVE MPIN</button>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divUpdateMPIN','none')">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="divUpdatePassword" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">CHANGE PASSWORD</h5>
                <button type="button" class="close" onclick="ToggleDIV('divUpdatePassword','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <label for="current_password_">Current Password: <span class="required validation-area error_current_password_">*</span></label>
                  <input type="password" id="current_password_" class="form-control" name="current_password_" required />
                </div>
                <div class="col-lg-12">
                  <label for="new_password">New Password: <span class="required validation-area error_new_password">*</span></label>
                  <input type="password" id="new_password" class="form-control" name="new_password" required />
                </div>
                <div class="col-lg-12">
                  <label for="re_enter_password">Re-enter Password: <span class="required validation-area error_re_enter_password">*</span></label>
                  <input type="password" id="re_enter_password" class="form-control" name="re_enter_password" required />
                </div>
                <div class="col-lg-12"> <br>
                    <button class="btn alert-success btn-medium" onclick="Check_Password()"><i class="ik ik-save"></i> SAVE PASSWORD</button>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divUpdatePassword','none')">Close</button>
            </div>
        </div>
    </div>
</div>