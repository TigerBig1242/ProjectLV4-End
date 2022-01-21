<?php
    include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>ComfirmOrder</title>
</head>
<body>
    <div align="cemter"><h1>ข้อมูลรับซื้อยางก้อน</h1>
        <table align="center" border="1px">
            <tr>
                <td>ชื่อ</td>
                <td>ประเภท</td>
                <td>ราคา</td>
                <td>จำนวน</td>
                <td>สถานะ</td>
            </tr>
            <?php
                //$data = array();
                $Query_SQL = "SELECT agent.agent_name, offer_sale.type_material, price, amount, status FROM offer_sale LEFT JOIN agent ON offer_sale.sale_no = agent.agent_id";
                $query = @mysqli_query($conn, $Query_SQL);
                while($result_OBJ = @mysqli_fetch_array($query, MYSQLI_ASSOC)){
                    $agent_name = array($result_OBJ["agnet_name"]);
                    $type_material = $result_OBJ["type_material"];
                    $price = $result_OBJ["price"];
                    $amount = $result_OBJ["amount"];
                    $status = $result_OBJ["status"];
                    
                    
                    echo "<tr>";
                        echo "<td>".$agent_name."</td>";
                        echo "<td>".$type_material."</td>";
                        echo "<td>".$price."</td>";
                        echo "<td>".$amount."</td>";
                        echo "<td>".$status."</td>";
                    echo "</tr>";
                }
            ?> 

            <?php
                echo json_encode(array("agent_name" => $agent_name, "type_material" => $type_material, "price" => $price, "amount" => $amount, "status" => $status));
            ?>
        </table>
    </div>
</body>
</html>