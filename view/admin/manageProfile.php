<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add/Manage Profile
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Master</a></li>
        <li class="active">Manage Profile</li>
      </ol>
    </section>
    <style>
        .form-group label{
          color: #00000094!important;  
        }
        .occuDetail,.married{
            display: none;
        }
    </style>
    <!-- Main content -->
    <section class="content container-fluid" onload="updateSize();">
        
        <?php
        if($response[0]=="edit"){$action="updateprofile";$btn="Update Profile";}else{$action="addprofile";$btn="Add Profile";}
        ?>
        <form id="myform" method="post" action="<?php echo ADMIN_URL.$action ?>" autocomplete="off" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="box <?php echo $col ?>">
                        <div class="box-header" style="background: #FFE4E1;padding: 1px 0px 0px 23px;">
                            <h4 style="font-weight: 600;"><?php echo "Manage Profile"; ?></h4>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"  data-widget="collapse"><i style="font-size: 26px; color: red;" class="<?php echo $fa ?>"></i></button>
                            </div>
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            <div class="row">
                                <?php 
                                if(!empty($response[2])){
                                    $edit = $this->db_read($response[2]);
                                }
                                ?>
                            </div>
                            <fieldset>  
                                <legend>Personal Detail</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control required" value="<?php echo $edit['name'] ?>" name="ProfileName" id="ProfileName" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Gender</label><br>
                                                <input type="radio" name="gender" id="Male" <?php echo ($edit['gender']=="Male" || $edit['gender']=="")?"checked":""; ?> value="Male"> 
                                                <label for="Male">Male&nbsp;&nbsp;</label>
                                            <label>
                                                <input type="radio" name="gender" id="Female" <?php echo ($edit['gender']=="Female")?"checked":""; ?> value="Female">
                                            <label for="Female">Female&nbsp;&nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>DOB</label>
                                            <input type="text" class="form-control date" value="<?php echo ($edit['dob']=="")?$this->formatDate("-18 year","d/m/Y"):$this->formatDate($edit['dob'],"d/m/Y") ?>" name="dob" id="dob" readonly="true">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Marital Status</label><br>
                                            <input type="radio" name="mstatus" <?php echo ($edit['mstatus']=="Unmarried" || $edit['mstatus']=="")?"checked":""; ?> id="Unmarried" value="Unmarried" onchange=" mstatusActions(this)"> 
                                                <label for="Unmarried">Unmarried&nbsp;&nbsp;</label>
                                           
                                                <input type="radio" name="mstatus" <?php echo ($edit['mstatus']=="Married")?"checked":""; ?> id="Married" value="Married" onchange=" mstatusActions(this)">
                                            <label for="Married">Married&nbsp;&nbsp;</label>
                                                <input type="radio" name="mstatus" <?php echo ($edit['mstatus']=="Divorced")?"checked":""; ?> id="Divorced" value="Divorced" onchange=" mstatusActions(this)">
                                            <label for="Divorced">Divorced&nbsp;&nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Caste</label>
                                        <?php
                                        $sel = ($edit['caste']!="")?$edit['caste']:"Jain";
                                        echo $this->getCasteOptions("caste","caste","form-control required","Select Caste","$sel","str");
                                        ?>    
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Sub Caste</label>
                                            <input type="text" class="form-control" value="<?php echo $edit['subcaste'] ?>" name="subcaste" id="subcaste">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Login Detail</legend>
                                <div class="row">        
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Login Id</label>
                                            <input type="text" class="form-control required" value="<?php echo $edit['LoginID'] ?>" onkeypress=" return false;" name="loginid" id="loginid" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Password</label>
                                            <input type="text" class="form-control required" value="<?php echo $edit['password'] ?>"   name="password" id="password">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>  
                            <fieldset> 
                                <legend>Contact Detail</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control required" onKeyPress="return validemail(event);" value="<?php echo $edit['email'] ?>" name="email" id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label> Mobile  No.</label>
                                            <input type="text" class="form-control required" value="<?php echo $edit['mobile'] ?>"  onKeyPress="return isNumberKey(event);" maxlength="10" minlength="10" name="Mobileno" id="Mobileno">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class=" form-group">
                                            <label>STD Code </label>
                                            <input type="text" class="form-control" value="<?php echo $edit['stdcode'] ?>" onKeyPress="return isNumberKey(event);" maxlength="6" name="STDcode" id="STDcode">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class=" form-group">
                                            <label> Land-Line No.</label>
                                            <input type="text" class="form-control" value="<?php echo $edit['phone'] ?>" onKeyPress="return isNumberKey(event);" maxlength="7" name="Landline" id="Landline">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label> Pin Code</label>
                                            <input type="text" class="form-control required" onKeyPress="return isNumberKey(event);" value="<?php echo $edit['pincode'] ?>" maxlength="6" name="PINcode" id="PINcode">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>City</label>
                                        <?php
                                        $sel = ($edit['city']!="")?$edit['city']:"Jabalpur";
                                        $loc = $this->db_executeSingle("area", "id","AreaName='".$this->strip($edit['location'])."'");
                                        echo $this->getCityOptions("city","city","form-control required","Select City","$sel","str","onchange='loadAreaByCity(this)'");
                                        ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Location</label>
                                            <select class=" form-control required" name="area" id="area">
                                                <option value="0">Select Location</option>
                                            </select>   
                                        </div>
                                    </div>
                                </div>
                                
                            </fieldset>
                            <fieldset>
                                <legend>Education/Occupation Detail</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Education</label>
                                        <?php
                                        //$educ = $this->db_executeSingle("education", "Eduid","Education='".$this->strip($edit['edu'])."'");
                                        echo $this->getEduOptions("educ","educ","form-control required","Select Education",$edit['edu'],"str");
                                        ?> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Occupation</label><br>
                                            <input type="radio" name="occu" <?php echo ($edit['occu']=="Govt Job" || $edit['occu']=="")?"checked":""; ?> id="Govt" value="Govt Job" onchange="getOccuDetails(this.value)"> 
                                         
                                            <label for="Govt">Govt Job&nbsp;&nbsp;</label>
                                                <input type="radio" name="occu" <?php echo ($edit['occu']=="Private Job")?"checked":""; ?> id="Private" value="Private Job" onchange="getOccuDetails(this.value)">
                                            <label for="Private">Private Job&nbsp;&nbsp;</label>
                                                <input type="radio" name="occu" <?php echo ($edit['occu']=="Business")?"checked":""; ?> id="Business" value="Business" onchange="getOccuDetails(this.value)">
                                            <label for="Business">Business&nbsp;&nbsp;</label>
                                                <input type="radio" name="occu" <?php echo ($edit['occu']=="Professional")?"checked":""; ?> id="Professional" value="Professional" onchange="getOccuDetails(this.value)">
                                            <label for="Professional">Professional&nbsp;&nbsp;</label>
                                                <input type="radio" name="occu" <?php echo ($edit['occu']=="Not Working")?"checked":""; ?> id="Not" value="Not Working" onchange="getOccuDetails(this.value)">
                                            <label for="Not">Not Working&nbsp;&nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                               <div class="row">  
                                   <div class="occuDetail job" style="display: block;">
                                        <div class="col-md-6">
                                            <div class=" form-group">
                                                <label>Name of Organization</label>
                                                <input class="form-control ocu required" type="text" name="orgni" id="orgni" value="<?php echo $edit['o_organi'] ?>" placeholder="Name of Organization">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class=" form-group">
                                                <label>Designation</label>
                                                <input class="form-control ocu required" type="text" name="desig" id="desig" value="<?php echo $edit['o_design'] ?>" placeholder="Designation">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class=" form-group">
                                                <label>Office Address</label>
                                                <input class="form-control ocu required" type="text" name="off_addr" id="off_addr" value="<?php echo $edit['o_address'] ?>" placeholder="Office Address">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class=" form-group">
                                                <label>Office Contact Number</label>
                                                <input class="form-control ocu required" type="text" name="off_cont" id="off_cont"  value="<?php echo $edit['o_contact'] ?>" placeholder="Office Contact Number">
                                            </div>
                                        </div>
                                    </div>
                               
                                <div class="occuDetail Business">
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Name of Organization</label>
                                            <input class="form-control ocu" type="text" name="orgni_b" id="orgni_b" value="<?php echo $edit['o_organi'] ?>" placeholder="Name of Organization">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Area</label>
                                            <input class="form-control ocu"type="text" name="area_b" id="area_b" value="<?php echo $edit['o_area'] ?>" placeholder="Area">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Address</label>
                                            <input class="form-control ocu" type="text" name="off_addr_b" id="off_addr_b" value="<?php echo $edit['o_address'] ?>" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Office Contact Number</label>
                                            <input class="form-control ocu" type="text" name="off_cont_b" id="off_cont_b" onKeyPress="return isNumberKey(event);" value="<?php echo $edit['o_contact'] ?>" placeholder="Office Contact Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Web-Site</label>
                                            <input class="form-control ocu" type="text" name="off_web_b" id="off_web_b"  value="<?php echo $edit['o_web'] ?>" placeholder="Business Web-Site">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Email</label>
                                            <input class="form-control ocu" type="text" name="email_b" id="email_b" onKeyPress="return validemail(event);" value="<?php echo $edit['o_email'] ?>" placeholder="Office Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Establishment Type</label>
                                            <select class="form-control ocu" name="estab_b" id="estab_b" >
                                                <option value="0">Select Establishment Type</option>
                                                <option value="Manufacturing Unit">Manufacturing Unit</option>
                                                <option value="Trading">Trading</option>
                                                <option value="Service Provider">Service Provider</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="occuDetail Professional">
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Sector</label>
                                            <input class="form-control  ocu" type="text" name="sec_p" id="sec_p" value="<?php echo $edit['o_sector'] ?>" placeholder="Sector Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Profession Name</label>
                                            <input class="form-control  ocu" type="text" name="profname" id="profname" value="<?php echo $edit['o_prof'] ?>" placeholder="Profession Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Area</label>
                                            <input class="form-control  ocu" type="text" name="area_p" id="area_p" value="<?php echo $edit['o_area'] ?>" placeholder="Area">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Office Address</label>
                                            <input class="form-control  ocu" type="text" name="off_addr_p" id="off_addr_p" value="<?php echo $edit['o_address'] ?>" placeholder="Office Address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Office Contact Number</label>
                                            <input class="form-control ocu" type="text" name="off_cont_p" id="off_cont_p" onKeyPress="return isNumberKey(event);" value="<?php echo $edit['o_contact'] ?>" placeholder="Office Contact Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Web-Site</label>
                                            <input class="form-control ocu" type="text" name="off_web_p" id="off_web_p"  value="<?php echo $edit['o_web'] ?>" placeholder="Web-Site">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Email</label>
                                            <input class="form-control ocu" type="text" name="email_p" id="email_p" onKeyPress="return validemail(event);" value="<?php echo $edit['o_email'] ?>" placeholder="Office Email">
                                        </div>
                                    </div>
                                </div>
                               
                                </div>     
                            </fieldset>
                            <fieldset>
                                <legend>Family Detail</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Father's Name</label>
                                            <input class="form-control required" type="text" name="fname" id="fname" onKeyPress="return isAlphaOnly(event);" value="<?php echo stripslashes($edit['fname']) ?>" placeholder="Father's Name">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Father's DOB</label>
                                            <input class="form-control date  required" type="text" name="fage" id="fage" onKeyPress="return false;" value="<?php echo  ($edit['fdob']=="")?$this->formatdate("-30 year","d/m/Y"):$this->formatdate($edit['fdob'],"d/m/Y") ?>" placeholder="Father's DOB">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Mother's Name</label>
                                            <input class="form-control  required" type="text" name="mname" id="mname" onKeyPress="return isAlphaOnly(event);" value="<?php echo stripslashes($edit['mname']) ?>" placeholder="Mother's Name">  
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Mother's DOB</label>
                                            <input class="form-control date  required" type="text" name="mage" id="mage" onKeyPress="return false;" value="<?php echo  ($edit['mdob']=="")?$this->formatdate("-30 year","d/m/Y"):$this->formatdate($edit['mdob'],"d/m/Y") ?>" placeholder="Mother's DOB">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Brother</label>
                                            <select class="form-control" name="brother" id="brother" >
                                                <option value="0">Select Number of Brothers</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>More Than 4</option>
                                            </select>
                                        </div>
                                    </div>    
                                    <div class="col-md-6">    
                                        <div class=" form-group">
                                            <label>Sister</label>
                                            <select class="form-control" name="sister" id="sister" >
                                                <option value="0">Select Number of Sisters</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>More Than 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-md-6 no-padding">
                                        <div class="col-md-6 married">    
                                            <div class=" form-group">
                                                <label>Son</label>
                                                <select class="form-control" name="son" id="son" onchange=" unMarriedSonAct(this)">
                                                    <option value="0">Select Number of Sons</option>
                                                    <option value="0">Non</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>6</option>
                                                    <option>7</option>
                                                    <option>8</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 married">    
                                            <div class=" form-group">
                                                <label>Unmarried Son</label>
                                                <select class="form-control" name="sonunmarried" id="sonunmarried" onchange=" createUnMRSon(this.value)">
                                                    <option value="0">Unmarried Son</option>
                                                    <option value="0">All Married</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>6</option>
                                                    <option>7</option>
                                                    <option>8</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="unmarriedsondiv col-md-12 no-padding">
                                        </div>
                                    </div>
                                    <div class=" col-md-6 no-padding">
                                        <div class="col-md-6 married">    
                                            <div class=" form-group">
                                                <label>Daughter</label>
                                                <select class="form-control" name="daughter" id="daughter" onchange=" unMarriedDaughterAct(this)">
                                                    <option value="0">Select Number of Daughters</option>
                                                    <option value="0">Non</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>6</option>
                                                    <option>7</option>
                                                    <option>8</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 married">    
                                            <div class=" form-group">
                                                <label>Unmarried Daughter</label>
                                                <select class="form-control" name="daughterunmarried" id="daughterunmarried" onchange=" createUnMRDaughter(this.value)">
                                                    <option value="0">Unmarried Daughter</option>
                                                    <option value="0">All Married</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>6</option>
                                                    <option>7</option>
                                                    <option>8</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="unmarrieddaughterdiv col-md-12 no-padding">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Profile Photo</legend>
                                <div class="row">
                                    <div class="col-md-4" style="text-align: center;">
                                        <?php
                                        $class = ($edit['photo']!="")?"":"required";
                                        if($edit['photo']!="")
                                        $img = '<img src="'.$edit['photo'].'" class="img-thumbnail">';
                                        ?>
                                        <label id="lphoto">Select Main-Photo</label>
                                        <input type="file" name="photo" id="photo" onchange="preview_image(this,'image_preview');" class=" form-control <?php echo $class; ?>">
                                    <div id="image_preview" style='max-height: 400px; overflow:hidden;margin-top: 30px;'>
                                        <?php echo $img ?>
                                    </div>
                                    </div>
                                    <div class="col-md-4" style="text-align: center;">
                                        <?php
                                        if($edit['photo1']!="")
                                        $img1 = '<img src="'.$edit['photo1'].'" class="img-thumbnail">';
                                        ?>
                                         <label id="lphoto1">Select Photo1</label>
                                        <input type="file" name="photo1" id="photo1" onchange="preview_image(this,'image_preview1');" class=" form-control">
                                    <div id="image_preview1" style='max-height: 400px; overflow:hidden;margin-top: 30px;'>
                                           <?php echo $img1 ?> 
                                        </div>
                                       
                                    </div>
                                    <div class="col-md-4" style="text-align: center;">
                                        <?php
                                        if($edit['photo2']!="")
                                        $img2 = '<img src="'.$edit['photo2'].'" class="img-thumbnail">';
                                        ?>
                                        <label id="lphoto2">Select Photo2</label>
                                        <input type="file" name="photo2" id="photo2" onchange="preview_image(this,'image_preview2');" class=" form-control">
                                    <div id="image_preview2" style='max-height: 400px; overflow:hidden;margin-top: 30px;'>
                                            <?php echo $img2 ?> 
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="col-md-2" id="submition">
                                <input name="id" type="hidden" value="<?php echo $edit['Profileid']; ?>">
                                <input type="submit" onclick="return checkrequired(this.form);" class="btn btn-flat btn-primary" style="margin-top: 24px;" name="submit" value="Save">
                                <input type="reset"  class="btn btn-flat btn-primary" style="margin-top: 24px;" name="submit" value="Reset">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include_once __DIR__.'/../layout/footer.php'; ?>
