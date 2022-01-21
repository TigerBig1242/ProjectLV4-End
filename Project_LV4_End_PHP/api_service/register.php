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
        $agent_id = trim($json_data["agent_id"]);
        $agent_name = trim($json_data["agent_name"]);
        $agent_email = trim($json_data["agent_email"]);
        $agent_password = trim($json_data["agent_password"]);
        $agent_gender = trim($json_data["agent_gender"]);
        $agent_tell = trim($json_data["agent_tell"]);
        $agent_address = trim($json_data["agent_address"]);
    }
?>

<?php
    $data = array();
    $Query_sql = "INSERT INTO agent (agent_id, agent_name, agent_email, agent_password, agent_gender, agent_tell, agent_address) VALUES ('".$agent_id."', '".$agent_name."', '".$agent_email."', '".$agent_password."', '".$agent_gender."', '".$agent_tell."', '".$agent_address."')";
    $query = @mysqli_query($conn, $Query_sql);
    if($query){
        $result = 1;
        $data[] = array("agent_id" => $agent_id, "agent_name" => $agent_name, "agent_email" => $agent_email, "agent_password" => $agent_password, "agent_gender" => $agent_gender, "agent_tell" => $agent_tell, "agent_address" => $agent_address);
        print_r($data);
        echo "insert success";
    }else{
        $result = 0;
        $data[] = array("agent_id" => null, "agent_name" => null, "agent_email" => null, "agent_password" => null, "agent_gender" => null, "agent_tell" => null, "agent_address" => null);
        echo "insert fail";
    }
    echo json_encode(array("result" => $result, "data" => $data));
    @mysqli_close($conn);
?>

<?php
     $ip = $_SERVER['REMOTE_ADDR'];
     $cdate = @date("d/m/Y H:i:s");
     $cfdate=@date("d_m_Y");
     $message_log = "\n".$cdate." ".$ip." content:".@$content." SQL:".@$Query_SQL. "result:".@$result."\r\n";
     $ObjectFopen=@fopen("log/register_".$cfdate.".log","a+");
     @fwrite($ObjectFopen,$message_log);
     @fclose($ObjectFopen);
?>

<?php
    exit;
?>