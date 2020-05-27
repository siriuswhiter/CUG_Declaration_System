<?php

require_once "database.php";
header('Content-Type:text/json;charset=utf-8');


$mysqli = get_db();

function sha256($str = ''){
    return hash("sha256", $str);
}

$userid = $_POST['userid'];
$password = $_POST['password'];

$que = "SELECT salt,password,role FROM users WHERE userid = '$userid' limit 1";
$result = query($que);
if(empty($result)){
    echo json_encode(array('status'=>false,'code'=>1));
    die();
}


$salt = $result[0]['salt'];
$store_password = $result[0]['password'];

$password = sha256($password.$salt);


if($store_password==$password && $result[0]['role']>=4){
    $que = "SELECT userid,username,academy FROM `users` limit 50";
}else{
    echo json_encode(array('status'=>true,'code'=>1));
    die();
}


$uid = $_POST['uid'];
$username = $_POST['username'];

if($uid=='*'){
    $uid = '%';
}else{
    $uid = '%'.$uid.'%';
}

if($username=='*'){
    $username = '%';
}else{
    $username = '%'.$username.'%';
}

$result = query($que);
if(empty($result)){
    echo json_encode(array('status'=>true,'code'=>1));
    die();
}


echo json_encode(array('status'=>true,'code'=>0,'data'=>$result));


$mysqli->close();

?>