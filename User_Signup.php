<?php
//Connect to the database
require 'Login.php';
$conn= new mysqli($hn,$un,$pw,$db);  
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST['UN']) && isset($_POST['PW']) && isset($_POST['RPW']) ){

  $Username=get_post($conn,'UN'); 
    
	//Randomly generated salts for salting each password 
	$length = 4; 
	$salt1 = substr(str_shuffle('0123456789!@#$%^&*ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
  $salt2 = substr(str_shuffle('0123456789!@#$%^&*ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
    
  //Server-Side Username and Password Validation
  $fail = validate_Username($Username);
  $fail .= validate_Password($_POST['PW']);
  $fail .= validate_RePassword($_POST['RPW'],$_POST['PW']);

    if($fail == ""){
    //Salting and Hashing the password. Plaintext password in not stored in the database or any variable
		$hashedPW=hash('ripemd128', get_post($conn,'RPW')); 
    $hashedPW=hash('ripemd128', $salt1.$hashedPW.$salt2); 
        
        //Storing User-Credentials in the database
        $query = "Create table IF NOT EXISTS Users( Username VARCHAR(12) NOT NULL,hashedPW VARCHAR(32) NOT NULL,salt1 char(4) , salt2 char(4) )";
        if(mysqli_query($conn, $query)){
            $query = "INSERT INTO Users (Username, hashedPW, salt1, salt2) VALUES
                       ('$Username', '$hashedPW','$salt1','$salt2')";
            
            if(mysqli_query($conn, $query)){
                echo alert_success("Account Successfully created");
            } 
            else{
                echo alert_fail("ERROR, Try Again");
            }
        }
      else{
        echo alert_fail("ERROR, Try Again"); 
      }
        // Close connection
        mysqli_close($conn);
  }
  else{
    echo alert_fail("ERROR, Try Again");
  }
}
//Server-Side Username validation
function validate_Username($username){
    if ($username == ""){ 
        return "No Username was entered.\n";
      }
      else if (strlen($username) < 5){
          return "Usernames must be at least 5 characters.\n";
      }
        else if (preg_match("/[^a-zA-Z0-9_-]/",$username)){
            return "Only a-z, A-Z, 0-9, - and _allowed in Usernames.\n";
      }
        return "";
}
//Server-Side Password validation
function validate_Password($password){
    if ($password == ""){
        return "No Password was entered.\n";
      }
        else if (strlen($password)< 6){
        return "Passwords must be at least 6 characters.\n";
      }
        else if (!preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/",($password))){
            return "Passwords require one each of a-z, A-Z and 0-9.\n";
      }
        return "";
}
//Server-Side Re-Password validation
function validate_RePassword($Repassword,$password){
  if ($Repassword == ""){
      return "No Re-Password was entered.\n";
    }
    else if ($Repassword != $password){
      return "Passwords must be the same.\n";
  }
   else{
    return "";
   }
}
function alert_success($msg) {
    echo "<script type='text/javascript'>alert('$msg');  
    window.location='User_Login.php';
    </script>";
}
function alert_fail($msg) {
    echo "<script type='text/javascript'>alert('$msg');
    </script>";
}
//Function to Sanitize user-input
function get_post($conn, $string)
 {
 if (get_magic_quotes_gpc()) 
         $string = stripslashes($string);
     return $conn->real_escape_string($_POST[$string]);
}
?>
<!DOCTYPE html>
<html>
<style>
body {
    background-image: url("cyber2.jpg");
    background-size: auto;
  }
</style>
<script type="text/javaScript">
    function validate(form) {
        fail="";
        fail = validateUsername(form.user.value)
        fail += validatePassword(form.pass.value)
        fail += validateRePassword(form.pass.value,form.rpass.value)
        if (fail == ""){
            return true
        }
		else { 
            alert(fail)
                return false
        }
}
// Client-Side Username validation
function validateUsername(field){
    if (field == ""){ 
      return "No Username was entered.\n"
    }
    else if (field.length < 5){
        return "Usernames must be at least 5 characters.\n"
    }
    else if (/[^a-zA-Z0-9_-]/.test(field)){
         return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n"
    }
    else 
        return "";
  }
  // Client-Side Password validation
  function validatePassword(field) {
    if (field == ""){
      return "No Password was entered.\n"
    }
      else if (field.length< 6){
        return "Passwords must be at least 6 characters.\n"
    }
      else if (!/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/.test(field)){
        return "Passwords require one each of a-z, A-Z, 0-9 and a special character.\n"
    }
    else
      return "";
  }
  // Client-Side Re-Password validation
  function validateRePassword(field1,field2) {
    if (field1 == ""){
      return "No Re Password was entered.\n"
    }
      else if (field1 != field2){
        return "Passwords must be the same.\n"
    }
     else
      return "";
  }
</script>
   <head>
     <title> PHP File Upload </title>
     <link rel="stylesheet" type="text/css" href="style.css">
   </head>
      <body>      
       <center>
        <div class="container">
            <form name="form" form method="post" action="" enctype="multipart/form-data" onsubmit= "return validate(this);">
                <div id="div_signup">
                <h1>SIGN UP</h1>
                <div>
                    <input type = "Text" class="textbox"   id = "user" name = "UN" placeholder="Username" > 
                    <input type = "Password" class="textbox" id = "pass" name = "PW" placeholder="Password" > 
                    <input type = "Password" class="textbox" id = "rpass" name = "RPW" placeholder="Re Password" > 
                </div>
                <div>
                    <input type="Submit" value="Sign up" />      
                </div>
                </div>
            </form>
        </div>
        </center>
      </body>
    </html>
    