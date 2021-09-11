<?php


      $dbserver = "localhost";

      $dbuser = "id16891710_mskdev";

      $dbpass = "Developer-Msk-781";

      $dbname = "id16891710_dev_database";

      $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);
    
    error_reporting(0);

    if(!mysqli){
        echo "Connection failed: ".mysqli_error($mysql);
        exit();
    }
    
    session_start(); 
    
    if (isset($_POST['email']) && isset($_POST['pass'])) {
    
        function validate($data){
           $data = trim($data);
           $data = stripslashes($data);
           $data = htmlspecialchars($data);
           return $data;
        }
    
        $uname = validate($_POST['email']);
        $pass = $_POST['pass'];
    
        if (empty($uname)) {
            
            showMessage("email is required",0);

        }else if(empty($pass)){
         
            showMessage("Password is required",0);

        }else{
            
            //  $pass = hash('sha256', $pass);
            //  $pass = crypt( $pass,'sha256');
            
            $sql = "SELECT * FROM users WHERE email='$uname'";
    
            $result = mysqli_query($mysql, $sql);
    
            if ($result->num_rows == 1) {

                $row = mysqli_fetch_assoc($result);
                //$pass= crc32($pass, 'sha256');

                if ($row['email'] === $uname && password_verify($pass, $row['password'])) {
                                
                    $myArr = array("sha256"=>$sha256,"response"=>"OK","status"=>"1");

                    $sha256= crypt(json_encode($row) , 'sha256');
                    
                    $myArr = array_merge($row, $myArr);
                        
                    $myJSON = json_encode($myArr);
                        
                    echo $myJSON;
                    
                    exit();
                }else{
                    
                    showMessage("Incorect password",0);

                }
            }else{
                
                showMessage("No User Found",0);

            }
        }
        
    }else{
    
        showMessage("ERR_NOT_FOUND",0);
      
    }


function showMessage($response,int $status) 
{
    echo json_encode(array("response" => $response, "status" => $status));  
    exit();
}

?>