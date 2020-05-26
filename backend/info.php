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

if(!checkid($userid)){
    echo json_encode(array('status'=>false,'code'=>1));
    die();
}


$mysqli = get_db();


$que = "SELECT salt,password FROM users WHERE userid = '$userid' limit 1";
$result = query($que);
if(empty($result)){
    echo json_encode(array('status'=>false,'code'=>1));
    die();
}


$salt = $result[0]['salt'];
$store_password = $result[0]['password'];

$password = sha256($password.$salt);

if($store_password==$password){
    if(isset($_POST['operat']) && $_POST['operat']=='1')
    {
        $userid = $_POST['userid'];
        $username = $_POST['username'];
        $sex = $_POST['sex'];
        $academy = $_POST['academy'];
        $class = $_POST['class'];

        if($sex=='女'){
            $sex = 0;
        }else if($sex=='男'){
            $sex = 1;
        }

        $que = "UPDATE users SET username='$username',sex='$sex',academy='$academy',class='$class' WHERE userid = '$userid'";
        $result = execute($que);
        if(!$result){
            echo json_encode(array('status'=>false,'code'=>1));
            die();
        }
    }
    $que = "SELECT username,sex,academy,class,role FROM users WHERE userid='$userid'";
    $result = query($que)[0];
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