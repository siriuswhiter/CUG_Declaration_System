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


if($store_password==$password && ($result[0]['role']>>1)%2==1){
    $applyid = $_POST['applyid'];
    $businessid = $_POST['businessid'];
    $id = $_POST['id'];

    if($id=='*'){
        $id = '%';
    }else{
        $id = '%'.$id.'%';
    }
    if($applyid=='*'){
        $applyid = '%';
    }else{
        $applyid = '%'.$applyid.'%';
    }

    if($businessid=='*'){
        $businessid = '%';
    }else{
        $businessid = '%'.$businessid.'%';
    }

    $que = "SELECT applyid,businessid,userid FROM `apply` NATURAL JOIN `approval` WHERE ispass=0  AND applyid LIKE '$applyid' AND userid LIKE '$userid' AND businessid LIKE '$businessid' limit 50";

    $result = query($que);
    if(empty($result)){
        echo json_encode(array('status'=>true,'code'=>1));
        die();
    }
    echo json_encode(array('status'=>true,'code'=>0,'data'=>$result));

}else{
    echo json_encode(array('status'=>true,'code'=>1));
    die();
}



$mysqli->close();

?>