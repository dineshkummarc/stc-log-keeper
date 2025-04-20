            <?php include('dbcon.php'); ?>
            

                  
                  <?php
                  
                  $chk_log_in_query = $conn->prepare('SELECT * FROM tbl_attendance WHERE date_mm = :date_mm AND date_dd = :date_dd AND date_yyyy = :date_yyyy AND action = :action');
                  $chk_log_in_query->execute(['date_mm' => $date_mm, 'date_dd' => $date_dd, 'date_yyyy' => $date_yyyy, 'action' => 'IN']);
                  
                  $chk_log_out_query = $conn->prepare('SELECT * FROM tbl_attendance WHERE date_mm = :date_mm AND date_dd = :date_dd AND date_yyyy = :date_yyyy AND action = :action');
                  $chk_log_out_query->execute(['date_mm' => $date_mm, 'date_dd' => $date_dd, 'date_yyyy' => $date_yyyy, 'action' => 'OUT']);


                  ?>
                  
                  <!-- Dashboard Counts Section-->
                  <section class="dashboard-counts no-padding-bottom" style="margin: 0px;">
                    <div class="container-fluid">
                      <div class="row bg-white has-shadow">
                      <h3 class="text-info"><a style="cursor: pointer;" title="The displayed data below is refreshed every 1 seconds"><i class="fa fa-info-circle"></i></a> Quick Summary</h3>
                      <hr />
                        <!-- Item -->
                        <div class="col-xl-12 col-sm-12">
                          <div class="item d-flex align-items-center">
                            <div class="icon bg-violet"><i class="fa fa-calendar"></i></div>
                            <div class="title"><span><?php echo date("l"); ?>, <?php echo date("M".". "."d".", "."Y"); ?> &nbsp; <small><i class="fa fa-clock-o"></i> <?php echo date('h:i:s A'); ?></small></span>
                               
                            </div>
                      
                          </div>
                        </div>
                        
                        <!-- Item -->
                        <div class="col-xl-12 col-sm-12">
                          <div class="item d-flex align-items-center">
                            <div class="icon bg-red"><i class="fa fa-line-chart"></i></div>
                            <div class="number text-info"><strong>
                            &nbsp;&nbsp;&nbsp;<?php echo $chk_log_in_query->rowCount()-$chk_log_out_query->rowCount(); ?> <sup style="font-weight: lighter;"> of <?php echo $max_cap; ?><sup> max capacity</sup> <a style="cursor: pointer;" title="Real time data of total individuals inside the establishment out of the total max capacity" class="text-info"><i class="fa fa-question-circle"></i></a></sup>
                            </strong></div>
                          </div>
                        </div>
                        
                        <!-- Item -->
                        <div class="col-xl-12 col-sm-12">
                          <div class="item d-flex align-items-center">
                            <div class="icon bg-blue"><i class="fa fa-users"></i></div>
                            <div class="number text-info"><strong>
                            &nbsp;&nbsp;&nbsp;<?php echo $chk_log_in_query->rowCount(); ?> <sup style="font-weight: lighter;"><sup><a href="reports_in.php" target="_blank">IN</a>'s</sup></sup> &nbsp;&nbsp; <?php echo $chk_log_out_query->rowCount(); ?> <sup style="font-weight: lighter;"><sup><a href="reports_out.php" target="_blank">OUT</a>'s</sup> &nbsp; <a style="cursor: pointer;" title="Total IN's and OUT's of the day" class="text-info"><i class="fa fa-question-circle"></i></a></sup>
                            </strong></div>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                  </section>
            
