<?php


include "database.php";
function checkid($id){
    return true;
}


$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];

$errmsg = "";

if(!checkid($id)){
    $errmsg = "ERR! Id is malformed";
    die($errmsg);
}


$mysqli = getdb();


$que = "SELECT * FROM users WHERE id = '$id'";

if($result = $mysqli->query($que)){
    $row = $result->fetch_assoc();
    if($row<=0){
        $errmsg = "ERR! id doesn't exists";
        die("$errmsg");
    }
}

$result = $mysqli->query("SELECT salt FROM users WHERE id = '$id'");
$salt = mysqli_fetch_row($result)[0];
$password = md5($password.$salt);

$que = "SELECT * FROM users WHERE id = '$id'  AND password = '$password'";

if($result = $mysqli->query($que)){
    $row = $result->fetch_assoc();
    if($row<=0){
        $errmsg =  "wrong id or password";
        die($errmsg);
    }
}
echo "Login Success!";
$mysqli->close();

?>