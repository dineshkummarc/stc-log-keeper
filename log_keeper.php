<!DOCTYPE html>
<html>

<?php include('dbcon.php'); ?>

  <?php include('header_main.php'); ?>
  
  <body onload="document.getElementById('profile_id').focus();">
  
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
          
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div style="width: 98%; padding: 36px; margin-left: 8px;">
                <div class="content">
                <div style="text-align: center; width: 100%;">
                <img src="img/stc_logo.png" style="width: 55px; height: 55px; margin-bottom: 12px;" /><br />
                <h3 style="width: 100%; text-align: center;">STA. TERESA COLLEGE</h3>
                <i class="fa fa-map-marker"></i> Bauan, Batangas<br />
                <!--i class="fa fa-envelope-o"> binalbagancatholicollege@gmail.com</i-->
                </div>
                <hr />
                <div class="row">
     
                
                <div class="input-group">
                <div style="width: 100%; text-align: left;">
                <small>Search ID Code / Lastname</small>
                </div>
                
                <div class="input-group-append">
                <span class="btn btn-primary" style="color: white;"><i class="fa fa-user"></i></span>
                </div>
                
                <input <?php if($_GET['remarks']==='NEW'){ ?> value="<?php echo $_GET['pid']; ?>" <?php } ?> id="profile_id" name="profile_id" required="" class="form-control" placeholder="Enter ID Code / Last Name" />
    
                <div class="input-group-append">
                <a id="search_btn" onclick="checkLRNStatus()" class="btn btn-primary" style="color: white;"><i class="fa fa-search"></i></a>
                <a id="search_load" class="btn btn-default" style="display: none;"><img src="img/blue-loader.gif" width="15" height="15"/></a>
                </div>
                
                </div>
               
                
                <div class="input-group col-12">
                
                <span id="lrn_message" style="font-size: medium; width: 100%; margin: 0px; padding: 0px;"></span>
                
                <?php if($_GET['remarks']==='NEW'){ ?>
                
                <div style="display: block; margin-top: 12px;  width: 100%" class="alert alert-info" id="alert_panel">
                
                <?php
                                    
                $profile_query = $conn->query("SELECT * FROM members WHERE profile_id='$_GET[pid]'");
                $profile_row = $profile_query->fetch();
                
                ?>
                <p style="margin-bottom: 0px;"><i class="fa fa-user"></i> <?php echo $profile_row['lname'].", ".$profile_row['fname']; ?></p>
                <p style="margin-bottom: 0px;"><i class="fa fa-map-marker"></i> <?php echo $profile_row['street'].", ".$profile_row['brgy'].", ".$profile_row['city_municipal']; ?></p>
                
                
                <p style="margin-bottom: 0px;">
                <hr />
                <i class="fa fa-checked-circle"></i> Registration success! Press enter to login.
                </p>
                
                </div>
                
                <?php }else{ ?> 
                
                <div <?php if($_GET['remarks']==='IN'){ ?> style="display: block; margin-top: 12px;  width: 100%" class="alert alert-success" <?php }elseif($_GET['remarks']==='OUT'){ ?> style="display: block; margin-top: 12px;  width: 100%" class="alert alert-info" <?php }else{ ?> style="display: none;" <?php } ?> id="alert_panel">
                
                <?php
                                    
                $profile_query = $conn->query("SELECT * FROM members WHERE member_id='$_GET[pid]'");
                $profile_row = $profile_query->fetch();
                
                ?>
                <p style="margin-bottom: 0px;"><i class="fa fa-user"></i> <?php echo $profile_row['lname'].", ".$profile_row['fname']; ?></p>
                <p style="margin-bottom: 0px;"><i class="fa fa-map-marker"></i> <?php echo $profile_row['street'].", ".$profile_row['brgy'].", ".$profile_row['city_municipal']; ?></p>
                
                
                <p style="margin-bottom: 0px;">
                <hr />
                <i class="fa fa-check-circle"></i> <?php if($_GET['remarks']==='IN'){ echo "Login"; }elseif($_GET['remarks']==='OUT'){ echo "Logout"; } ?> success! <i class="fa fa-clock-o"></i> <?php echo $_GET['logtime']; ?>
                </p>
                
                </div>
                <?php } ?>
                
                </div>
                
                </div>
             
                
                </div>
              </div>
            </div>
            
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info">
                <div class="content">
                
                  <div class="logo">
                  
                    <div class="dropdown" style="margin-bottom: 12px;">
                      <a class="dropbtn" style="padding: 2px 6px 2px 6px; font-size: small; cursor: pointer;"><i class="fa fa-list"></i> Menu</a>
                      <div class="dropdown-content">
                        <a href="index.php"><i class="fa fa-user"></i> Administrator</a>
                        <a href="print_reports.php" target="_blank"><i class="fa fa-list"></i> View Logs</a>
                        <a href="log_history.php" target="_blank"><i class="fa fa-refresh"></i> Log History</a>
                      </div>
                    </div>
                    
                  <h2>Electronic Log Keeper</h2>
                  
                  </div>
                  
                  <p style="margin-bottom: 0px;">Establishment Log Keeper version 1.0</p>
                  <p style="margin-top: 0px;">Wear Mask, Wash Hands, Atleast 1 Meter Physical Distancing</p>
                  
                <div id="screenRefDate"></div>
                
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
        <p>Design by <a href="https://bootstrapious.com/p/admin-template" class="external">Bootstrapious</a>
          <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
        </p>
      </div>
    </div>
    
    <?php include('script_files.php'); ?>
    
    <script>
    function checkLRNStatus(){
        
    document.getElementById('search_btn').style.display = 'none';
    document.getElementById('search_load').style.display = 'inline-block';
    
    var profile_id=$("#profile_id").val();// value in field profile_id
    var body_temp=$("#body_temp").val();// value in field body_temp
    
    $.ajax({
        type:'POST',
            url:'check_profile.php',// put your real file name 
            data:{profile_id: profile_id, body_temp: body_temp},
            success:function(msg){
            $('#lrn_message').html(msg).css('color', '#33b35a');
            }
     });
    }
    
    //Press Enter Ker to trigger function checkLRNStatus()
    var input = document.getElementById("profile_id");
    input.addEventListener("keyup", function(event) {
      if (event.keyCode === 13) {
       event.preventDefault();
       document.getElementById("search_btn").click();
      }
    });
    
    
    
    
    $(document).ready(function(){
    	setInterval(function(){
    		$("#screenRefDate").load('log_dashboard_main.php');
        }, 1000);
        
        setTimeout(function() {
            $('#alert_panel').fadeOut('fast');
        }, 10000);
        
    });
    
    
    

    </script>
    
  </body>
</html>