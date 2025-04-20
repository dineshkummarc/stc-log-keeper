<!DOCTYPE html>
<html>
<?php include('dbcon.php'); ?>
  <?php include('header_main.php'); ?>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
          
            <!-- LOGIN FORM-->
            <div class="col-lg-6 bg-white">
            
                <div class="content">
                <div style="text-align: center; width: 100%; margin-top: 48px;">
                <img src="img/stc_logo.png" style="width: 55px; height: 55px; margin-bottom: 12px;" /><br />
                <h3 style="width: 100%; text-align: center;">STA. TERESA COLLEGE</h3>
                <i class="fa fa-map-marker"></i> Bauan, Batangas<br />
                <!--i class="fa fa-envelope-o"> binalbagancatholicollege@gmail.com</i-->
                </div>
              
                <form action="login.php" method="POST">
                    <div style="width: 100%; padding: 48px;">
                    
                    <div class="input-group col-12">
                    <div style="width: 100%; text-align: left;">
                    <small>Username</small>
                    </div>
                    
                    <div class="input-group-append">
                    <span class="btn btn-primary" style="color: white;"><i class="fa fa-user"></i></span>
                    </div>
                    
                    <input name="username" type="text" class="form-control" placeholder="Enter Username" required=""/>
                    
                    </div>
                    
                    <div class="input-group col-12" style="margin-top: 12px;">
                    <div style="width: 100%; text-align: left;">
                    <small>Password</small>
                    </div>
                    
                    <div class="input-group-append">
                    <span class="btn btn-primary" style="color: white;"><i class="fa fa-key"></i></span>
                    </div>
                    
                    <input name="password" type="password" class="form-control" placeholder="Enter Password" required=""/>
                    
                    </div> 
                    
                    <div class="col-lg-12" style="margin-top: 24px;">
                    <button id="login" class="btn btn-primary" style="width: 100%;"><i class="fa fa-sign-in"></i> Login</button>
                    </div>
                   
                   
                    </div>
                </form>
 
 
                  
                </div>
              
            </div>
            
          <!-- Logo & Information Panel-->
            <div class="col-lg-6">
            
              <div class="info">
                <div class="content" style="padding: 0px;">
                  <div class="logo">
                  
                    <div class="dropdown" style="margin-bottom: 12px;">
                      <a class="dropbtn" style="padding: 2px 6px 2px 6px; font-size: small; color: #ffffff; cursor: pointer;"><i class="fa fa-list"></i> Menu</a>
                      <div class="dropdown-content">
                        <a href="log_keeper.php?pid=&remarks=&logtime="><i class="fa fa-calendar-times-o"></i> Log Keeper</a>
                        <a href="print_reports.php" target="_blank"><i class="fa fa-list"></i> View Logs</a>
                      </div>
                    </div>
                    
                  <h2>Electronic Log Keeper</h2>
                  
                  </div>
                  
                  <p style="margin-bottom: 0px;">Establishment Log Recorder version 1.0</p>
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
    $(document).ready(function(){
    	setInterval(function(){
    		$("#screenRefDate").load('log_dashboard_main.php')
            
        }, 1000);
    });
    </script>
    
  </body>
</html>