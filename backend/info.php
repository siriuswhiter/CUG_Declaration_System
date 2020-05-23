<?php

require_once "database.php";
header('Content-Type:text/json;charset=utf-8');


$mysqli = get_db();
$userid = $_POST['userid'];
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


$que = "SELECT salt FROM users WHERE userid = '$id' limit 1";
$result = query($que);
if(empty($result)){
    echo json_encode(array('status'=>false,'code'=>1));
    die();
}


$salt = $result[0]['salt'];
$password = sha256($password.$salt);

$que = "SELECT 1 FROM users WHERE userid = '$id'  AND password = '$password' limit 1";
/**
 * 验证成功，设置session生存周期为两小时
 */
if(!empty(query($que))){
    $que = "SELECT bussinessid,bussinessname,starttime,endtime FROM users NATURAL JOIN apply WHERE userid='$id'";
    $result = query($que);
    if(!empty($result)){
        echo json_encode(array('status'=>true,'code'=>0,'data'=>$result));
    }else{
        echo json_encode(array('status'=>true,'code'=>1));
    }
}else{
    echo json_encode(array('status'=>false,'code'=>1));
}

$mysqli->close();

?>