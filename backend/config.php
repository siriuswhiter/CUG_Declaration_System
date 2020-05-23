<?php

require_once "database.php";
#===========================================================================================
#                           以下为数据库初始化相关操作                                        #
#===========================================================================================
/**
 * 建立declaresystem数据库
 */
function create_db(){
    $sqlhost = $GLOBALS['sqlhost'];
    $sqlport = $GLOBALS['sqlport'];
    $sqlname = $GLOBALS['sqlname'];
    $sqlpassword = $GLOBALS['sqlpassword'];
    $mysqli = new mysqli($sqlhost,$sqlname,$sqlpassword,"",$sqlport);
    if ($mysqli->connect_errno) {
        $errmsg = "could not connect to the database: ";
        die($errmsg . $mysqli->connect_error);
    }

    $que = "CREATE DATABASE IF NOT EXISTS declaresystem";
    if(!$mysqli->query($que)){
        $errmsg = "could not create the database: ";
        die($errmsg . $mysqli->queue_error);
    }
    $mysqli->close();
}


/*
用户数据表
sex 表示性别，0女1男
role 用来存放权限（000-111）二进制三位数（分别表示管理员权限，审批权限与申请权限），同一角色可以有多个权限。e.g:3=(011)b 即同时具有审批与申请权限
*/
function create_tb_users($mysqli){
    $que = "CREATE TABLE IF NOT EXISTS users(
        userid BIGINT(32) PRIMARY KEY,
        username VARCHAR(32) NOT NULL,
        salt VARCHAR(64) NOT NULL,
        password VARCHAR(64) NOT NULL,
        sex int,
        academy VARCHAR(32),
        class VARCHAR(32),
        role int NOT NULL
        )";
    $mysqli->query($que);
}


/**
 * 业务信息表，管理员发布，用来记录申报项目的相关内容
 * approvellevel 用来存放审批级别（000-111）二进制三位数（分别表示校级院级班级三级审批）
 */
function create_tb_business($mysqli){
    $que = "CREATE TABLE IF NOT EXISTS business(
        bussinessid BIGINT(32) PRIMARY KEY  AUTO_INCREMENT ,
        bussinessname VARCHAR(64) NOT NULL,
        description VARCHAR(1024),
        belongcollege INT NOT NULL,
        textstype VARCHAR(1024) NOT NULL,
        texts VARCHAR(1024) NOT NULL,
        starttime DATETIME NOT NULL,
        endtime DATETIME NOT NULL,
        approvelevel INT NOT NULL,
        allowret INT NOT NULL
    )";
    $mysqli->query($que);
}


/**
 * 申请信息表，记录了申请人，申请时间，申请项目及相关信息
 */
function create_tb_apply($mysqli){
    $que = "CREATE TABLE IF NOT EXISTS apply(
        applyid BIGINT(32) PRIMARY KEY AUTO_INCREMENT,
        bussinessid BIGINT(32) NOT NULL,
        userid BIGINT(32) NOT NULL,
        selectinfo VARCHAR(1024) NOT NULL,
        custominfo VARCHAR(1024),
        submittime DATETIME,
        FOREIGN KEY(bussinessid) REFERENCES business(bussinessid),
        FOREIGN KEY(userid) REFERENCES users(userid)
    )";
    $mysqli->query($que);
}

/**
 * 审批信息表，记录了是否通过，审批人及审批时间
 */
function create_tb_approval($mysqli){
    $que = "CREATE TABLE IF NOT EXISTS approval(
        applyid BIGINT(32) PRIMARY KEY AUTO_INCREMENT   ,
        approverid BIGINT(32) NOT NULL,
        ispass INT NOT NULL,
        approvertime DATETIME NOT NULL,
        FOREIGN KEY(approverid) REFERENCES users(userid),
        FOREIGN KEY(applyid) REFERENCES apply(applyid)
    )";
    $mysqli->query($que);
}


function init(){
    create_db();
    $mysqli = get_db();
    create_tb_users($mysqli);
    create_tb_business($mysqli);
    create_tb_apply($mysqli);
    create_tb_approval($mysqli);
    $mysqli->close();
}

init();
?>