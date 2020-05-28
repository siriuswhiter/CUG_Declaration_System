<?php

require_once "database.php";
header('Content-Type:text/json;charset=utf-8');


$mysqli = get_db();
$starttime = $_POST['starttime'];
$endtime = $_POST['endtime'];
$businessid = $_POST['businessid'];
$businessname = $_POST['businessname'];

if($businessid=='*'){
    $businessid = '%';
}else{
    $businessid = '%'.$businessid.'%';
}

if($businessname=='*'){
    $businessname = '%';
}else{
    $businessname = '%'.$businessname.'%';
}

if($starttime=='*'){
    $starttime = 0;
}
if($endtime=='*'){
    $dt = new DateTime('1st January 2999');
    $dt->add(DateInterval::createFromDateString('+1 day'));
    $endtime = $dt->format('Y-m-d H:i:s');
}

$que = "SELECT businessid,businessname,starttime,endtime FROM `business` WHERE businessid like '$businessid' AND businessname like '$businessname' AND starttime>'$starttime' AND endtime<'$endtime' limit 50";
if(isset($_POST['userid'])&&isset($_POST['password']))
{
    function sha256($str = ''){
        return hash("sha256", $str);
    }

    $userid = $_POST['userid'];
    $password = $_POST['password'];

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
        $que = "SELECT businessid,businessname,starttime,endtime FROM `apply` NATURAL JOIN `business` WHERE userid = '$userid' AND businessid like '$businessid' AND businessname like '$businessname' AND starttime>'$starttime' AND endtime<'$endtime' limit 50";
    }else{
        echo json_encode(array('status'=>false,'code'=>1));
        die();
    }
}


$result = query($que);
if(empty($result)){
    echo json_encode(array('status'=>true,'code'=>1));
    die();
}


echo json_encode(array('status'=>true,'code'=>0,'data'=>$result));


$mysqli->close();

?>