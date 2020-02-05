<?php
session_start();    
destroy_session_and_data();
echo '<br>'."<div id='body'><center><b> You have been Logged out successfully</center></div>";
    echo <<<_END
    <center>
    <br><br>
    <a href="HomePage.php" class="myButton">Click here to go to the Home Page</a> <br><br>
    </center>
_END;
function destroy_session_and_data()
	{	// Delete all the information in the array
        $_SESSION = array();	
        session_destroy();
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
    font-size: 20px;
    letter-spacing: 2px;
    word-spacing: 2px;
    color: #FFFFFF;
    font-weight: 400;
    text-decoration: none;
    font-style: normal;
    font-variant: normal;
    text-transform: none;
}
#body2 {
    font-family: sans-serif;
    font-size: 20px;
    letter-spacing: 2px;
    word-spacing: 2px;
    color: #FF0000;
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
    font-size:20px;
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
.right {
    float: right;
    width: 300px;
}
</style>
_END;
?>