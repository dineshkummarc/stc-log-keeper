<?php
    include('dbcon.php');
    
        $idcode_gen_query = $conn->query("SELECT prefix, last_idNum FROM idcode_gen WHERE dept='Visitor'") or die(mysql_error());
        $idcode_gen_row=$idcode_gen_query->fetch();
                                 
        $new_id_num=$idcode_gen_row['last_idNum']+1;
                                  
        if($new_id_num>=0 AND $new_id_num<=9)
        {
            $final_idcode=$idcode_gen_row['prefix']."000".$new_id_num;             
        }
        elseif($new_id_num>9 AND $new_id_num<=99)
        {
            $final_idcode=$idcode_gen_row['prefix']."00".$new_id_num;
        }
        elseif($new_id_num>99 AND $new_id_num<=999)
        {
            $final_idcode=$idcode_gen_row['prefix']."0".$new_id_num;
        }
        elseif($new_id_num>999 AND $new_id_num<=9999)
        {
            $final_idcode=$idcode_gen_row['prefix'].$new_id_num;
        }
        
    $chk_lrn_query = $conn->query("SELECT * FROM members WHERE profile_id = '$_POST[profile_id]' OR (lname LIKE '%$_POST[profile_id]%') ORDER BY lname, fname ASC") or die(mysql_error());
    
    
        if($chk_lrn_query->rowCount()>1){
            $txt_result=$chk_lrn_query->rowCount()." results found...";
        }else{
            $txt_result=$chk_lrn_query->rowCount()." result found...";
        }
        
        echo "<p style='margin-top: 12px;'>Searched: ".$_POST['profile_id']."<br /><small>".$txt_result."</small></p>";
        
    if($chk_lrn_query->rowCount()>0)
    {

echo
"<div id='search_result_list_panel' style='width: 100%;'>";
            
while($chk_lrn_row = $chk_lrn_query->fetch()){
        
        $chk_log_query = $conn->prepare('SELECT * FROM tbl_attendance WHERE member_id = :member_id AND date_mm = :date_mm AND date_dd = :date_dd AND date_yyyy = :date_yyyy');
        $chk_log_query->execute(['member_id' => $chk_lrn_row['member_id'], 'date_mm' => $date_mm, 'date_dd' => $date_dd, 'date_yyyy' => $date_yyyy]);
        
        $mod_val=$chk_log_query->rowCount() % 2;
    
            
            
if($mod_val>0){
            
            echo
            "<div class='row' style='border: solid 1px #33b35a; border-radius: 0.25rem; margin: 12px 1px 1px 1px; padding: 4px;'>";
            
            $in_log_query = $conn->query("SELECT attend_id, log_time FROM tbl_attendance WHERE member_id='$chk_lrn_row[member_id]' AND date_mm='$date_mm' AND date_dd='$date_dd' AND date_yyyy='$date_yyyy' AND action='IN' ORDER BY attend_id DESC") or die(mysql_error());
            $il_row=$in_log_query->fetch();
            
            $ref_log_id=$il_row['attend_id'];
                        
                echo
                "<div class='col-5' style='display: flex; justify-content: center; align-items: center;'>
                ".$chk_lrn_row['lname'].", ".$chk_lrn_row['fname']."
                </div>
            
                <div class='col-5' style='display: flex; justify-content: center; align-items: center;'>
                <i class='fa fa-clock-o'></i>&nbsp;<strong>Login:</strong>&nbsp;".$il_row['log_time']."
                </div>
                
                <div class='col-2' style='display: flex; justify-content: center; align-items: center;'>
                
                <a id='logout_btn".$chk_lrn_row['member_id']."' onclick='show_hdf_panel".$chk_lrn_row['member_id']."()' class='btn btn-warning' style='font-size: small; padding: 0px 2px 0px 2px; color: #ffffff; width: 100%;'><i class='fa fa-sign-out'></i> Logout</a>
                
                <a id='cancel_btn".$chk_lrn_row['member_id']."' onclick='hide_hdf_panel".$chk_lrn_row['member_id']."()' class='btn btn-secondary' style='font-size: small; padding: 0px 2px 0px 2px; color: #ffffff; width: 100%; display: none;'><i class='fa fa-times'></i> Cancel</a>";
                
                
                ?>
                
                <script>
                
                function show_hdf_panel<?php echo $chk_lrn_row['member_id']; ?>(){
                    
                    document.getElementById('logout_panel<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'block';
                    document.getElementById('cancel_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'block';
                    document.getElementById('logout_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'none';
                    
                }
                
                function hide_hdf_panel<?php echo $chk_lrn_row['member_id']; ?>(){
                    
                    document.getElementById('logout_panel<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'none';
                    document.getElementById('cancel_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'none';
                    document.getElementById('logout_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'block';
                    
                }
                
                </script>
                
                <?php
                
                
                echo "</div>";
                
                //LOGOUT - BODY TEMP ONLY//
                echo
                "<div class='col-12' id='logout_panel".$chk_lrn_row['member_id']."' style='display: none; margin-top: 12px;'>
                
                <form method='POST' action='save_log.php' style='width: 100%;'>
               
                <input name='member_id' value='".$chk_lrn_row['member_id']."' type='hidden' />
                <input name='ref_log_id' value='".$ref_log_id."' type='hidden' />
                
                <div class='input-group' style='margin-bottom: 12px; width:100%;'>
             
                    <input value='WANT TO LOGOUT ".$chk_lrn_row['lname'].", ".$chk_lrn_row['fname']."?' class='form-control' readonly='' />
                    
                    <div class='input-group-append'>
                    <button name='save_logout' class='btn btn-info' style='color: white;'><i class='fa fa-sign-out'></i> Logout</button>
                    </div>
                    
                </div>
                
                </form>
                
                </div>
                ";
                //END LOGOUT - BODY TEMP ONLY//
                
                echo "</div>";
                
}else{
                
                echo
                "<div class='row' style='border: solid 1px #33b35a; border-radius: 0.25rem; margin: 12px 1px 1px 1px; padding: 4px;'>";
                 
                $chk_hdf_query = $conn->prepare('SELECT * FROM tbl_daily_hdf WHERE member_id = :member_id AND date_mm = :date_mm AND date_dd = :date_dd AND date_yyyy = :date_yyyy');
                $chk_hdf_query->execute(['member_id' => $chk_lrn_row['member_id'], 'date_mm' => $date_mm, 'date_dd' => $date_dd, 'date_yyyy' => $date_yyyy]);
                
                if($chk_hdf_query->rowCount()>0){
                
                echo
                "<div class='col-10' style='display: flex; justify-content: center; align-items: center;'>
                ".$chk_lrn_row['lname'].", ".$chk_lrn_row['fname']."
                </div>
                
                <div class='col-2' style='display: flex; justify-content: center; align-items: center;'>
                
                <a id='login_btn".$chk_lrn_row['member_id']."' onclick='show_login_panel".$chk_lrn_row['member_id']."()' class='btn btn-primary' style='font-size: small; padding: 0px 2px 0px 2px; color: #ffffff; width: 100%;'><i class='fa fa-sign-in'></i> Login</a>
                
                <a id='cancel_btn".$chk_lrn_row['member_id']."' onclick='hide_login_panel".$chk_lrn_row['member_id']."()' class='btn btn-secondary' style='font-size: small; padding: 0px 2px 0px 2px; color: #ffffff; width: 100%; display: none;'><i class='fa fa-times'></i> Cancel</a>";
                
                
                ?>
                
                <script>
                
                function show_login_panel<?php echo $chk_lrn_row['member_id']; ?>(){
                    
                    document.getElementById('login_panel<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'block';
                    document.getElementById('cancel_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'block';
                    document.getElementById('login_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'none';
                    
                }
                
                function hide_login_panel<?php echo $chk_lrn_row['member_id']; ?>(){
                    
                    document.getElementById('login_panel<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'none';
                    document.getElementById('cancel_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'none';
                    document.getElementById('login_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'block';
                    
                }
                
                </script>
                
                <?php
                
                echo "</div>";
                
                //LOGIN - BODY TEMP ONLY//
                echo
                "<div class='col-12' id='login_panel".$chk_lrn_row['member_id']."' style='display: none; margin-top: 12px;'>
                
                <form method='POST' action='save_log.php' style='width: 100%;'>
                
                <p class='text-info' style='margin-top: 8px; margin-bottom: 0px;'>WANT TO LOGIN ".$chk_lrn_row['lname'].", ".$chk_lrn_row['fname']."?</p>
                
                <input name='member_id' value='".$chk_lrn_row['member_id']."' type='hidden' />
                
                <div class='input-group' style='margin-bottom: 12px; width:100%;'>
                
                    <div class='input-group-append'>
                    <span class='btn btn-info' style='color: white;'><i class='fa fa-thermometer-three-quarters'></i> Body Temperature</span>
                    </div>
                    
                    <input name='body_temp' class='form-control' required='' type='number' min='30.00' max='50.00' step='0.01' />
                    
                    <div class='input-group-append'>
                    <button name='save_login' class='btn btn-primary' style='color: white;'><i class='fa fa-sign-in'></i> Login</button>
                    </div>
                    
                </div>
                
                </form>
                
                </div>
                ";
                //END LOGIN BODY TEMP ONLY//
               
                }else{
                
                echo
                "<div class='col-10' style='display: flex; justify-content: center; align-items: center;'>
                ".$chk_lrn_row['lname'].", ".$chk_lrn_row['fname']."
                </div>
                
                <div class='col-2' style='display: flex; justify-content: center; align-items: center;'>
                
                <a id='login_btn".$chk_lrn_row['member_id']."' onclick='show_hdf_panel".$chk_lrn_row['member_id']."()' class='btn btn-primary' style='font-size: small; padding: 0px 2px 0px 2px; color: #ffffff; width: 100%;'><i class='fa fa-sign-in'></i> Login</a>
                
                <a id='cancel_btn".$chk_lrn_row['member_id']."' onclick='hide_hdf_panel".$chk_lrn_row['member_id']."()' class='btn btn-secondary' style='font-size: small; padding: 0px 2px 0px 2px; color: #ffffff; width: 100%; display: none;'><i class='fa fa-times'></i> Cancel</a>"
                ;
                
                
                ?>
                
                <script>
                
                function show_hdf_panel<?php echo $chk_lrn_row['member_id']; ?>(){
                    
                    document.getElementById('hdf_panel<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'block';
                    document.getElementById('cancel_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'block';
                    document.getElementById('login_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'none';
                    
                }
                
                function hide_hdf_panel<?php echo $chk_lrn_row['member_id']; ?>(){
                    
                    document.getElementById('hdf_panel<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'none';
                    document.getElementById('cancel_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'none';
                    document.getElementById('login_btn<?php echo $chk_lrn_row['member_id']; ?>').style.display = 'block';
                    
                }
                
                </script>
                
                <?php
                
                echo
                "</div>";
                
                //HEALTH DECLARATION FORM//
                echo
                "<div id='hdf_panel".$chk_lrn_row['member_id']."' style='display: none;'>
               
                <h3 class='text-info' style='margin-top: 8px;'>Please fill up Health Declaration Form</h3>
                
                <form method='POST' action='save_reg_login.php' style='width: 100%;'>
                
                <input name='member_id' value='".$chk_lrn_row['member_id']."' type='hidden' />
                
                <div class='input-group' style='margin-bottom: 12px; width:100%;'>
                
                    <div class='input-group-append'>
                    <span class='btn btn-primary' style='color: white;'><i class='fa fa-thermometer-three-quarters'></i></span>
                    </div>
                    
                    <input name='body_temp' class='form-control' required='' type='number' min='30.00' max='50.00' step='0.01' />
                    
                    <div class='input-group-append'>
                    <span class='btn btn-primary' style='color: white;'>Body Temperature</span>
                    </div>
                    
                </div>
                
                <div class='col-12' style='margin-bottom: 12px;'>
                
                <table class='table table-bordered' style='width: 100%'>
                
                <thead>
                <tr>
                <td>Please tap &nbsp; <input type='radio' disabled='' /> &nbsp; as your response</td>
                <th>YES</th>
                <th>NO</th>
                </tr>
                </thead>
                
                <tbody>
                
                <tr>
                <td style='font-size: small; text-align: justify;'>
                1.	Have you had face-to-face contact with a probable or confirmed COVID-19 case within 1 meter and for more than 15 minutes for the past 14 days?
                </td>
                <td><input value='Yes' name='q1' type='radio' required='' /></td>
                <td><input value='No' name='q1' type='radio' required='' /></td>
                </tr>
                
                <tr>
                <td style='font-size: small; text-align: justify;'>
                2.	Have you provided direct care for a patient with a probable or confirmed COVID -19 case without using proper personal protective equipment for the past 14 days?
                </td>
                <td><input value='Yes' name='q2' type='radio' required='' /></td>
                <td><input value='No' name='q2' type='radio' required='' /></td>
                </tr>
                
                
                <tr>
                <td style='font-size: small; text-align: justify;'>
                3.	Have you travelled outside the Philippines in the last 14 days?
                </td>
                <td><input value='Yes' name='q3' type='radio' required='' /></td>
                <td><input value='No' name='q3' type='radio' required='' /></td>
                </tr>
                
                
                <tr>
                <td style='font-size: small; text-align: justify;'>
                4.	Have you travelled outside the current city/municipality where you reside?
                </td>
                <td><input value='Yes' name='q4' type='radio' required='' /></td>
                <td><input value='No' name='q4' type='radio' required='' /></td>
                </tr>
                
                
                <tr>
                <td colspan='3' style='font-size: small; text-align: justify;'>
                5.	Do you currently have any of the following conditions during this time? Please check all that apply.
                
                <table style='width: 100%; margin-top: 8px;'>
                <tr>
                <td style='border: none;'>
                <input id='fever' name='q5_fever' type='checkbox' /> <label for='fever'>Fever</label>
                </td>
                
                <td style='border: none;'>
                <input id='cough' name='q5_cough' type='checkbox' /> <label for='cough'>Cough</label>
                </td>
                
                <td style='border: none;'>
                <input id='bpains' name='q5_bpains' type='checkbox' /> <label for='bpains'>Body Pains</label>
                </td>
                </tr>
                
                <tr>
                <td colspan='2' style='border: none;'>
                <input id='diff_breath' name='q5_dbreath' type='checkbox' /> <label for='diff_breath'>Difficulty in Breathing</label>
                </td>
                
                <td style='border: none;'>
                <input id='sore_throat' name='q5_sthroat' type='checkbox' /> <label for='sore_throat'>Sore Throat</label>
                </td>
                </tr>
                
                
                </table>
                
                </td>
                
                </tr>
                
                
                </tbody>
                
                </table>
         
                </div>
    
                <div class='input-group' style='margin-top: 12px;'>
                <button name='save_hdf_login' class='btn btn-success btn-sm' style='width: 100%; font-size: small;'><i class='fa fa-check-circle'></i> Login &amp; Save Data</button>
                </div>
                </form>
                
                </div>
                ";
                //END HEALTH DECLARATION FORM//
                }
            
                echo "</div>";
            
}
            
    
}

echo "</div>";


//END FULL RESULT LIST//    //END FULL RESULT LIST//    //END FULL RESULT LIST//





?>
            
        <script>
        //show search button
        document.getElementById('search_btn').style.display = 'inline-block';
        document.getElementById('search_load').style.display = 'none';
        
        document.getElementById("body_temp").focus();
        
        document.getElementById('profile_id').value = '';
        document.getElementById('body_temp').value = '';
        </script>
        
    <?php
    
    echo
    "<hr />
    <p id='reg_form_show' onclick='show_reg_panel()' style='margin-top: 12px;' class='text-info'>Profile not on list? <a href='#'>Click here to register</a>.</p>
    
    <p id='reg_form_hide' onclick='hide_reg_panel()' style='margin-top: 12px; display: none;'><a href='#' class='text-danger'>Click to cancel registration</a></p>";
    
    ?>
                
                <script>
                
                function show_reg_panel(){
                    
                    document.getElementById('register_panel').style.display = 'block';
                    document.getElementById('reg_form_hide').style.display = 'block';
                    document.getElementById('reg_form_show').style.display = 'none';
                    
                }
                
                function hide_reg_panel(){
                    
                    document.getElementById('register_panel').style.display = 'none';
                    document.getElementById('reg_form_hide').style.display = 'none';
                    document.getElementById('reg_form_show').style.display = 'block';
                    
                }
                
                </script>
                
    <?php
                
    echo
        "<div id='register_panel' style='display: none;'>
        
        <h3 class='text-info'>Registration Form</h3>
        
        <form method='POST' action='save_reg_login.php' style='width: 100%'; padding: 0px; margin: 0px;>
        
        <div class='input-group' style='margin-bottom: 12px; width: 100%'>
        
            <table style='width: 100%; margin-top: 8px;'>
            
            <tr>
            <td colspan='4' style='border: none;'>User Classification</td>
            </tr>
            
            <tr>
            <td style='border: none;'>
            <input onclick='show_emp_stud_idbox()' id='class_emp' name='member_class' type='radio' value='Employee' required='' /> <label for='class_emp'>Employee</label>
            </td>
            
            <td style='border: none;'>
            <input onclick='show_emp_stud_idbox()' id='class_stud' name='member_class' type='radio' value='Student' required='' /> <label for='class_stud'>Student</label>
            </td>
            
            <td style='border: none;'>
            <input onclick='show_sys_gen_idbox()' id='class_parent' name='member_class' type='radio' value='Parent/Guardian' required='' /> <label for='class_parent'>Parent/Guardian</label>
            </td>
            
            <td style='border: none;'>
            <input onclick='show_sys_gen_idbox()' id='class_visit' name='member_class' type='radio' value='Visitor' required='' /> <label for='class_visit'>Visitor</label>
            </td>
            </tr>
            
            </table>
            
        
        </div>
        
        <input name='last_idNum' value=".$new_id_num." class='form-control' type='hidden' />
        
        <div id='system_gen_id_code' style='margin-bottom: 12px; display: none;'>
        <div class='input-group'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-id-card'></i></span>
            </div>
            
            <input name='profile_id_sys_gen' value=".$final_idcode." class='form-control' readonly='' />
            
        </div>
        </div>
        
        <div id='emp_stud_id_code' style='margin-bottom: 12px; display: none;'>
        <div class='input-group'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-id-card'></i></span>
            </div>
            
            <input id='profile_id_emp_stud' name='profile_id_emp_stud' class='form-control' required='' placeholder='Enter your ID Code' />
            
        </div>
        </div>
        
        <div class='row' style='padding: 12px;'>
        <div class='input-group col-4' style='margin-bottom: 12px;'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-user'></i></span>
            </div>
            
            <input name='fname' class='form-control' required='' placeholder='First Name' />
            
        </div>
        
        <div class='input-group col-4' style='margin-bottom: 12px;'>
        
 
            
            <input name='mname' class='form-control' placeholder='Middle Name' />
            
        </div>
        
        <div class='input-group col-4' style='margin-bottom: 12px;'>
        
       
            
            <input name='lname' class='form-control' required='' placeholder='Last Name' />
            
        </div>
        </div>
        
        <div class='input-group' style='margin-bottom: 12px;'>
        
            <table style='width: 100%; margin-top: 8px;'>
            
            <tr>
            <td style='border: none; width: 50%; padding: 4px;'>Date of Birth</td>
            <td colspan='2' style='border: none; padding: 4px;'>Sex</td>
            </tr>
            
            <tr>
            <td style='border: none; padding: 4px;'>
            <input name='birth_date' class='form-control' type='date' required='' />
            </td>
            <td style='border: none; padding: 4px;'>
            <input id='male' name='sex' type='radio' value='Male' /> <label for='male'>Male</label>
            </td>
            
            <td style='border: none; padding: 4px;'>
            <input id='female' name='sex' type='radio' value='Female' /> <label for='female'>Female</label>
            </td>
            </tr>
            
            </table>
            
        </div>
        
        <div class='input-group' style='margin-bottom: 12px;'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-phone'></i></span>
            </div>
            
            <input name='phone_num' class='form-control' required='' placeholder='Enter 09 * * * * * * * * *' />
            
        </div>
        
        <div class='input-group' style='margin-bottom: 12px;'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-map-marker'></i></span>
            </div>
            
            <input name='city_municipal' class='form-control' required='' placeholder='Enter City/Municipality' />
            
        </div>
        
        <div class='input-group' style='margin-bottom: 12px;'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-map-marker'></i></span>
            </div>
            
            <input name='brgy' class='form-control' required='' placeholder='Enter Barangay' />
            
        </div>
        
        <div class='input-group' style='margin-bottom: 12px;'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-map-marker'></i></span>
            </div>
            
            <input name='street' class='form-control' placeholder='Enter Street/Sitio/Purok' />
            
        </div>
        <div class='input-group' style='margin-top: 12px;'>
        <button name='register_login' class='btn btn-success' style='width: 100%'>Register</button>
        </div>
        </form>
        </div>
        ";
        
    }else{
        
        ?>
            
        <script>
        //show search button
        document.getElementById('search_btn').style.display = 'inline-block';
        document.getElementById('search_load').style.display = 'none';
        
        document.getElementById("body_temp").focus();
        
        document.getElementById('profile_id').value = '';
        document.getElementById('body_temp').value = '';
        </script>
            
        <?php
        
        echo
        "<h3 class='text-info'>Registration Form</h3>
        
        <form method='POST' action='save_reg_login.php' style='width: 100%'; padding: 0px; margin: 0px;>
        
        <div class='input-group' style='margin-bottom: 12px; width: 100%'>
        
            <table style='width: 100%; margin-top: 8px;'>
            
            <tr>
            <td colspan='4' style='border: none;'>User Classification</td>
            </tr>
            
            <tr>
            <td style='border: none;'>
            <input onclick='show_emp_stud_idbox()' id='class_emp' name='member_class' type='radio' value='Employee' required='' /> <label for='class_emp'>Employee</label>
            </td>
            
            <td style='border: none;'>
            <input onclick='show_emp_stud_idbox()' id='class_stud' name='member_class' type='radio' value='Student' required='' /> <label for='class_stud'>Student</label>
            </td>
            
            <td style='border: none;'>
            <input onclick='show_sys_gen_idbox()' id='class_parent' name='member_class' type='radio' value='Parent/Guardian' required='' /> <label for='class_parent'>Parent/Guardian</label>
            </td>
            
            <td style='border: none;'>
            <input onclick='show_sys_gen_idbox()' id='class_visit' name='member_class' type='radio' value='Visitor' required='' /> <label for='class_visit'>Visitor</label>
            </td>
            </tr>
            
            </table>
            
        
        </div>
        
        <input name='last_idNum' value=".$new_id_num." class='form-control' type='hidden' />
        
        <div id='system_gen_id_code' style='margin-bottom: 12px; display: none;'>
        <div class='input-group'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-id-card'></i></span>
            </div>
            
            <input name='profile_id_sys_gen' value=".$final_idcode." class='form-control' readonly='' />
            
        </div>
        </div>
        
        <div id='emp_stud_id_code' style='margin-bottom: 12px; display: none;'>
        <div class='input-group'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-id-card'></i></span>
            </div>
            
            <input id='profile_id_emp_stud' name='profile_id_emp_stud' class='form-control' required='' placeholder='Enter your ID Code' />
            
        </div>
        </div>
        
        <div class='row' style='padding: 12px;'>
        <div class='input-group col-4' style='margin-bottom: 12px;'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-user'></i></span>
            </div>
            
            <input name='fname' class='form-control' required='' placeholder='First Name' />
            
        </div>
        
        <div class='input-group col-4' style='margin-bottom: 12px;'>
        
 
            
            <input name='mname' class='form-control' placeholder='Middle Name' />
            
        </div>
        
        <div class='input-group col-4' style='margin-bottom: 12px;'>
        
       
            
            <input name='lname' class='form-control' required='' placeholder='Last Name' />
            
        </div>
        </div>
        
        <div class='input-group' style='margin-bottom: 12px;'>
        
            <table style='width: 100%; margin-top: 8px;'>
            
            <tr>
            <td style='border: none; width: 50%; padding: 4px;'>Date of Birth</td>
            <td colspan='2' style='border: none; padding: 4px;'>Sex</td>
            </tr>
            
            <tr>
            <td style='border: none; padding: 4px;'>
            <input name='birth_date' class='form-control' type='date' required='' />
            </td>
            <td style='border: none; padding: 4px;'>
            <input id='male' name='sex' type='radio' value='Male' /> <label for='male'>Male</label>
            </td>
            
            <td style='border: none; padding: 4px;'>
            <input id='female' name='sex' type='radio' value='Female' /> <label for='female'>Female</label>
            </td>
            </tr>
            
            </table>
            
        </div>
        
        <div class='input-group' style='margin-bottom: 12px;'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-phone'></i></span>
            </div>
            
            <input name='phone_num' class='form-control' required='' placeholder='Enter 09 * * * * * * * * *' />
            
        </div>
        
        <div class='input-group' style='margin-bottom: 12px;'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-map-marker'></i></span>
            </div>
            
            <input name='city_municipal' class='form-control' required='' placeholder='Enter City/Municipality' />
            
        </div>
        
        <div class='input-group' style='margin-bottom: 12px;'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-map-marker'></i></span>
            </div>
            
            <input name='brgy' class='form-control' required='' placeholder='Enter Barangay' />
            
        </div>
        
        <div class='input-group' style='margin-bottom: 12px;'>
        
            <div class='input-group-append'>
            <span class='btn btn-primary' style='color: white;'><i class='fa fa-map-marker'></i></span>
            </div>
            
            <input name='street' class='form-control' placeholder='Enter Street/Sitio/Purok' />
            
        </div>
        <div class='input-group' style='margin-top: 12px;'>
        <button name='register_login' class='btn btn-success' style='width: 100%'>Register</button>
        </div>
        </form>
        ";
    
    ?>
    <script>
    
    function show_emp_stud_idbox(){
        document.getElementById('system_gen_id_code').style.display = 'none';
        document.getElementById('emp_stud_id_code').style.display = 'inherit';
        
        document.getElementById('profile_id_emp_stud').value = '';
        document.getElementById("profile_id_emp_stud").focus();
        
    }
    
    function show_sys_gen_idbox(){
        document.getElementById('system_gen_id_code').style.display = 'inherit';
        document.getElementById('emp_stud_id_code').style.display = 'none';
    }
    
    </script>
    <?php
    
    }
    
    $conn=null;
    
?>