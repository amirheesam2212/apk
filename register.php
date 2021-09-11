<?php
      

    $dbserver = "localhost";

      $dbuser = "id16891710_mskdev";

      $dbpass = "Developer-Msk-781";

      $dbname = "id16891710_dev_database";

      $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);

 
  if($mysql->connect_error){

    echo "Connection failed: ". $mysql->connect_error;
    exit();

  }

    error_reporting(0);
    
    if (!empty($_POST['email']) && !empty($_POST['pass'])
        && !empty($_POST['name']) && !empty($_POST['rpass'])) {
    
        function validate($data){
           $data = trim($data);
           $data = stripslashes($data);
           $data = htmlspecialchars($data);
           return $data;
        }

        $uname = validate($_POST['email']);
        $pass = validate($_POST['pass']);
    
        $re_pass = validate($_POST['rpass']);
        $name = validate($_POST['name']);
        
    
        if (empty($uname)) {
            
            showMessage("email is required",0);

        }else if(empty($pass)){
            
            showMessage("Password is required",0);

        }
        else if(empty($re_pass)){
            
            showMessage("Re Password is required",0);

        }
    
        else if(empty($name)){
            
            showMessage("Name is required",0);
    
        }
    
        else if($pass !== $re_pass){
            
            showMessage("The confirmation password  does not match",0);
        }
    
        else{
    
            // hashing the password
            $pass = password_hash($pass, PASSWORD_DEFAULT);
    
            $sql = "SELECT * FROM users WHERE email='$uname' ";
            $result = mysqli_query($mysql, $sql);
    
            if (mysqli_num_rows($result) > 0) {
                
                showMessage("The account already exists",0);

            }else {
                
                
                $sql2 = "INSERT INTO `users`
                (
                    `email`, `password`, `name`
                )
                VALUES
                (
                    '$uname', '$pass', '$name'
                )";
                
               $result2 = mysqli_query($mysql, $sql2);
               if ($result2) {
                 
                showMessage("Your account has been created successfully",1);
                
              
               }else {
                    
                    showMessage("unknown error occurred, ".$mysql->error."" ,0);
                    
               }
            }
        }
        
    }else{
        
        showMessage("Access Denied!" ,0);
    }
  
  
function showMessage($response,int $status) 
{
    echo json_encode(array("response" => $response, "status" => $status));  
    exit();
}

       
    ?>