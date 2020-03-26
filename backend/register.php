<?php
require_once "database.php";

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

function checkid($id){
    $pattern = "/20(16|17|18|19|20)\d{7}/";
    return preg_match($pattern, $id);
}

function check(){
    $id = $GLOBALS['id'];
    if(!checkid($id)){
        $errmsg = "ERR! id is malformed";
        die($errmsg);
    }
    
    if($password != $confirmPassword){
        $errmsg = "ERR! Password and confirmPassword do not match";
        die($errmsg);
    }
}


check();

$mysqli = get_db();

$errmsg = "";

$que = "SELECT 1 FROM users WHERE userid = '$id' limit 1";
if(!empty(query($que))) {
    $errmsg = "ERR! id has existed";
    die($errmsg);
}

$salt = md5(time());
$password = md5($password.$salt);

$que = "INSERT INTO users (userid,username,salt,password,role)value('$id','$username','$salt','$password','0')";

if(execute($que)==false){
    $errmsg = "ERR! insert failed";
    die($errmsg);
}

echo "Register Success!! Jump to login page in two seconds......";
$mysqli->close();
echo "<script>setTimeout(\"window.location.href='../frontend/login.html'\",00);</script>";

?>