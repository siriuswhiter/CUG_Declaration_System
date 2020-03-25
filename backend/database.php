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


function query($sql)
{
    $mysqli = getdb();
    $result = mysqli_query($mysqli, $sql);
    $data = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($res = mysqli_fetch_assoc($result)) {
            $data[] = $res;
        }
    }
    return $data;
}

function execute($sql)
{
    $mysqli = getdb();
    mysqli_query($mysqli, $sql);
    return mysqli_affected_rows($mysqli) > 0;
}
