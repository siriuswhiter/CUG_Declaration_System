<?php

require_once 'database.php';
date_default_timezone_set('PRC');
$jobname=$_POST['jobName'];
$twoORthree=$_POST['twoORthree'];
$canReturn=$_POST['canReturn'];
echo $canReturn;
echo $twoORthree;
if (isset($_POST['optionalZiduan']))
{
    $optionalZiduan=$_POST['optionalZiduan'];
}
$zidingyiZiduan=$_POST['zidingyiZiduan'];

$attributeName=$_POST['attributeName'];



$name=array("withName"=>"姓名","withSex"=>"性别","withSchoolNumber"=>"学号","withAcdemicName"=>"学院名","withTel"=>"电话","withIDnumber"=>"身份证号","withOrignalPlace"=>"籍贯","withAddress"=>"地址");
$attr=array("withName"=>"text","withSex"=>"bool","withSchoolNumber"=>"text","withAcdemicName"=>"text","withTel"=>"int","withIDnumber"=>"int","withOrignalPlace"=>"text","withAddress"=>"text");
$ziduan=[];
$attribute=[];
foreach ($optionalZiduan as  $key => $value)
{
    
    array_push($ziduan,$name[$value]);
    array_push($attribute,$attr[$value]);
}

foreach($zidingyiZiduan as $key=>$value)
{
    
    if (!empty($value)){
        array_push($ziduan,$value);
        array_push($attribute,$attributeName[$key]);

    }
    

}


$ziduan=serialize($ziduan);
$attribute=serialize($attribute);

$sql="CREATE TABLE IF NOT EXISTS `declaresystem`.`jobs` ( `jobName` TINYINT(20) NOT NULL , `canReturn` BOOLEAN NOT NULL , `ziduans` VARCHAR(256) NOT NULL , `attributes` VARCHAR(256) NOT NULL , `JobNO` INT NOT NULL AUTO_INCREMENT , `create_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `is_over` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`JobNO`)) ENGINE = MyISAM;";
execute($sql);
echo '<br>';
$sql="INSERT INTO `declaresystem`.`jobs` (`jobName`, `canReturn`,`twoORthree`, `ziduans`, `attributes`, `JobNO`, `create_time`, `is_over`) VALUES (' $jobname', '$canReturn','$twoORthree', '$ziduan', '$attribute', NULL, CURRENT_TIMESTAMP, '0');";
execute($sql);
echo $sql;
header('location: jobview.php');







