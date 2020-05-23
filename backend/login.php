<?php

require_once "database.php";
$ttl  = 2*3600;
session_set_cookie_params($ttl);
session_start();
header('Content-Type:text/json;charset=utf-8');

$id = $_POST['id'];
$password = $_POST['password'];

function checkid($id){
    $pattern = "/20(16|17|18|19|20)\d{7}/";
    return preg_match($pattern, $id);
}

function sha256($str = ''){
    return hash("sha256", $str);
}

if(!checkid($id)){
    echo json_encode(array('status'=>false,'code'=>1));
    die();
}


$mysqli = get_db();

$que = "SELECT salt,password FROM users WHERE userid = '$id' limit 1";
$result = query($que);
if(empty($result)){
    echo json_encode(array('status'=>false,'code'=>1));
    die();
}


$salt = $result[0]['salt'];
$store_password = $result[0]['password'];

$password = sha256($password.$salt);

if($store_password==$password){
    $_SESSION["userid"] = $id;
    echo json_encode(array('status'=>true,'code'=>0));
}else{
    #header("Location:login.php");
    echo json_encode(array('status'=>false,'code'=>1));
}


$mysqli->close();

?>