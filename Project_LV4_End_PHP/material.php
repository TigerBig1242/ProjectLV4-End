<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Material</title>
</head>
    <body onload="authen()">
        <div id="form_add_material" align="center">
            <form id="add_material" name="add_material" action="#" method="POST" enctype="multipart/form-data">
            <table border="1px">
                <tr>
                    <td>TYPE
                        <div><input type="text" id="type_material" name="type_material" placeholder="material"></div>
                    </td>
                    <td>PRICE
                        <div><input type="text" id="price" name="price" placeholder="price"></div>
                    </td>
                    <td>AMOUNT
                        <div><input type="text" id="amount" name="amount" placeholder="amount"></div>
                    </td>
                    <div><label id="submit_logout" name="submit_logout" onclick="logout()">[LOGOUT]</label></div>
                    <div><label id="submit_add_material" name="submit_add_material" onclick="Add_Material()">[ADDMATERIAL]</label></div>
                </tr>
            </table>
            </form>
        </div>

    <!-- <div id="form_add_material" style="display:none">
        <form id="add_material" name="add_material" action="#" method="POST" enctype="multipart/form-data">


        </form>

    </div> -->
    </body>
</html>

<script type="text/javascript">
    function authen(){
        var token = localStorage.getItem("token", token);
        if (token == null){
            logout();
            window.location.replace("login.php");
        }else if(token == "Undefind"){
            logout();
            window.location.replace("login.php");
        }else if(token == ""){
            logout();
            //alert(token);
            window.location.replace("login.php");
        }
        else{
            
        }
        var agent_profile = JSON.parse(localStorage.getItem("agent_profile"));
        if (agent_profile == null || token == "Undefined" || token == ""){
            logout();
            window.location.replace("login.php");
        }else{
            //alert(agent_profile.id);
            var id = agent_profile.id;
        }
        $.ajax({
            type:"POST",
            url:"http://127.0.0.1/Project_LV4_End_PHP/api_service/authen_token.php",
            async:false,
            data:JSON.stringify({
                "token":token,
                "id":id
            }),success(response){
                //alert("Token complete");
                var result = response.result;
                alert(result);
                if (result == 1){
                    //stay here
                }else{
                    window.location.replace("login.php");
                    localStorage.removeItem("token");
                    localStorage.removeItem("agent_profile");
                }
            },error:function(request, status, error){
                //alert(request.responseText);
                window.location.replace("login.php");
                localStorage.removeItem("token");
                localStorage.removeItem("agent_profile");
            }
        });
    }
    
    function Add_Material(){
        //alert("success");
        var type_material = document.getElementById("type_material").value;
        var price = document.getElementById("price").value;
        var amount = document.getElementById("amount").value;
        $.ajax({
            type: "POST",
            url: "http://127.0.0.1/Project_LV4_End_PHP/api_service/add_goods.php",
            async: false,
            data :JSON.stringify({ 
                "type_material":type_material,
                "price":price,
                "amount":amount,
            }),success:function(response){
                    alert("Add Material Success");
                    document.getElementById("form_add_material");
                    location.reload();      
            },error:function(request, status, error){
                alert(request.responseText);
            }
        });
    }

    function logout(){
        window.location.replace("login.php");
        localStorage.removeItem("token");
        localStorage.removeItem("agent_profile");
    }
</script>