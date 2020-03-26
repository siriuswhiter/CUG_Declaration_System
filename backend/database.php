<?php
/**
 * 含有数据库的初始化操作，只包含一次即可
 */

$sqlhost = "localhost";
$sqlport = "3306";
$sqlname = "admin";
$sqlpassword = "123456";
$sqldb = "declaresystem";


/**
* 执行查询 主要针对 SELECT, SHOW 等指令
*/
function query($sql)
{
    $mysqli = get_db();
    $result = $mysqli->query($sql);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while($data[] = $result->fetch_assoc()){};
    }
    return $data;
}

/** 
* 执行语句 针对 INSERT, UPDATE 以及DELETE,exec结果返回受影响的行数是否大于0
*/
function execute($sql)
{
    $mysqli = get_db();
    $mysqli->query($sql);
    return $mysqli->affected_rows > 0;
}


/**
 * 获取declaresystem数据库操作句柄
 */
function get_db(){
    $sqlhost = $GLOBALS['sqlhost'];
    $sqlport = $GLOBALS['sqlport'];
    $sqlname = $GLOBALS['sqlname'];
    $sqlpassword = $GLOBALS['sqlpassword'];
    $sqldb = $GLOBALS['sqldb'];
    $mysqli = @new mysqli($sqlhost,$sqlname,$sqlpassword,$sqldb,$sqlport);
    if ($mysqli->connect_errno) {
        $errmsg = "could not connect to the database: ";
        die($errmsg . $mysqli->connect_error);
    }
    return $mysqli;
}



?>

