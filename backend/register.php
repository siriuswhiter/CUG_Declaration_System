<?php
require_once "database.php";
header('Content-Type:text/json;charset=utf-8');


$id = $_POST['id'];
$username = $_POST['name'];
$password = $_POST['password'];

function checkid($id){
    $pattern = "/20(16|17|18|19|20)\d{7}/";
    return preg_match($pattern, $id);
}

function check(){
    $id = $GLOBALS['id'];
    if(!checkid($id)){
        echo json_encode(array('status'=>false,'code'=>1));
        die();
    }
}

function sha256($str = ''){
    return hash("sha256", $str);
}


check();

$mysqli = get_db();


$que = "SELECT 1 FROM users WHERE userid = '$id' limit 1";
if(!empty(query($que))) {
    echo json_encode(array('status'=>false,'code'=>1));
    die();

}

$salt = md5(time());
$password = sha256($password.$salt);

$que = "INSERT INTO users (userid,username,salt,password,role)value('$id','$username','$salt','$password','1')";

if(execute($que)==false){
    echo json_encode(array('status'=>false,'code'=>1));
    die();
}

echo json_encode(array('status'=>true,'code'=>0));
#echo "Register Success!! Jump to login page in two seconds......";
$mysqli->close();
#echo "<script>setTimeout(\"window.location.href='../frontend/login.html'\",00);</script>";

?>