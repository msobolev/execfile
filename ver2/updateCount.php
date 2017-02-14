<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include("config.php");
include("functions.php");

$last_move_id = $_POST['last_move_id'];
$last_speaking_id = $_POST['last_speaking_id'];
$last_media_id = $_POST['last_media_id'];
$last_publication_id = $_POST['last_publication_id'];
$last_award_id = $_POST['last_award_id'];
$last_funding_id = $_POST['last_funding_id'];
$last_job_id = $_POST['last_job_id'];

echo "<br>last_media_id: ".$last_media_id;

com_db_connect() or die('Unable to connect to database server!');


com_db_query("DELETE FROM ".TABLE_SESSION_COUNT." where user_id = ".$_SESSION['sess_user_id']);

if($last_move_id != '')
{    
    
    echo "<br>DELETE FROM ".TABLE_COUNT." where user_id = ".$_SESSION['sess_user_id']." and record_type = 'movement'";
    echo "<br>INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('movement','".$_SESSION['sess_user_id']."','".$last_move_id."')";
    
    com_db_query("DELETE FROM ".TABLE_COUNT." where user_id = ".$_SESSION['sess_user_id']." and record_type = 'movement'");
    com_db_query("INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('movement','".$_SESSION['sess_user_id']."','".$last_move_id."')");	
}


if($last_speaking_id != '')
{    
    com_db_query("DELETE FROM ".TABLE_COUNT." where user_id = ".$_SESSION['sess_user_id']." and record_type = 'speaking'");
    com_db_query("INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('speaking','".$_SESSION['sess_user_id']."','".$last_speaking_id."')");	
}  


if($last_media_id != '')
{    
    //echo "<br>INSERT Q: INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('media','".$_SESSION['sess_user_id']."','".$last_media_id."')";
    com_db_query("DELETE FROM ".TABLE_COUNT." where user_id = ".$_SESSION['sess_user_id']." and record_type = 'media'");
    com_db_query("INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('media','".$_SESSION['sess_user_id']."','".$last_media_id."')");	
}

if($last_publication_id != '')
{    
    //echo "<br>INSERT Q: INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('media','".$_SESSION['sess_user_id']."','".$last_media_id."')";
    com_db_query("DELETE FROM ".TABLE_COUNT." where user_id = ".$_SESSION['sess_user_id']." and record_type = 'publication'");
    com_db_query("INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('publication','".$_SESSION['sess_user_id']."','".$last_publication_id."')");	
} 

if($last_award_id != '')
{    
    //echo "<br>INSERT Q: INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('media','".$_SESSION['sess_user_id']."','".$last_media_id."')";
    com_db_query("DELETE FROM ".TABLE_COUNT." where user_id = ".$_SESSION['sess_user_id']." and record_type = 'awards'");
    com_db_query("INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('awards','".$_SESSION['sess_user_id']."','".$last_award_id."')");	
} 

if($last_job_id != '')
{    
    //echo "<br>INSERT Q: INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('media','".$_SESSION['sess_user_id']."','".$last_media_id."')";
    com_db_query("DELETE FROM ".TABLE_COUNT." where user_id = ".$_SESSION['sess_user_id']." and record_type = 'jobs'");
    com_db_query("INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('jobs','".$_SESSION['sess_user_id']."','".$last_job_id."')");	
} 

if($last_funding_id != '')
{    
    //echo "<br>INSERT Q: INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('media','".$_SESSION['sess_user_id']."','".$last_media_id."')";
    com_db_query("DELETE FROM ".TABLE_COUNT." where user_id = ".$_SESSION['sess_user_id']." and record_type = 'funding'");
    com_db_query("INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('funding','".$_SESSION['sess_user_id']."','".$last_funding_id."')");	
} 

$_SESSION['mark_read_clicked'] = 1;
?>
