<?php
    include("../config.php");
?>

<?php
     @header('Content-Type: application/json');
     @header("Access-Control-Allow-Origin: *");
     @header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers'); 
?>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $content = @file_get_contents('php://input');
        $json_data = @json_decode($content, true);
        $token = trim($json_data["token"]);
        $agent_id = trim($json_data["id"]);
    }
?>

<?php
    $query_SQL = "SELECT agent_token FROM agent WHERE agent_id = '".$agent_id."'";
    $query = @mysqli_query($conn, $query_SQL);
    $result_OBJ = @mysqli_fetch_array($query, MYSQLI_ASSOC);
    $num = @mysqli_num_rows($query);
    if ($num >0){  
        $agent_token = MD5(trim($result_OBJ["agent_token"]));
        if ($token == $agent_token){
            $result = "1";
        }else{
            $result = "0";
        }
    }else{
        $result  = "0";
    }
?>

<?php
    echo json_encode(array("result" => $result));
?>

<?php
    @mysqli_close($conn);
?>

<?php
    $ip = $_SERVER['REMOTE_ADDR'];
    $cdate = @date("d/m/y H:i:s");
    $cfdate = @date("d_m_y");
    $message_log = "\n".$cdate." ".$ip." content:".@$content."result:".@$result."\r\n";
    $ObjectFopen = @fopen("log/authen_token_".$cfdate. ".log","a+");
    @fwrite($ObjectFopen, $message_log);
    @fclose($ObjectFopen);
?>