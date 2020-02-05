<?php
//Connect to the database
require 'Login.php';
$conn= new mysqli($hn,$un,$pw,$db); 
if($conn === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST['UN']) && isset($_POST['PW']) ){
  $Username=get_post($conn,'UN');
  // Query to exract salt1,salt2 and the hashed password from the database
  $query= "Select * from Users where Username= '$Username'";
  $result = $conn->query($query);
  if(mysqli_query($conn, $query)){
    $rows = $result->num_rows;
    for ($j = 0 ; $j < $rows ; ++$j){
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $salt1=$row['salt1'];
        $salt2=$row['salt2'];
        $hashedPW_Stored=$row['hashedPW'];
    }
    // Hashing the password entered by the user 
    $hashedPW_Entered=hash('ripemd128', get_post($conn,'PW'));
    $hashedPW_Entered=hash('ripemd128', $salt1.$hashedPW_Entered.$salt2);

    //Verifying the password
    if($hashedPW_Entered == $hashedPW_Stored){
      ini_set('session.gc_maxlifetime', 60 * 60 * 60);
      session_start();
      $_SESSION['Username']=$Username;
      // Store user IP Address and user agent string to identify them by type and version of device and browser to prevent session Hijacking
      $_SESSION['Check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
      session_write_close();
      echo alert_success("Login Successful");
    }
    else {
    echo alert_fail("Invalid Username/Password Combination.");
    }  
 }
}
function alert_success($msg) {
    echo "<script type='text/javascript'>alert('$msg');  
    window.location='Continue.php';
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
<script src="clientSide_validation.js"></script>
   <head>
     <title> PHP File Upload </title>
     <link rel="stylesheet" type="text/css" href="style.css">
   </head>
      <body>      
       <center>
        <div class="container">
            <form method="post" action="" enctype="multipart/form-data">
                <div id="div_signup">
                <h1>LOGIN </h1>
                <div>
                    <input type = "Text" class="textbox" name = "UN" placeholder="Username"> 
                    <input type = "Password" class="textbox" name = "PW" placeholder="Password"> 
                </div>
                <div>
                    <input type="submit" value="Login">      
                </div>
                </div>
            </form>
        </div>
        </center>
      </body>
    </html>
