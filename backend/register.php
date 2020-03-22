<?php

function checkid($id){
    return true;
}



$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

$errmsg = "";

if(!checkid($id)){
    $errmsg = "ERR! Id is malformed";
    die($errmsg);
}

if($password != $confirmPassword){
    $errmsg = "ERR! Password and confirmPassword do not match";
    die($errmsg);
}

include "database.php";
$mysqli = getdb();

$que = "CREATE TABLE IF NOT EXISTS users(
    id INT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    salt VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
    )";
$mysqli->query($que);


$que = "SELECT * FROM users WHERE id = '$id'";

if($result = $mysqli->query($que)){
    $row = $result->fetch_assoc();
    if($row>0){
        $errmsg = "ERR! id has already been taken";
        die("$errmsg");
    }

}

$salt = md5(time());
$password = md5($password.$salt);

$ins = "INSERT INTO users value('$id','$username','$salt','$password')";
$result = $mysqli->query($ins);
if($mysqli->affected_rows<=0){
    $errmsg = "ERR! insert failed";
    die($errmsg);
}
echo "Register success!";
$mysqli->close();

?>