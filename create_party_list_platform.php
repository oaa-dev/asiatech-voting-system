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
                                <h5>Party List Platform</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>

                    </div>  
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <label for="select_party_list">Select Party List: <span class="required validation-area error_select_party_list">*</span></label>
                        <div class="input-group input-group-success">
                            <select id='select_party_list' class="form-control selectField" onclick="Pagination()"></select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="card">
                        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#new_platform" role="tab" aria-controls="pills-timeline" aria-selected="true">New Party List Platform</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-timeline-tab" data-toggle="pill" href="#display_platform" role="tab" aria-controls="pills-timeline" aria-selected="true">Display Party List Platform</a>

                               <!--  <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#display_platform" role="tab" aria-controls="pills-profile" aria-selected="false">Display Party List Platform</a> -->
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="new_platform" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                <div class="card-body">    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="platform_title">Platform Title: <span class="required validation-area error_platform_title">*</span></label>
                                            <input type="text" id="platform_title" class="form-control" name="platform_title" required />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="platform_content">Platform Content: <span class="required validation-area error_platform_content">*</span></label>
                                            <input type="text" id="platform_content" class="form-control" name="platform_content" required />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"><br>
                                             <button class="btn alert-success btn-medium" onclick="Save_Records()"><i class="ik ik-save"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="display_platform" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label>Search by: Generated Code, Name, Status <span class="validation-area"></span></label>
                                            <div class="input-group input-group-success">
                                              <input type="text" class="form-control" name="keyword"
                                              id="keyword"  size="22" placeholder="Generated Code, Name, Status"
                                              onkeyup="Pagination()">
                                              <span class="input-group-append">
                                                <label class="input-group-text" onclick="Pagination()"><i class="ik ik-search"></i></label>
                                              </span>
                                            </div>

                                          </div>  
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <span id="itemFrom" style="display: none;"></span>
                                            <span id="itemTo" style="display: none;"></span>

                                            <div id="divListOfAccounts"></div>
                                            <div class="divPagination w3-center"></div>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

<script type="text/javascript">
ComboBox_Party_List();
function ComboBox_Party_List(){
  var obj={"status":"Activated"};
  var parameter = JSON.stringify(obj); 
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#select_party_list").text("");
      $("#select_party_list").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_party_list/get_party_list_combo_box.php?data="+parameter, true);
  xmlhttp.send();
}

function Empty(){
  $("#platform_title").val("");
  $("#platform_content").val("");

  $(".error_platform_title").text("*");
  $(".error_platform_content").text("*");
}

function Empty2(){
  $("#update_platform_title").val("");
  $("#update_platform_content").val("");

  $(".error_update_platform_title").text("*");
  $(".error_update_platform_content").text("*");
}

function Save_Records(){
    if($("#platform_title").val() == "" || $("#platform_content").val() == ""){
      $(".error_platform_title").text("* Field is required");
      $(".error_platform_content").text("* Field is required");
  }else{
      $(".error_platform_title").text("*");
      $(".error_platform_content").text("*");

    var obj={"party_list_id":$("#select_party_list").val(),
        "party_list_platform_title":$("#platform_title").val(), 
        "party_list_platform_content":$("#platform_content").val()};
      var parameter = JSON.stringify(obj); 
      $.ajax({url:'tbl_party_list_platform/create_party_list_platform.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          showToast("Success", "Platform successfully saved !.", "success", "#f96868");
          Empty();
          Pagination();
        }
        else{
          showToast("Warning", "Saving of Platform was failed, Please try again !."+data, "warning", "#57c7d4");
          alert(data);
          Empty();
          Pagination();
        }
      },
      error:function(){
        showToast("Danger", "Registration went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        Empty();
        Pagination();
      }
    });//end of ajax  
  }//END OF IF Form_Validation()
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

// Pagination();
function Pagination(){
  GeneratePagination();
  DisplayInformation();
}

