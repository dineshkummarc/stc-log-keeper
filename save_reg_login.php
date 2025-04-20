
        <?php
    
        include('dbcon.php');
    
        if(isset($_POST['register_login'])){
        
        $member_class=$_POST['member_class'];
        
        if($member_class==='Employee' OR $member_class==='Student'){
            
            $profile_id=strtoupper($_POST['profile_id_emp_stud']);
            
        }else{
            
            $profile_id=strtoupper($_POST['profile_id_sys_gen']);
            
            $new_id_num=$_POST['last_idNum'];
        
            $updIDCodeGen = 'UPDATE idcode_gen SET last_idNum = :last_idNum WHERE dept = :dept';
            $conn->prepare($updIDCodeGen)->execute(['last_idNum' => $new_id_num, 'dept' => 'Visitor']);
        
        }
        
        
        
        $lname=strtoupper($_POST['lname']);
        $fname=strtoupper($_POST['fname']);
        $mname=strtoupper($_POST['mname']);
        
        $birth_date = $_POST['birth_date'];
        
        $today = date("Y-m-d");
        $diff = date_diff(date_create($birth_date), date_create($today));
        $age=$diff->format('%y');
     
        $sex=$_POST['sex'];
        
        $phone_num=$_POST['phone_num'];
        $city_municipal=strtoupper($_POST['city_municipal']);
        $brgy=strtoupper($_POST['brgy']);
        $street=strtoupper($_POST['street']);
        
        
        
        //save to personnel logs
        $save_register_login = "INSERT INTO members(profile_id, lname, fname, mname, birth_date, age, sex, phone_num, city_municipal, brgy, street, member_class)
        VALUES ('$profile_id', '$lname', '$fname', '$mname', '$birth_date', '$age', '$sex', '$phone_num', '$city_municipal', '$brgy', '$street', '$member_class')";
        $conn->exec($save_register_login);
        //end save to personnel logs 
        
        $conn=null;
                
        ?>
        
        <script>
        window.location='log_keeper.php?pid=<?php echo $profile_id; ?>&remarks=NEW&logtime=';
        </script>
        
        <?php } ?>
        
        <?php
        
        if(isset($_POST['save_hdf_login'])){
            
        $member_id=$_POST['member_id'];
        
        $chk_lrn_query = $conn->prepare('SELECT * FROM members WHERE member_id = :member_id');
        $chk_lrn_query->execute(['member_id' => $member_id]);
        $chk_lrn_row = $chk_lrn_query->fetch();
    
        $body_temp=$_POST['body_temp'];
        
        $q1=$_POST['q1'];
        $q2=$_POST['q2'];
        $q3=$_POST['q3'];
        $q4=$_POST['q4'];
        
        if(isset($_POST['q5_fever'])){
            $q5_fever='Yes';
        }else{
            $q5_fever='None';
        }
        
        if(isset($_POST['q5_cough'])){
            $q5_cough='Yes';
        }else{
            $q5_cough='None';
        }
        
        if(isset($_POST['q5_bpains'])){
            $q5_bpains='Yes';
        }else{
            $q5_bpains='None';
        }
        
        if(isset($_POST['q5_dbreath'])){
            $q5_dbreath='Yes';
        }else{
            $q5_dbreath='None';
        }
        
        if(isset($_POST['q5_sthroat'])){
            $q5_sthroat='Yes';
        }else{
            $q5_sthroat='None';
        }
        
         
        
        //save to personnel logs
        $save_register_login = "INSERT INTO tbl_daily_hdf(member_id, date_mm, date_dd, date_yyyy, q1, q2, q3, q4, q5_fever, q5_cough, q5_dbreath, q5_bpains, q5_sthroat)
        VALUES ('$member_id', '$date_mm', '$date_dd', '$date_yyyy', '$q1', '$q2', '$q3', '$q4', '$q5_fever', '$q5_cough', '$q5_dbreath', '$q5_bpains', '$q5_sthroat')";
        $conn->exec($save_register_login);
        //end save to personnel logs 
        
        $saveNewLog = "INSERT INTO tbl_attendance(member_id, body_temp, date_mm, date_dd, date_yyyy, log_time, action)
        VALUES ('$member_id', '$body_temp', '$date_mm', '$date_dd', '$date_yyyy', '$currentTime', 'IN')";
        $conn->exec($saveNewLog);
        
        $conn=null;
                
        ?>
        
        <script>
        window.location='log_keeper.php?pid=<?php echo $member_id; ?>&remarks=IN&logtime=<?php echo $currentTime; ?>';
        </script>
        
        <?php } ?>