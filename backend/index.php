<?php

require_once "database.php";
header('Content-Type:text/json;charset=utf-8');


$mysqli = get_db();


$que = "SELECT bussinessid,bussinessname,starttime,endtime FROM `business` limit 20";
$result = query($que);
if(empty($result)){
    echo json_encode(array('status'=>false,'code'=>1));
    die();
}


echo json_encode(array('status'=>true,'code'=>0,'data'=>$result));


$mysqli->close();

?>