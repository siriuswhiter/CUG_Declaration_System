<?php

function getdb(){
    $sqlhost = "localhost";
    $sqlname = "admin";
    $sqlpassword = "123456";
    $sqldb = "declaresystem";
    $mysqli = new mysqli($sqlhost,$sqlname,$sqlpassword,$sqldb);
    if ($mysqli->connect_errno) {
        $errmsg = "could not connect to the database: ";
        die($errmsg . $mysqli->connect_error);
    }
    return $mysqli;
}
?>