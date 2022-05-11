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
                                <h5>Display Votes</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>

                    </div>  
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <label for="select_college_program">Select College Program: <span class="required validation-area error_select_college_program">*</span></label>
                        <div class="input-group input-group-success">
                            <select id='select_college_program' class="form-control selectField" onclick="Display_Votes()"></select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <label for="select_voting_program">Select Voting Program: <span class="required validation-area error_select_voting_program">*</span></label>
                        <div class="input-group input-group-success">
                            <select id='select_voting_program' class="form-control selectField" onclick="Display_Votes()"></select>
                            <span class="input-group-append">
                                <label class="input-group-text" onclick="Display_Votes()"><i class="ik ik-search"></i></label>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#vote_summary" role="tab" aria-controls="pills-timeline" aria-selected="true">Vote Sumary</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-timeline-tab" data-toggle="pill" href="#student_votes" role="tab" aria-controls="pills-timeline" aria-selected="true">Student Votes</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="vote_summary" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                    <div class="card-body">  
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div id="divListOfVotes"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade show" id="student_votes" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                    <div class="card-body">  
                                        <div class="row">

                                          <div class="col-lg-12">
                                            <label>Search by: Student Name <span class="validation-area"></span></label>
                                            <div class="input-group input-group-success">
                                              <input type="text" class="form-control" name="keyword"
                                              id="keyword"  size="22" placeholder="Student Name"
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
                            </div>


                        </div>                       
                    </div>
                </div>

            </div>
        </div>

<script type="text/javascript">
ComboBox_Voting_Program();
function ComboBox_Voting_Program(){
  var obj={"status":"All"};
  var parameter = JSON.stringify(obj); 
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#select_voting_program").text("");
      $("#select_voting_program").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_voting_program/get_voting_program_combo_box.php?data="+parameter, true);
  xmlhttp.send();
}

ComboBox_College_Program();
function ComboBox_College_Program(){
  var obj={"status":"All"};
  var parameter = JSON.stringify(obj); 
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#select_college_program").text("");
      $("#select_college_program").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_college_program/get_college_program_combo_box.php?data="+parameter, true);
  xmlhttp.send();
}

function Display_Votes(){
  if($("#select_voting_program").val() == "" || $("#select_college_program").val() == ""){
    $(".error_select_voting_program").text("* Field is required.");
    $(".error_select_college_program").text("* Field is required.");
  }else{
    Pagination();
      var obj={"voting_program_id":$("#select_voting_program").val(),
          "college_program_id":$("#select_college_program").val()};
      var parameter = JSON.stringify(obj); 
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        $("#divListOfVotes").text("");
        $("#divListOfVotes").append(this.responseText);
      }else{
     
      }
    };
    xmlhttp.open("GET", "tbl_Votes/read_votes.php?data="+parameter, true);
    xmlhttp.send();    
  }
}

function Pagination(){
  GeneratePagination();
  DisplayStudentVotes();
}

function GeneratePagination(){
$(".divPagination").text("");
var data = $("#keyword").val();
var obj = {"filter":data,"voting_program_id":$("#select_voting_program").val(),
        "college_program_id":$("#select_college_program").val()};
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
xmlhttp.open("GET", "tbl_Votes/count_student_votes.php?data="+parameter, true);
xmlhttp.send();
}

function Next(start, end){
  $("#itemFrom").text(start);
  $("#itemTo").text(end);
  DisplayStudentVotes();
}

function DisplayStudentVotes(){
  var start = $("#itemFrom").text();
  var end = $("#itemTo").text();
  var data = $("#keyword").val()
  var obj = {"filter":data,"start":start,"end":end,"voting_program_id":$("#select_voting_program").val(),
        "college_program_id":$("#select_college_program").val()};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#divListOfAccounts").text("");
      $("#divListOfAccounts").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_Votes/read_student_votes.php?data=" + parameter, true);
  xmlhttp.send();
}


</script>
        <?php include("includes/main_footer.php"); ?>  
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>