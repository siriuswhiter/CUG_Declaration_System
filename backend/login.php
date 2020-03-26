<?php

require_once "database.php";

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];

function checkid($id){
    $pattern = "/20(16|17|18|19|20)\d{7}/";
    return preg_match($pattern, $id);
    //return true;
}

if(!checkid($id)){
    $errmsg = "ERR! Id is malformed";
    die($errmsg);
}


$mysqli = get_db();

$errmsg = "";
$que = "SELECT 1 FROM users WHERE userid = '$id' limit 1";
if(empty(query($que))){
    $errmsg = "ERR! id dosen't exist";
    die($errmsg);
}


$que = "SELECT salt FROM users WHERE userid = '$id' limit 1";
$salt = query($que)[0]['salt'];
$password = md5($password.$salt);



$que = "SELECT 1 FROM users WHERE userid = '$id'  AND password = '$password' limit 1";
/**
 * 验证成功，设置session生存周期为两小时
 */
if(!empty(query($que))){
    $ttl  = 2*3600;
    session_set_cookie_params($ttl);
    session_start();
    $_SESSION["userid"] = $id;
    #header("Location:../index.php");
    echo "Login Success!";
}else{
    #header("Location:login.php");
    $errmsg =  "ERR! wrong id or password";
    die($errmsg);
}


$mysqli->close();

?>