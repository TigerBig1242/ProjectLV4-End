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
        //$id = trim(@$json_data["id"]);
        $sale_no = trim(@$json_data["sale_no"]);
        $type_material = trim(@$json_data["type_material"]);
        $price = trim(@$json_data["price"]);
        $amount = trim(@$json_data["amount"]);
    }
    else{
        echo "Unknow Method";
    }
?>

<?php
    $data =array();
    $Query_SQL = "INSERT INTO offer_sale (sale_no, type_material, price, amount) VALUES ('".$sale_no."', '".$type_material."', '".$price."', '".$amount."')";
    //$str_SQL = "INSERT INTO offer_sale(type_material, price, amount) VALUES ('".$type_material."', '".$price."', '".$amount."') SELECT offer_sale.type_material, offer_sale.price, offer_sale.amount
                    //FROM agent INNER JOIN offer_sale ON agent.agent_id = offer_sale.sale_no";
    $query = @mysqli_query($conn, $Query_SQL);
    if($query){
        $result = 1;
        $data[]  = array("sale_no" => $sale_no, "type_material" => $type_material, "price" => $price, "amount" => $amount);
        //echo "insert success";
    }
    else{
        $result = 0;
        $data[]  = array("sale_no" => null, "type_material" => null, "price" => null, "amount" => null);
        //echo "insert failed";
    }
    echo json_encode(array("result" => $result, "data" => $data));
    @mysqli_close($conn);
?>
<?php
     $ip = $_SERVER['REMOTE_ADDR'];
     $cdate = @date("d/m/Y H:i:s");
     $cfdate=@date("d_m_Y");
     $message_log = "\n".$cdate." ".$ip." content:".@$content." SQL:".@$Query_SQL. "result:".@$result."\r\n";
     $ObjectFopen=@fopen("log/add_goods".$cfdate.".log","a+");
     @fwrite($ObjectFopen,$message_log);
     @fclose($ObjectFopen);
?>

<?php
    exit;
?>