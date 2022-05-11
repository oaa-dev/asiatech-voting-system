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
                                <h5>New Candidate</h5>
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
                            <span class="input-group-append">
                                <label class="input-group-text" onclick="Pagination()"><i class="ik ik-search"></i></label>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="card">
                        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#new_candidate" role="tab" aria-controls="pills-timeline" aria-selected="true">New Cadidate</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-timeline-tab" data-toggle="pill" href="#display_candidate" role="tab" aria-controls="pills-timeline" aria-selected="true">Display Cadidate</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="new_candidate" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                <div class="card-body">  
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <p class="party_list_info"></p>
                                    </div>
                                  </div>
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
                                      <div class="col-lg-12">
                                        <span id="itemFrom" style="display: none;"></span>
                                        <span id="itemTo" style="display: none;"></span>

                                        <div id="divListOfAccounts"></div>
                                        <div class="divPagination w3-center"></div>
                                      </div>
                                    </div>  
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="display_candidate" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                <div class="card-body">
                                    <div class="row">
                                      <div class="col-lg-12">
                                        <p class="party_list_info"></p>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                        <label>Search by: Candidate Position<span class="validation-area"></span></label>
                                        <div class="input-group input-group-success">
                                          <input type="text" class="form-control" name="keyword_Candidate"
                                          id="keyword_Candidate"  size="22" placeholder="Candidate Position"
                                          onkeyup="Pagination_Candidate()">
                                          <span class="input-group-append">
                                            <label class="input-group-text" onclick="Pagination_Candidate()"><i class="ik ik-search"></i></label>
                                          </span>
                                        </div>
                                      </div>
                                      <div class="col-lg-12">
                                        <span id="itemFrom_Candidate" style="display: none;"></span>
                                        <span id="itemTo_Candidate" style="display: none;"></span>

                                        <div id="divListOfAccounts_Candidate"></div>
                                        <div class="divPagination_Candidate w3-center"></div>
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


function Pagination(){
  DisplayPartyListInformation($("#select_party_list").val());
  GeneratePagination();
  DisplayData();
  Pagination_Candidate();
}

function GeneratePagination(){
$(".divPagination").text("");
var data = $("#keyword").val();
var userTypeId = 3;
var obj = {"filter":data,"userType":userTypeId};
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
xmlhttp.open("GET", "tbl_accounts/count_student.php?data="+parameter, true);
xmlhttp.send();
}

function Next(start, end){
  $("#itemFrom").text(start);
  $("#itemTo").text(end);
  DisplayData();
}

function DisplayData(){
  var start = $("#itemFrom").text();
  var end = $("#itemTo").text();
  var data = $("#keyword").val()
  var userTypeId = 3;
  var obj = {"filter":data, "userType":userTypeId,"start":start,"end":end};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#divListOfAccounts").text("");
      $("#divListOfAccounts").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_accounts/read_student.php?data=" + parameter, true);
  xmlhttp.send();
}

function btnAddToPartyList(person_program_id, person_id){
  if($("#select_party_list").val() == ""){
    $(".error_select_party_list").text("* Please select a party list.");
  }else{
    $(".error_select_party_list").text("*");
    
    ToggleDIV("divAssignStudent", "block");
    $("#btnSave").val(person_program_id);
    ComboBox_Candidate_Position();
    DisplayPartyListInformation($("#select_party_list").val());
    DisplayPersonInformation_ToModal(person_id);
  }
}

function DisplayPersonInformation_ToModal(id){
if(id!=0){
  $(".personInformation").text("");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    $(".personInformation").text("");
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].person_id == id){

$(".personInformation").append("<div class='row'><div class='col-12'><b>Name:</b> "+data[index].last_name + ", " + data[index].first_name + " " + data[index].middle_name + " " + data[index].affiliation_name+"</div></div>");

$(".personInformation").append("<div class='row'><div class='col-12'><b>Date of Birth:</b> "+data[index].date_of_birth+"</div><div class='col-12'><b>Sex:</b> "+data[index].sex+"</div><div class='col-12'><b>Civil Status:</b> "+data[index].civil_status+"</div></div>");

$(".personInformation").append("<div class='row'><div class='col-12'><b>Address:</b> "+data[index].house_no+" "+data[index].street+","+data[index].barangay+", "+data[index].city+", "+data[index].province+", "+data[index].region);

break;
        }
      }
    }else{
    $(".personInformation").text("Loading...");
    }
  };
  xmlhttp.open("GET", "tbl_accounts/json_account.php", true);
  xmlhttp.send();
}
}

