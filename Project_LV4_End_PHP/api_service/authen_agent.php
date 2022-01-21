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
        $username = trim($json_data["username"]);
        $password = trim($json_data["password"]);
    }
?>

<?php
    $query_SQL = "SELECT agent_id, agent_name, agent_email, agent_password, agent_gender FROM agent WHERE agent_email = '".$username."'";
    $query = @mysqli_query($conn, $query_SQL);   
    $result_OBJ = @mysqli_fetch_array($query, MYSQLI_ASSOC);
   //print_r($result_OBJ);
    $num = @mysqli_num_rows($query);
    $agent_password = trim(@$result_OBJ["agent_password"]);
    if($password == $agent_password){
        $result = "1";
        $agent_id = trim(@$result_OBJ["agent_id"]);
        $agent_name = trim(@$result_OBJ["agent_name"]);
        $agent_email = trim(@$result_OBJ["agent_email"]);
        $agent_gender = trim(@$result_OBJ["agent_gender"]);
        $plain_text = date("YmdHis").$agent_email;
        $token = MD5($plain_text);
        $query_SQL = "UPDATE agent SET agent_token = '".$plain_text."' WHERE agent_id = '".$agent_id."'";
        $query = @mysqli_query($conn, $query_SQL);
    }else{
        $result = "0";
        $agent_id = null;
        $agent_name =  null;
        $agent_email =  null;
        $agent_gender =  null;
        $token =  null;
    }
?>

<?php
    echo json_encode(array("result" => $result, "id" => $agent_id, "name" => $agent_name, "email" => $agent_email, "gender" => $agent_gender, "token" => $token));
?> 

<?php
    @mysqli_close($conn);
?>

<?php
    $ip = $_SERVER['REMOTE_ADDR'];
    $cdate = @date("d/m/y H:i:s");
    $cfdate = @date("d_m_y");
    $message_log = "\n".$cdate." ".$ip." content:".@$content."result_OBJ:".print_r(@$result_OBJ,true)."num:".@$num. "result:".@$result."\r\n";
    $ObjectFopen = @fopen("log/authen_agent_".$cfdate. ".log","a+");
    @fwrite($ObjectFopen, $message_log);
    @fclose($ObjectFopen);
?>