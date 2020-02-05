<?php
session_start();
// Checking for 'User' session
if (isset($_SESSION['Username'])){
    $Username=$_SESSION['Username'];
    // Check to prevent Session Hijacking  
    if ($_SESSION['Check'] == hash('ripemd128',$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {
        echo "<div id='heading'><center><b>Welcome Back ".$Username."</center></b></div>".'<br>';
        date_default_timezone_set('America/Los_Angeles');
        echo "<center><div id='body'>Today's date is : ".date('d/m/Y')."</div></center>";
        echo <<<_END
        <center>
        <br><br>
        <a href="Decryptoid.php" class="myButton">Click here for the Decryptoid</a> <br><br>
        <a href="Logout.php" class="myButton">Click here to Logout</a>
        </center>
    _END;
    }
    else{
        echo '<br>'."<div id='body'><center>We apologize for the incovinience.".'<br>'.'<br>'."<a href='User_Login.php' class='myButton'>Click here to log in again.</center></div>";
    }
}
else{
    echo '<br>'."<div id='body'><center>We apologize for the incovinience.".'<br>'.'<br>'."<a href='User_Login.php' class='myButton'>Click here to log in again.</center></div>";
}
echo <<<_END
<style>
body {
    background-image: url("cyber2.jpg");
    background-size: auto;
  }

#heading {
    font-family: Impact, Charcoal, sans-serif;
    font-size: 60px;
    letter-spacing: 2px;
    word-spacing: 2px;
    color: #FFFFFF;
    font-weight: 400;
    text-decoration: none;
    font-style: normal;
    font-variant: normal;
    text-transform: none;
}
#body {
    font-family: sans-serif;
    font-size: 30px;
    letter-spacing: 2px;
    word-spacing: 2px;
    color: #FFFFFF;
    font-weight: 400;
    text-decoration: none;
    font-style: normal;
    font-variant: normal;
    text-transform: none;
}
.myButton {
    box-shadow:inset 0px 1px 0px 0px #f5978e;
    background:linear-gradient(to bottom, #f24537 5%, #c62d1f 100%);
    background-color:#f24537;
    border-radius:6px;
    border:1px solid #d02718;
    display:inline-block;
    cursor:pointer;
    color:#ffffff;
    font-family:Arial;
    font-size:30px;
    font-weight:bold;
    padding:6px 24px;
    text-decoration:none;
    text-shadow:0px 1px 0px #810e05;
}
.myButton:hover {
    background:linear-gradient(to bottom, #c62d1f 5%, #f24537 100%);
    background-color:#c62d1f;
}
.myButton:active {
    position:relative;
    top:1px;
}
</style>
_END;
?>