<?php echo session::GetMessage(); ?>
</div>
<script>
  $(function () {
    var limit = '<?php echo $limit ?>';
    var cpage = '<?php echo $cpage ?>';
    $('.table').DataTable({
        'paging'      : false,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false
    });
  })
  function deleteCity(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deleteCity/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $("#row_"+x).remove();
                }else if(res=="2"){
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Required data missing.</p>");
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Can't Delete This City. Related Data found!.</p>");
                }
            }
        })
      }
  }
  function loadAreaByCity(xx,yy){ //yy is used to show seleted when editing
    var url = "<?php echo ADMIN_URL ?>loadAreaByCity/"+xx.value;
//    alert(url);
    var $elem = $("#area");
    $elem.empty();
    var html = "<option value='0'>Select Location</option>";
    $.ajax({
        url: url,
        success: function(res){
            var obj = jQuery.parseJSON(res);
            console.log(obj);
            for(var j=0; j < Object.keys(obj.response).length;j++){  
                var selected = (yy==obj.response[j].Id)?"selected":"";
                html += "<option value='"+obj.response[j].Id+"' "+selected+">"+obj.response[j].AreaName+"</option>";
            }
            $elem.append(html);
        }
    });
  }
  
  $(document).ready(function(){
     <?php if($response[5]){ ?> // Executes in view mode
        var $el = $(document).find("#myform").find("input,select");
        $.each($el,function(){
           if(!$(this).hasOwnProperty('readonly')){
               $(this).attr("readonly","true");
               if(this.nodeName=="SELECT")
               $(this).attr("disabled","true");
           }
            this.addEventListener("click",function(event){
                event.preventDefault();
                return false;
            });
        });
       $("#photo1,#photo2,#photo,#submition").remove();
       $("#lphoto").text("Main Photo");
       $("#lphoto1").text("Photo 1");
       $("#lphoto2").text("Photo 2");
     <?php } ?>
     var $elem = document.getElementById('city'); 
     loadAreaByCity($elem,<?php echo ($loc=="")?0:$loc ?>);
     <?php if($edit['occu']!=""){ ?>
     getOccuDetails('<?php echo $edit['occu'] ?>');
     <?php } ?>
     <?php if($edit['o_estab']!=""){ ?>
     $("#estab_b").val('<?php echo $edit['o_estab'] ?>');
     <?php } ?>
     <?php if($edit['brother']!=""){ 
         $brother = ($edit['brother']=="")?0:$edit['brother'];
         ?>
     $("#brother").val('<?php echo $brother ?>');
     <?php } ?>
     <?php if($edit['sister']!=""){ 
         $sister = ($edit['sister']=="")?0:$edit['sister'];
         ?>
     $("#sister").val('<?php echo $sister ?>');
     <?php } ?>
     <?php if($edit['son']!=""){ 
         $son = ($edit['son']=="")?0:$edit['son'];
         ?>
     $("#son").val('<?php echo $son ?>');
     <?php } ?>
     <?php if($edit['sonunmarried']!=""){ 
         $sonunmarried = ($edit['sonunmarried']=="")?0:$edit['sonunmarried'];
         ?>
     $("#sonunmarried").val('<?php echo $sonunmarried ?>');
     var $elem = document.getElementById('son'); 
     unMarriedSonAct($elem);
     createUnMRSon(<?php echo $sonunmarried ?>);
     <?php } ?>
     <?php if($edit['daughter']!=""){ 
         $daughter = ($edit['daughter']=="")?0:$edit['daughter'];
         ?>
     $("#daughter").val('<?php echo $daughter ?>');
     <?php } ?>
     <?php if($edit['daughterunmarried']!=""){ 
         $daughterunmarried = ($edit['daughterunmarried']=="")?0:$edit['daughterunmarried'];
         ?>
     $("#daughterunmarried").val('<?php echo $daughterunmarried ?>');
     var $elem = document.getElementById('daughter'); 
     unMarriedDaughterAct($elem);
     createUnMRDaughter(<?php echo $daughterunmarried ?>);
     <?php } ?>
     <?php
     if($edit['mstatus']!="Unmarried" && $edit['mstatus']!=""){ ?>
       $(".married").show();  
     <?php }
     ?>
  });
  
    $("#myform input[type=submit]").on("click",function(){
       //return checkrequired("myform");      
  });
  
 function getOccuDetails(xx){
     var occu = xx;
     $(".occuDetail").hide();
     var $oc = $(".occuDetail").find(".ocu");
     $.each($oc,function(){
         $(this).removeClass("required");
     });
     if(occu=="Govt Job" || occu=="Private Job"){
         $(".job").show();
         var $oc = $(".job").find(".ocu");
     }
     if(occu=="Business"){
         $(".Business").show();
         var $oc = $(".Business").find(".ocu");
     }
     if(occu=="Professional"){
         $(".Professional").show();
         var $oc = $(".job").find(".ocu");       
     }
     $.each($oc,function(){
            $(this).addClass("required");
     });
 }
  
 function createUnMRDaughter(daughter){
     var $elem = $(".unmarrieddaughterdiv");
     //var daughter = Number(xx.value);
     var jobj = null;
     var child = '<?php echo (!empty($response[4]))?$response[4]:""; ?>'
     if(child!=null && child!=""){
          jobj = JSON.parse(child);
     }
     
     for(var i=0; i < daughter; i++){
         var name="";var dob="";var job="";
         if(jobj!=null ){
            if(jobj!=null && i < Object.keys(jobj.daughter).length){
                name = (jobj.daughter[i].name!="")?jobj.daughter[i].name:"";
                dob = (jobj.daughter[i].dob!="")?jobj.daughter[i].dob:"";
                job = (jobj.daughter[i].job!="")?jobj.daughter[i].job:"";
            }
        }
         <?php if($response[5]){ ?> // Executes in view mode
                var read = 'readonly';
         <?php }else{ ?>
             var read = '';
         <?php } ?>
         if(i==0)var html = '<h5 style="margin-left: 14px;">Unmarried Daughter Detail</h5>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>Name</label>'+
                        '<input class="form-control  required" type="text" name="undaughter['+i+'][name]"  onKeyPress="return isAlphaOnly(event);" value="'+name+'" placeholder="Name" '+read+'>'+
                    '</div>'+
                '</div>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>DOB</label>'+
                        '<input class="form-control date  required" type="text" name="undaughter['+i+'][age]" onKeyPress="return false;" value="'+dob+'" placeholder="DOB" '+read+'>'+
                    '</div>'+
                '</div>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>Job</label>'+
                        '<input class="form-control" type="text" name="undaughter['+i+'][job]"  value="'+job+'" placeholder="Job" '+read+'>'+
                    '</div>'+
                '</div>';
     }
     
     $elem.empty();
     $elem.append(html);
     $(".date").datepicker({format: 'dd/mm/yyyy'});
      $("#daughterunmarried").val(daughter);
 } 
 function createUnMRSon(son){
     var $elem = $(".unmarriedsondiv");
     //var son = Number(xx.value);
     var jobj = null;
     var child = '<?php echo (!is_null($response[3]))?$response[3]:null; ?>'
     if(child!=null && child!=''){
         jobj = JSON.parse(child);
         console.log(jobj);
     }
     
     for(var i =0; i < son; i++){
         var name="";var dob="";var job=""
         if(jobj!=null ){
            if(jobj!=null && i < Object.keys(jobj.son).length){
             name = (jobj.son[i].name!="")?jobj.son[i].name:"";
             dob = (jobj.son[i].dob!="")?jobj.son[i].dob:"";
             job = (jobj.son[i].job!="")?jobj.son[i].job:"";
            }
        }
          <?php if($response[5]){ ?> // Executes in view mode
                var read = 'readonly';
         <?php }else{ ?>
             var read = '';
         <?php } ?>
         if(i==0)var html = '<h5 style="margin-left: 14px;">Unmarried Son Detail</h5>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>Name</label>'+
                        '<input class="form-control  required" type="text" name="unson['+i+'][name]"  onKeyPress="return isAlphaOnly(event);" value="'+name+'" placeholder="Name" '+read+'>'+
                    '</div>'+
                '</div>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>DOB</label>'+
                        '<input class="form-control date  required" type="text" name="unson['+i+'][age]" onKeyPress="return false;" value="'+dob+'" placeholder="DOB" '+read+'>'+
                    '</div>'+
                '</div>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>Job</label>'+
                        '<input class="form-control" type="text" name="unson['+i+'][job]"  value="'+job+'" placeholder="Job" '+read+'>'+
                    '</div>'+
                '</div>';
     }
     
     $elem.empty();
     $elem.append(html);
     $(".date").datepicker({format: 'dd/mm/yyyy'});
     $("#sonunmarried").val(son);
 } 
  <?php if(empty($response[2])){ ?>
  $(document).on("ready",function(e){
    var $parentElem = document.getElementById('loginid');
      $.ajax({
         url:"<?php echo ADMIN_URL ?>getUniqueId",
         type:"post",
         success:function(res){
             $parentElem.value = res;
         }
      });
  });
  <?php } ?>
  function deleteProfile(xx){
    if(confirm("Are You Sure To Delete This Profile?")){
        return false;
    }else{
        return true;
    }
  }
  
  function mstatusActions(xx){
     var mstatus = xx.value;
     if(mstatus!="Unmarried"){
         $(".married").show();
     }else{
         $(".married").hide();
     }
 } 
 
  function unMarriedDaughterAct(xx){
     var daughter = Number(xx.value);
     if(daughter!=NaN){
         var trgt = $("#daughterunmarried option");
         $.each(trgt,function(){
             var nn = Number($(this).text());
             if(nn!=NaN && nn > daughter){
                 $(this).hide();
             }else{
                 $(this).show();
             }
         })
     }
     createUnMRDaughter(daughter);
  }
  function unMarriedSonAct(xx){
     var son = Number(xx.value);
     if(son!=NaN){
         var trgt = $("#sonunmarried option");
         $.each(trgt,function(){
             var nn = Number($(this).text());
             if(nn!=NaN && nn > son){
                 $(this).hide();
             }else{
                 $(this).show();
             }
         })
     }
     createUnMRSon(son);
 }
 
 function preview_image(xx,id) 
{
 $('#'+id).empty();
 var total_file=xx.files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#'+id).append("<img  class='img-thumbnail' src='"+URL.createObjectURL(event.target.files[i])+"'>");
 }

}
 
</script>
</body>

</html>

