<div class="row">
  <div class="col-lg-12"><br>
    <h6><b>PERSONAL INFORMATION</b></h6>
  </div>
</div>

<div class="row">
  <div class="col-lg-3">
    <label for="first_name">First Name: <span class="required validation-area error_first_name">*</span></label>
    <input type="text" id="first_name" class="form-control" name="first_name" required />
  </div>
  <div class="col-lg-3">
    <label for="middle_name">Middle Name: (Optional) <span class="required validation-area error_middle_name"></span></label>
    <input type="text" id="middle_name" class="form-control" name="middle_name" required />
  </div>
  <div class="col-lg-3">
    <label for="last_name">Last Name: <span class="required validation-area error_last_name">*</span></label>
    <input type="text" id="last_name" class="form-control" name="last_name" required />
  </div>
  <div class="col-lg-3">
    <label for="affiliation_name">Affiliation: (Optional) <span class="required validation-area error_affiliation_name"></span></label>
    <select class="selectField form-control" id="affiliation_name" name="affiliation_name">
      <option value="NA">N/A</option>
      <option value="Sr">Sr.</option>
      <option value="Jr">Jr.</option>
      <option value="II">II</option>
      <option value="III">III</option>
      <option value="IV">IV</option>
    </select>

    <!-- <input type="text" id="affiliation_name" class="form-control" name="affiliation_name" required /> -->
  </div>
</div>

<div class="row">
  <div class="col-lg-4">
    <label for="date_of_birth">Date of Birth: <span class="required validation-area error_date_of_birth">*</span></label>
    <input type="date" id="date_of_birth" class="form-control" name="date_of_birth" required />
  </div>
  <div class="col-lg-4">
    <label for="select_sex">Sex: <span class="required validation-area error_select_sex">*</span></label>
    <select class="selectField form-control" id="select_sex" name="select_sex">
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>
  </div>
  <div class="col-lg-4">
    <label for="select_civil_status">Civil Status: <span class="required validation-area error_select_civil_status">*</span></label>
    <select class="selectField form-control" id="select_civil_status" name="select_civil_status">
      <option value="Single">Single</option>
      <option value="Married">Married</option>
      <option value="Widowed">Widowed</option>
      <option value="Separated">Separated</option>
      <option value="Divorced">Divorced</option>
    </select>
  </div>
</div>

<div class="row">
  <div class="col-lg-12"><br>
    <h6><b>HOME ADDRESS</b></h6>
  </div>
</div>

<div class="row">
  <div class="col-lg-3">
    <label for="select_region">Region: <span class="required validation-area error_select_region">*</span></label>
    <select class="selectField form-control" id="select_region" name="select_region" onclick="Choose_Province()"></select>
  </div>
  <div class="col-lg-3">
    <label for="select_province">Province: <span class="required validation-area error_select_province">*</span></label>
    <select class="selectField form-control" id="select_province" name="select_province" onclick="Choose_Municipality()"></select>
  </div>
  <div class="col-lg-3">
    <label for="select_city">City: <span class="required validation-area error_select_city">*</span></label>
    <select class="selectField form-control" id="select_city" name="select_city" onclick="Choose_Barangay()"></select>
  </div>
  <div class="col-lg-3">
    <label for="select_barangay">Barangay: <span class="required validation-area error_select_barangay">*</span></label>
    <select class="selectField form-control" id="select_barangay" name="select_barangay"></select>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <label for="house_number">House Number: <span class="required validation-area error_house_number">*</span></label>
    <input type="text" id="house_number" class="form-control" name="house_number" required />
  </div>
  <div class="col-lg-6">
    <label for="street_number">Street Number: <span class="required validation-area error_street_number">*</span></label>
    <input type="text" id="street_number" class="form-control" name="street_number" required />
  </div>
</div>

<div class="row">
  <div class="col-lg-12"><br>
    <h6><b>CONTACT DETAILS</b></h6>
  </div>
</div>

<div class="row">
  <div class="col-lg-4">
    <label for="email_user_name">Email / Username: <span class="required validation-area error_email_user_name">*</span></label>
    <input type="text" id="email_user_name" class="form-control" name="email_user_name" required />
  </div>
  <div class="col-lg-4">
    <label for="contact_number">Contact Number (Phone): <span class="required validation-area error_contact_number">*</span></label>
    <input type="text" id="contact_number" class="form-control" name="contact_number" required />
  </div>
  <div class="col-lg-4">
    <label for="telephone_number">Telephone Number (Optional): <span class="required validation-area error_telephone_number"></span></label>
    <input type="text" id="telephone_number" class="form-control" name="telephone_number" required />
  </div>
</div>

<script type="text/javascript">
var jsonAddress="";
var region_number=[];
var region=[];
var province=[];
var provinces = {};
var city=[];
var cities = [];
var barangay=[];
var brgy = [];
var addresses = [];

loadRegion();
function loadRegion(){
  var xobj = new XMLHttpRequest();
      xobj.overrideMimeType("application/json");
      xobj.open("GET", "assets/json/address.json", true);

  xobj.onreadystatechange = function()      {
    if(xobj.readyState==4 && xobj.status=="200"){
      jsonAddress = JSON.parse(xobj.responseText);
      addresses = Object.values(jsonAddress);
      for(var x = 0; x < addresses.length;x++){
        region_number.push(addresses[x].region_name);
      }
        console.log(region_number);
      for(var index=0; index<region_number.length; index++){
        $("#select_region").append("<option value='"+region_number[index]+"'>"+region_number[index]+"</option>")
      //   region.push(jsonAddress[region_number[index]]["region_name"]);
      }
      console.log(Object.values(jsonAddress));
    }
  };
  xobj.send();
}

function Choose_Province() {
  $("#select_province").text("");
  var selected_region=$("#select_region").val();
  for(var index=0; index<region_number.length; index++){ 
    if(addresses[index].region_name == selected_region){
      province = Object.keys(addresses[index].province_list);
      provinces = Object.values(addresses[index].province_list);
      for(var x = 0; x < province.length;x++){
         $("#select_province").append("<option value='"+province[x]+"'>"+province[x]+"<//option>")
      }
      Choose_Municipality();
      Choose_Barangay();
    }
  }
}

function Choose_Municipality() {
  $("#select_city").text("");
  var selected_province=$("#select_province").val();
  for(var index=0; index<province.length; index++){
    if(province[index] == selected_province){    
      city = Object.keys(provinces[index].municipality_list);
      cities = Object.values(provinces[index].municipality_list);
      for(var x = 0; x < city.length;x++){
         $("#select_city").append("<option value='"+city[x]+"'>"+city[x]+"<//option>")
      }
      Choose_Barangay();
    }
  }
}

function Choose_Barangay() {
  $("#select_barangay").text("");
  var selected_city=$("#select_city").val();
  for(var index=0; index<city.length; index++){
    if(city[index] == selected_city){    
      barangay = cities[index].barangay_list;
      for(var x = 0; x < barangay.length;x++){
         $("#select_barangay").append("<option value='"+barangay[x]+"'>"+barangay[x]+"<//option>")
      }
    }
  }
}
</script>