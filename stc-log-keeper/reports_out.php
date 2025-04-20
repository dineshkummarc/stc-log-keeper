<!DOCTYPE html>
<html>
<?php

include('dbcon.php');

  if(isset($_POST['dateFilter'])){
    
    //2019-10-03
    $selectedMM=substr($_POST['dateFrom'], 5,2);
    $selectedDD=substr($_POST['dateFrom'], 8,2);
    $selectedYYYY=substr($_POST['dateFrom'], 0,4);
    $dateFrom=$selectedMM.'/'.$selectedDD.'/'.$selectedYYYY;
 
  }else{
    
    $selectedMM=date('m'); 
    $selectedDD=date('d'); 
    $selectedYYYY=date('Y'); 
    $dateFrom=date('m/d/Y'); 
    
  }
  
?>
  <?php include('header_main.php'); ?>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            
          <!-- Logo & Information Panel-->
            <div class="col-lg-6">
            
              <div class="info">
                <div class="content" style="padding: 0px;">
                  <div class="logo">
                    <h2>Electronic Log Manager - Reports</h2>
                  </div>
                  <p style="margin-bottom: 0px;">Establishment Log Recorder version 1.0</p>
                  <p style="margin-top: 0px;">Wear Mask, Wash Hands, Atleast 1 Meter Physical Distancing</p>
                  
                  <div id="screenRefDate"></div>
                  
                </div>
              </div>
              
            </div>
                
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                <div style="text-align: center; width: 100%;">
                <img src="img/stc_logo.png" style="width: 55px; height: 55px; margin-bottom: 12px;" /><br />
                <h3 style="width: 100%; text-align: center;">STA. TERESA COLLEGE</h3>
                <i class="fa fa-map-marker"></i> Bauan, Batangas<br />
                <!--i class="fa fa-envelope-o"> binalbagancatholicollege@gmail.com</i-->
                </div>
                <hr />
                
                <form method="POST"> 
                <div class="row col-lg-12 col-md-12 col-sm-12" style="margin-top: 12px;">
                
                <div class="col-lg-12 col-md-12">
                    <div class="input-group">
                        <input type="date" name="dateFrom" value="<?php echo $selectedYYYY.'-'.$selectedMM.'-'.$selectedDD; ?>" class="form-control form-control-sm" />
                        <div class="input-group-append">
                        <button name="dateFilter" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i></button>
                        </div>
                    </div>
                    <small>Filter List by Date</small>
                </div>
                
                </div>
                </form> 
 
                </div>
              </div>
            </div>
        
        <div class="col-12">
          <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                 
                
                
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-close">
                 
                    </div>
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">LOG-OUT RECORDS</h3>
                    </div>
 
                     
                     
                    <div class="card-body">
                      <div class="table-responsive">  
                        <table class="table table-striped" id="example">
                          <thead>
                          <tr>
                          <th></th>
                          <th>Name [ ID Code ]</th>
                          <th>Contact #</th>
                          <th>Address</th>
                          <th>Log Details</th>
                          </tr>
                          </thead>
                          
                          <tbody>
                          <?php
                          $log_ctr=0;
                          $chk_log_in_query = $conn->prepare('SELECT * FROM tbl_attendance WHERE date_mm = :date_mm AND date_dd = :date_dd AND date_yyyy = :date_yyyy AND action = :action');
                          $chk_log_in_query->execute(['date_mm' => $selectedMM, 'date_dd' => $selectedDD, 'date_yyyy' => $selectedYYYY, 'action' => 'OUT']);

                          while($chk_log_row = $chk_log_in_query->fetch()){
                          
                          $log_ctr+=1;
                          
                          $member_data_query = $conn->prepare('SELECT * FROM members WHERE member_id = :member_id');
                          $member_data_query->execute(['member_id' => $chk_log_row['member_id']]);
                          $mem_data_row = $member_data_query->fetch();
                          ?>
                          
                          <tr>
                          <td><?php echo $log_ctr; ?></td>
                          <td><?php echo $mem_data_row['lname'].", ".$mem_data_row['fname']; ?> [ <?php echo $mem_data_row['profile_id']; ?> ]</td>
                          <td><?php echo $mem_data_row['phone_num']; ?></td>
                          <td><?php echo $mem_data_row['street'].", ".$mem_data_row['brgy'].", ".$mem_data_row['city_municipal']; ?></td>
                          <td><?php echo $chk_log_row['date_mm'].'/'.$chk_log_row['date_dd'].'/'.$chk_log_row['date_yyyy'].' | '.$chk_log_row['log_time']; ?> <sup><?php echo $chk_log_row['action']; ?></sup></td>
                          
                          </tr>
                          
                          <?php } ?>
                          
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
  
              </div>
            </div>
          </section>
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