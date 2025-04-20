<!DOCTYPE html>
<html>
<?php

include('dbcon.php');


  
?>
  <?php include('header_main.php'); ?>
  <body>
  
   
          <div class="row">
            
     
                
            <!-- Form Panel    -->
          
         
          
        <div class="col-12">
          <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                 
                
                
                <div class="col-lg-12">
                  <div class="card">
                  
                   <div style="text-align: center; width: 100%;">
                    <img src="img/stc_logo.png" style="width: 55px; height: 55px; margin-bottom: 12px;" /><br />
                    <h3 style="width: 100%; text-align: center;">STA. TERESA COLLEGE</h3>
                    <i class="fa fa-map-marker"></i> Bauan, Batangas<br />
                   
                    <br /><br />
                      <h3 class="h1">DAILY LOG REPORTS for <?php  echo $_GET['selectedMM']."/".$_GET['selectedDD']."/". $_GET['selectedYYYY']; ?></h3>
                    </div>
 
                     
                     
                    <div class="card-body">
                      <div class="table-responsive">  
                        <table class="table table-striped">
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
                          $chk_log_in_query = $conn->prepare('SELECT * FROM tbl_attendance WHERE date_mm = :date_mm AND date_dd = :date_dd AND date_yyyy = :date_yyyy');
                          $chk_log_in_query->execute(['date_mm' => $_GET['selectedMM'], 'date_dd' => $_GET['selectedDD'], 'date_yyyy' => $_GET['selectedYYYY']]);
                          
                          
                          
                          
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
        
        
        
        
    

    
    <?php include('script_files.php'); ?>
    
   
    
  </body>
</html>