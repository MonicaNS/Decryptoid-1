<?php
session_start();
//Session Regeneration to prevent Session Fixation
if (!isset($_SESSION['initiated'])) 
	{
		session_regenerate_id();
		$_SESSION['initiated'] = 1;
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
    font-size:17px;
    font-weight:bold;
    padding:4px 10px;
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
    width: 250px;
}
</style>
_END;

if (isset($_SESSION['Username'])){
    // Check to prevent Session Hijacking  
    if ($_SESSION['Check'] == hash('ripemd128',$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {
        require 'Login.php';
        $conn= new mysqli($hn,$un,$pw,$db); 
        if($conn === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        echo <<<_END
        <center>
        <div id="heading"> Encrypt or Decrypt your Data </div> 
        </center>
        <div class="right"><a href="Logout.php" class="myButton">Click here to Logout</a></div>
        <br><br>
            <form action=" " method="POST" enctype="multipart/form-data">
            <center>
            <div id="body">  Select Cipher: 
            <select id ="ciphers" name ="ciphers">
                    <option value = "Simple Substitution">Simple Substitution</option>
                    <option value = "Double Transposition">Double Transposition</option>
                    <option value = "RC4">RC4</option>
                </select>
                Select Type: <select id ="type" name="type">
                    <option name ="Encrypt">Encrypt</option>
                    <option name = "Decrypt">Decrypt</option>
                </select>
            <br>
            <div>
                <p>Enter your text below:</p>
                <textarea rows="10 cols="200" width="auto" name="text"></textarea><br>
                <p>OR</p>
            <p>Upload a text file below:</p>
        <input type='file' name='fileToUpload' id='fileToUpload'><br><br>
        </div>
            <input type = "Submit" name ="textbox" value="Encrypt/Decrypt Textbox"/>
            <input type = "Submit" name ="textfile" value="Encrypt/Decrypt File"/>
            <h3>Output:</h3>
            </center>
        </form>
        _END;
        //Input from text box
        if (isset($_POST['textbox'])){
            if(strlen($_POST['text'])!=0){
                $text = get_post($conn, $_POST['text']);
                start($text, $conn, true);
            }
        }

        //Input from a text file
        else if (isset($_POST['textfile'])) {
            if ($_FILES['filename']['tmp_name'] == 'text/plain') {

                $name = $_FILES['filename']['name'];
                move_uploaded_file($_FILES['filename']['tmp_name'],$name);

                // Check file type, exit if not .txt
                check_ext($name);   
                echo "<center>Your file has been uploaded</center>";

                // Reading the contents of the file into a string 
                $text = get_post($conn, file_get_contents($name));
                start($text, $conn, false);
            } 
            else {
                echo "This file is not a text file. Please try again" . "<br>";
            }
        }
    }
    else{
        echo '<br>'."<div id='body'><center>We apologize for the incovinience.".'<br>'.'<br>'."<a href='User_Login.php' class='myButton'>Click here to log in again.</center></div>";
    }
}
else{
    echo '<br>'."<div id='body'><center>We apologize for the incovinience.".'<br>'.'<br>'."<a href='User_Login.php' class='myButton'>Click here to log in again.</center></div>";
}
//start Encryption/Decryption
function start($dataRread, $conn, $bool){ 
    $output    = "";

    //Input from the textbox
    if($bool){
        $textInput = $dataRread;
        $fileInput = "";
    }
    //Input from the file
    else{
        $textInput ="";
        $fileInput = $dataRread;
    }

    if($_POST['ciphers']=='Simple Substitution'){

        require_once 'SimpleSubstitution.php';
        $ob = new SimpleSubstitution();
        if($_POST['type'] == 'Encrypt'){

            $output =  $ob->encrypt($dataRread);
            echo "<div id='body2'><center><b>".$output."</b></center></div>";

        }
        else if($_POST['type'] == 'Decrypt'){

            $output = $ob->Decrypt($dataRread);
            echo "<div id='body2'><center><b>".$output."</b></center></div>";
        }
    }
    else if($_POST['ciphers']=='Double Transposition'){

        require_once 'DoubleTransposition.php';
        $ob = new DoubleTransposition();
        if($_POST['type'] == 'Encrypt'){

            $output = $ob->encrypt("123","456", $dataRread);
            echo "<div id='body2'><center><b>".$output."</b></center></div>";

        }
        else if($_POST['type'] == 'Decrypt'){

            $output = $ob->decrypt("456", "123", $dataRread);
            echo "<div id='body2'><center><b>".$output."</b></center></div>";
        }
    }
    else if($_POST['ciphers'] =='RC4'){
        require_once 'RC4.php';
        $ob = new RC4();
        if($_POST['type'] == 'Encrypt'){
            $output = $ob->rc4Cipher("secret", $dataRread);
            echo "<div id='body2'><center><b>".$output."</b></center></div>";
        } 
        else if($_POST['type'] == 'Decrypt'){
            $output = $ob->rc4Cipher("secret", $dataRread);
            echo "<div id='body2'><center><b>".$output."</b></center></div>";
        }
    }
  }
// Function to sanitize input taken from the User. 
function get_post($conn, $string)
{
if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $conn->real_escape_string($string);
}
// Function to check the extension of the uploaded file. Only .txt files allowed for security reasons 
function check_ext($name) { 
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    $allowed=array('txt');
    if( ! in_array( $ext, $allowed ) ) {
    exit;
    }
}
?>