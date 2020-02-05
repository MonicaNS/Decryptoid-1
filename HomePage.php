<?php
echo <<<_END
<style>
body {
    background-image: url("cyber2.jpg");
    background-size: auto;
}
#heading {
    font-family: Impact, Charcoal, sans-serif;
    font-size: 100px;
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
    font-family: Impact, Charcoal, sans-serif;
    font-size: 40px;
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
<b>
<center>
<div id="heading">Decryptoid</div> <br><br><br><br>
<a href="User_Login.php" class="myButton">Click here to Login</a> <br><br>
<a href="User_Signup.php" class="myButton">Click here to SignUp</a>
</center>
_END;
?>

