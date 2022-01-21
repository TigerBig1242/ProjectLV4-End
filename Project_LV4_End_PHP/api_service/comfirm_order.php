<?php
    include("../config.php");
?>

<?php
    @header('Content-Type: application/json');
    @header("Access-Control-Allow-Origin: *");
    @header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
?>

<?php
    
?>




<?php
     $ip = $_SERVER['REMOTE_ADDR'];
     $cdate = @date("d/m/Y H:i:s");
     $cfdate=@date("d_m_Y");
     $message_log = "\n".$cdate." ".$ip." content:".@$content." SQL:".@$Query_SQL. "result:".@$result."\r\n";
     $ObjectFopen=@fopen("log/comfirm_order".$cfdate.".log","a+");
     @fwrite($ObjectFopen,$message_log);
     @fclose($ObjectFopen);
?>
