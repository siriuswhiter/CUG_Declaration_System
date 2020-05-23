<?php

require_once "database.php";
header('Content-Type:text/json;charset=utf-8');


$mysqli = get_db();


$que = "SELECT bussinessid,bussinessname,starttime,endtime FROM bussiness limit 20";
$result = query($que);
if(empty($result)){
    echo json_encode(array('status'=>false,'code'=>1));
    die();
}

echo $result;
echo json_encode(array('status'=>true,'code'=>0));


$mysqli->close();

?>