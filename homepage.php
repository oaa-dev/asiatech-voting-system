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
                                <h5>Homepage</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>

                    </div>  
                </div>

                <?php if($_SESSION['userTypeId'] == 1){ ?>
                <div class="row">
                    <div class="col-lg-4">
                        <div id="administrator"></div>
                        
                    </div>
                    <div class="col-lg-4">
                        <div id="staff"></div>
                    </div>
                    <div class="col-lg-4">
                        <div id="students"></div>
                    </div>
                </div>
                <?php } ?>

                <div class="row">
                    <div class="col-lg-12">
                        <div id="divPartyListToVote"></div>
                    </div>
                </div>
            </div>
        </div>

<?php if($_SESSION['userTypeId'] == 1){ ?>
<script type="text/javascript">
DisplayCount(1, "#administrator");
DisplayCount(2, "#staff");
DisplayCount(3, "#students");
function DisplayCount(id, page){
  var obj = {"userType":id};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $(page).text("");
      $(page).append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_accounts/dashboard_person_per_usertype_count.php?data=" + parameter, true);
  xmlhttp.send();
}
</script>
<?php } ?>

<script type="text/javascript">
DisplayPartyListToVote();
function DisplayPartyListToVote(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#divPartyListToVote").text("");
      $("#divPartyListToVote").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_party_list/dashboard_read_party_list_to_vote.php", true);
  xmlhttp.send();
}
</script>
        <?php include("includes/main_footer.php"); ?>  
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