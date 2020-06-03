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
    $que = "SELECT DISTINCT businessid,businessname,starttime,endtime FROM `apply` NATURAL JOIN `business` WHERE userid = '$userid' AND businessid like '$businessid' AND businessname like '$businessname' AND starttime>'$starttime' AND endtime<'$endtime' AND businessid in (SELECT businessid FROM `apply` where  applyid NOT IN (select applyid from approval))limit 50";

    // $applyid = $_POST['applyid'];
    // $businessid = $_POST['businessid'];
    // $id = $_POST['id'];

    // if($id=='*'){
    //     $id = '%';
    // }else{
    //     $id = '%'.$id.'%';
    // }
    // if($applyid=='*'){
    //     $applyid = '%';
    // }else{
    //     $applyid = '%'.$applyid.'%';
    // }

    // if($businessid=='*'){
    //     $businessid = '%';
    // }else{
    //     $businessid = '%'.$businessid.'%';
    // }

    // $que = "SELECT applyid,businessid,userid FROM `apply`  WHERE applyid LIKE '$applyid' AND userid LIKE '$userid' AND businessid LIKE '$businessid' AND applyid NOT IN (select applyid from approval) limit 50";

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