function DisplayPartyListInformation(id){
if(id!=0){
  $(".party_list_info").text("");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    $(".party_list_info").text("");
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].party_list_id == id){


$(".party_list_info").append("<div class='row'><div class='col-12'><b>Party List Name:</b> "+ data[index].party_list_name+"</div></div>");

$(".party_list_info").append("<div class='row'><div class='col-12'><b>Party List Description:</b> "+data[index].party_list_description+"</div></div>");
break;
        }
      }
    }else{
    $(".party_list_info").text("Loading...");
    }
  };
  xmlhttp.open("GET", "tbl_party_list/json_party_list.php", true);
  xmlhttp.send();
}
}

function Save_Records(){
 if($("#select_candidate_position").val() == ""){
  $(".error_select_candidate_position").text("* Field is required");
}else{
  $(".error_select_candidate_position").text("*");

if($("#position_remarks").val() == ""){
  $(".error_position_remarks").text("* Field is required");
}else{
  $(".error_position_remarks").text("*");

  var obj={"person_program_id":$("#btnSave").val(), 
  "candidate_position_id":$("#select_candidate_position").val(),
      "party_list_id":$("#select_party_list").val(), 
      "person_candidate_party_list_remarks":$("#position_remarks").val()};
      var parameter = JSON.stringify(obj); 
      ToggleDIV("divAssignStudent", "none");
      $.ajax({url:'tbl_candidate_party_list/create_candidate_party_list.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          showToast("Success", "Student position successfully saved !.", "success", "#f96868");
          DisplayData();
          Pagination_Candidate();
        }
        else{
          if(data == "Existed"){
            showToast("Warning", "Position is already exist on this party list", "warning", "#57c7d4");
            DisplayData();
            Pagination_Candidate();
          }else{
            showToast("Warning", "Saving of student position was failed, Please try again !."+data, "warning", "#57c7d4");
            DisplayData();
            Pagination_Candidate();

          }
        }
      },
      error:function(){
        showToast("Danger", "Registration went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        DisplayData();
        Pagination_Candidate();
      }
    });//end of ajax
}
}
}

function Pagination_Candidate(){
  GeneratePagination_Candidate();
  DisplayData_Candidate();
}

function GeneratePagination_Candidate(){
$(".divPagination_Candidate").text("");
var data = $("#keyword_Candidate").val();
var userTypeId = 3;
var obj = {"filter":data,"party_list_id":$("#select_party_list").val()};
var parameter = JSON.stringify(obj);
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
  var transactionCount = JSON.parse(this.responseText);
  
  $(".divPagination_Candidate").text("");
  var totalItems=transactionCount;
  
  var perItem=5; 
  var paginator = totalItems/perItem;
  var textCounter=0;
  var start=1;
  var end=perItem;
  Next_Candidate(start, end);
  for(var index=0; index<paginator; index++){
    textCounter++;
    $(".divPagination_Candidate").append("<button class='btn alert-success btnPagination' onclick=\"Next_Candidate("+start+","+end+")\">"+(index+1)+"</button> ");
    start+=perItem;
    end+=perItem;
  }
}//end of if
};
xmlhttp.open("GET", "tbl_candidate_party_list/count_candidate_party_list.php?data="+parameter, true);
xmlhttp.send();
}

function Next_Candidate(start, end){
  $("#itemFrom_Candidate").text(start);
  $("#itemTo_Candidate").text(end);
  DisplayData_Candidate();
}

function DisplayData_Candidate(){
  var start = $("#itemFrom_Candidate").text();
  var end = $("#itemTo_Candidate").text();
  var data = $("#keyword_Candidate").val()
  var userTypeId = 3;
  var obj = {"filter":data, "party_list_id":$("#select_party_list").val(),"start":start,"end":end};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#divListOfAccounts_Candidate").text("");
      $("#divListOfAccounts_Candidate").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_candidate_party_list/read_candidate_party_list.php?data=" + parameter, true);
  xmlhttp.send();
}

