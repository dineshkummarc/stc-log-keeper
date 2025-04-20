    <?php include('dbcon.php'); ?>

    <?php
    
    if(isset($_POST['save_login'])){
        
        $member_id=$_POST['member_id'];
        $body_temp=$_POST['body_temp'];
        
        $saveNewLog = "INSERT INTO tbl_attendance(member_id, body_temp, date_mm, date_dd, date_yyyy, log_time, action)
        VALUES ('$member_id', '$body_temp', '$date_mm', '$date_dd', '$date_yyyy', '$currentTime', 'IN')";
        $conn->exec($saveNewLog);
                
    ?>
    
    <script>
    
    window.location='log_keeper.php?pid=<?php echo $member_id; ?>&remarks=IN&logtime=<?php echo $currentTime; ?>';
    
    </script>
    
    <?php } ?>
    
    
    
    <?php 
    
    if(isset($_POST['save_logout'])){
        
        $member_id=$_POST['member_id'];
        $ref_log_id=$_POST['ref_log_id'];
        
        $saveNewLog = "INSERT INTO tbl_attendance(member_id, date_mm, date_dd, date_yyyy, log_time, action, ref_log_id)
        VALUES ('$member_id', '$date_mm', '$date_dd', '$date_yyyy', '$currentTime', 'OUT', '$ref_log_id')";
        $conn->exec($saveNewLog);
            
        $conn=null;

    ?>
    
    <script>
    
    window.location='log_keeper.php?pid=<?php echo $member_id; ?>&remarks=OUT&logtime=<?php echo $currentTime; ?>';
    
    </script>
    
    <?php } ?>
    