function GeneratePagination(){
$(".divPagination").text("");
var data = $("#keyword").val();
var obj = {"filter":data, "party_list_id": $("#select_party_list").val()};
var parameter = JSON.stringify(obj);
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
  var transactionCount = JSON.parse(this.responseText);
  
  $(".divPagination").text("");
  var totalItems=transactionCount;
  
  var perItem=5; 
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
xmlhttp.open("GET", "tbl_party_list_platform/count_party_list_platform.php?data="+parameter, true);
xmlhttp.send();
}

function Next(start, end){
  $("#itemFrom").text(start);
  $("#itemTo").text(end);
  DisplayInformation();
}

function DisplayInformation(){
  var start = $("#itemFrom").text();
  var end = $("#itemTo").text();
  var data = $("#keyword").val()
  var obj = {"filter":data,"start":start,"end":end, "party_list_id": $("#select_party_list").val()};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#divListOfAccounts").text("");
      $("#divListOfAccounts").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_party_list_platform/read_party_list_platform.php?data=" + parameter, true);
  xmlhttp.send();
}

function btnViewInformation(id){
  ToggleDIV("divViewProfile", "block");
  Displayinformation_ToModal(id);
}

function btnUpdateInformation(id){
Empty();
$("#btnUpdateRecord").val(id);
ToggleDIV("div_party_list_management", "block");

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].party_list_platform_id == id){
          $("#update_platform_title").val(data[index].party_list_platform_title);
          $("#update_platform_content").val(data[index].party_list_platform_content);
        break;
        }
      }
    }else{
    }
  };
  xmlhttp.open("GET", "tbl_party_list_platform/json_party_list_platform.php", true);
  xmlhttp.send();
}

function Update_Records(){
 if($("#update_platform_title").val() == "" || $("#update_platform_content").val() == ""){
      $(".error_update_platform_title").text("* Field is required");
      $(".error_update_platform_content").text("* Field is required");
  }else{
      $(".error_update_platform_title").text("*");
      $(".error_update_platform_content").text("*");

    var obj={"party_list_platform_id":$("#btnUpdateRecord").val(),
        "party_list_platform_title":$("#update_platform_title").val(), 
      "party_list_platform_content":$("#update_platform_content").val()};
      ToggleDIV("div_party_list_management", "none");
      var parameter = JSON.stringify(obj); 
      $.ajax({url:'tbl_party_list_platform/update_party_list_platform_information.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          showToast("Success", "Platform successfully updated !.", "success", "#f96868");
          Empty2();
          DisplayInformation();
        }
        else{
          showToast("Warning", "Updating of platform was failed, Please try again !.", "warning", "#57c7d4");
          Empty2();
          DisplayInformation();
        }
      },
      error:function(){
        showToast("Danger", "Registration went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        Empty2();
        DisplayInformation();
      }
    });//end of ajax  
  }//END OF IF Form_Validation()
}//END OF Submit_Registration


function btnChangeStatus(id){
  ToggleDIV("divUpdateStatus", "block");
  Displayinformation_ToModal(id);

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var data = JSON.parse(this.responseText);
    for(var index = 0; index < data.length; index++){
      if(data[index].party_list_platform_id == id){
        status(data[index].party_list_platform_status, id);
        break;
      }
    }
  }else{
  }
  };
  xmlhttp.open("GET", "tbl_party_list_platform/json_party_list_platform.php", true);
  xmlhttp.send();
}

function status(status, id){
  $("#divButtonStatus").text("");
  var changeStatus_PastTense = ["Activated", "Deactivated"];
  var changeStatus_PresentTense = ["Activate", "Deactivate"];
  var statusColor = ["btn btn-medium alert-success", "btn btn-medium alert-danger"];
  var statusIcon = ["ik ik-save", "ik ik-x"];

  for(var index = 0; index < changeStatus_PresentTense.length; index++){
    var w3disabled = disabled = "";
    if(status == changeStatus_PastTense[index]){
      w3disabled = "w3-disabled";
      disabled = "disabled";
    }
    $("#divButtonStatus").append("<button class='"+ w3disabled +" "+statusColor[index] + " btnIndex " + "' "+disabled+" onclick='UpdateAccessStatus("+id+",\""+changeStatus_PastTense[index]+"\")'>" +"<i class='"+statusIcon[index]+"'></i> " + changeStatus_PresentTense[index] +"</button>");
  }
}