function btnChangeStatus(id){
  ToggleDIV("divUpdateStatus", "block");
  DisplayCandidatePartyList_Modal(id);

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var data = JSON.parse(this.responseText);
    for(var index = 0; index < data.length; index++){
      if(data[index].person_candidate_party_list_id == id){
        status(data[index].person_candidate_party_list_status, id);
        break;
      }
    }
  }else{
  }
  };
  xmlhttp.open("GET", "tbl_candidate_party_list/json_candidate_party_list.php", true);
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
  var  obj = {"person_candidate_party_list_id":id,"person_candidate_party_list_status":status};
  var parameter = JSON.stringify(obj);
  ToggleDIV("divUpdateStatus", "none");
  $.ajax({url:'tbl_candidate_party_list/update_candidate_party_list_status.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
            showToast("Success", "Candidate position party list status successfully updated !.", "success", "#f96868");
            DisplayData_Candidate();
        }
        else{
            showToast("Warning", "Updating cndidate position party list status was failed, Please try again !."+data, "warning", "#57c7d4");
          DisplayData_Candidate();
        }
      },
      error:function(){
        showToast("Danger", "Updating college program status went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        DisplayData_Candidate();
      }
    });//end of ajax 
}


function DisplayCandidatePartyList_Modal(id){
if(id!=0){
  $(".candidate_party_list_information").text("");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    $(".candidate_party_list_information").text("");
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].person_candidate_party_list_id == id){

$(".candidate_party_list_information").append("<div class='row'><div class='col-12' style='text-align:center;'>"+data[index].person_candidate_party_list_code_image+"</div></div>");
$(".candidate_party_list_information").append("<div class='row'><div class='col-12' style='text-align:center;'><b>"+data[index].person_candidate_party_list_code+"</b></div></div>");


$(".candidate_party_list_information").append("<div class='row'><div class='col-12'><br><b>Date & Time Encoded:</b> "+data[index].person_candidate_party_list_created_at+"</div></div>");
$(".candidate_party_list_information").append("<div class='row'><div class='col-12'><b>Status:</b> "+data[index].person_candidate_party_list_status+"</div></div>");
break;
        }
      }
    }else{
    $(".candidate_party_list_information").text("Loading...");
    }
  };
  xmlhttp.open("GET", "tbl_candidate_party_list/json_candidate_party_list.php", true);
  xmlhttp.send();
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

<div id="divAssignStudent" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:800px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Assign Student to a Party List and Position</h5>
                <button type="button" class="close" onclick="ToggleDIV('divAssignStudent','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h5><b>Party List Information</b></h5>
                        <span class="party_list_info" style="font-size: 14px;"></span><br>
                        <h5><b>Student Information</b></h5>
                        <span class="personInformation" style="font-size: 14px;"></span>
                    </div>
                    <div class="col-lg-6">
                        <label for="select_candidate_position">Select Candidate Position: <span class="required validation-area error_select_candidate_position">*</span></label>
                        <div class="input-group input-group-success">
                            <select id='select_candidate_position' class="form-control selectField"></select>
                            <span class="input-group-append">
                                <label class="input-group-text"><i class="ik ik-search"></i></label>
                            </span>
                        </div>
                        
                        <label for="position_remarks">Remarks: <span class="required validation-area error_position_remarks">*</span></label>
                        <input type="text" id="position_remarks" class="form-control" name="position_remarks" required />

                        <div><br>
                            <button class="btn alert-info" id="btnSave" onclick="Save_Records()"><i class="ik ik-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divAssignStudent','none')">Close</button>
            </div>
        </div>
    </div>
</div>


<div id="divUpdateStatus" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"> Change Party List Status</h5>
                <button type="button" class="close" onclick="ToggleDIV('divUpdateStatus','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                      <p class="candidate_party_list_information"></p>
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

        <?php include("includes/main_footer.php"); ?>  
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>