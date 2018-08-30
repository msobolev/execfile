<?php
require('../functions.php');
require('../config.php');
com_db_connect_hre2() or die('Unable to connect to database server!');


if(isset($_GET['site']) && $_GET['site'] != '')
    $site_clause = " and site = '".$_GET['site']."'";


$sql_query = "select * from exec_user as u,exec_alert as a,hre_alert_send_info as s where a.user_id = u.user_id and a.alert_id = s.alert_id $site_clause order by u.user_id desc,sent_date desc";
echo "<br>sql_query:".$sql_query;
// die();
$exe_query = com_db_query($sql_query);
$num_rows = com_db_num_rows($exe_query);


?>


<table>
    <tr>
        <td colspan="4"><strong><?=$_GET['site']?></strong></td>
    </tr>
    
    <tr>
        
        <td width="120">Alert Creation</td>
        <td width="300">User Email</td>
        <td width="240">Send Date</td>
        <td width="200">Alert Link</td>
    </tr> 
    
    <?PHP
    while($alert_row = com_db_fetch_array($exe_query))
    {
    
    ?>
    <tr>
        <td><?=$alert_row['add_date']?></td>
        <td><?=$alert_row['email']?></td>
        <td><?=date('d M Y H:i:s',$alert_row['sent_date'])?></td>
        <td><a href="http://www.execfile.com/alert-email-show.php?emailid=<?=$alert_row['email_id']?>">http://www.execfile.com/alert-email-show.php?emailid=<?=$alert_row['email_id']?></a></td>
    </tr>    
    <?PHP
    }
    ?>
</table>