function UpdateAccessStatus(id, status){
  var  obj = {"party_list_platform_id":id,"party_list_platform_status":status};
  var parameter = JSON.stringify(obj);
  ToggleDIV("divUpdateStatus", "none");
  $.ajax({url:'tbl_party_list_platform/update_party_list_platform_status.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
            showToast("Success", "Platform status successfully updated !.", "success", "#f96868");
            DisplayInformation();
        }
        else{
            showToast("Warning", "Updating platform status was failed, Please try again !."+data, "warning", "#57c7d4");
          DisplayInformation();
        }
      },
      error:function(){
        showToast("Danger", "Updating college program status went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        DisplayInformation();
      }
    });//end of ajax 
}

function Displayinformation_ToModal(id){
if(id!=0){
  $(".information").text("");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    $(".information").text("");
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].party_list_platform_id == id){

$(".information").append("<div class='row'><div class='col-12' style='text-align:center;'>"+data[index].party_list_platform_code_image+"</div></div>");
$(".information").append("<div class='row'><div class='col-12' style='text-align:center;'><b>"+data[index].party_list_platform_code+"</b></div></div>");

$(".information").append("<div class='row'><div class='col-12'><b>Platform Title:</b> "+ data[index].party_list_platform_title+"</div></div>");

$(".information").append("<div class='row'><div class='col-12'><b>Platform Content:</b> "+data[index].party_list_platform_content+"</div></div>");

$(".information").append("<div class='row'><div class='col-12'><br><b>Date & Time Encoded:</b> "+data[index].party_list_platform_created_at+"</div></div>");
$(".information").append("<div class='row'><div class='col-12'><b>Status:</b> "+data[index].party_list_platform_status+"</div></div>");
break;
        }
      }
    }else{
    $(".information").text("Loading...");
    }
  };
  xmlhttp.open("GET", "tbl_party_list_platform/json_party_list_platform.php", true);
  xmlhttp.send();
}
}

function ToggleDIV(id,status){
    document.getElementById(id).style.display=status;
}
</script>

<div id="divViewProfile" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Platform Details</h5>
                <button type="button" class="close" onclick="ToggleDIV('divViewProfile','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <span class="information" style="font-size: 14px;"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divViewProfile','none')">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="divUpdateStatus" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"> Change Platform Status</h5>
                <button type="button" class="close" onclick="ToggleDIV('divUpdateStatus','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                      <p class="information"></p>
                    </div>
                    <div class="col-lg-12">
                      <h4>Status</h4>
                      <div class="block clear" id="divButtonStatus"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divUpdateStatus','none')">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="div_party_list_management" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Platform Management</h5>
                <button type="button" class="close" onclick="ToggleDIV('div_party_list_management','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="update_platform_title">Platform Title: <span class="required validation-area error_update_platform_title">*</span></label>
                        <input type="text" id="update_platform_title" class="form-control" name="update_platform_title" required />
                    </div>
                    <div class="col-lg-12">
                        <label for="update_platform_content">Platform Content: <span class="required validation-area error_update_platform_content">*</span></label>
                        <input type="text" id="update_platform_content" class="form-control" description="update_platform_content" required />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('div_party_list_management','none')">Close</button>
        
                <button class="btn alert-warning" id="btnUpdateRecord" onclick="Update_Records()"><i class="ik ik-save"></i> Update</button>
            </div>
        </div>
    </div>
</div>
        <?php include("includes/main_footer.php"); ?>  
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>