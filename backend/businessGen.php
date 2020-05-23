<?php

require_once 'database.php';
date_default_timezone_set('PRC');
$businessname=$_POST['businessName'];
$approvelevel=array_sum($_POST['approvelevel']);
$allowret=$_POST['allowret'];
$span=$_POST['span'];
echo 'allowret：',$allowret;
echo '<br>';
echo 'approvelevel：',$approvelevel ;
if (isset($_POST['optionalZiduan']))
{
    $optionalZiduan=$_POST['optionalZiduan'];
}
$zidingyiZiduan=$_POST['zidingyiZiduan'];

$attributeName=$_POST['attributeName'];



$name=array("withName"=>"姓名","withSex"=>"性别","withSchoolNumber"=>"学号","withAcdemicName"=>"学院名","withTel"=>"电话","withIDnumber"=>"身份证号","withOrignalPlace"=>"籍贯","withAddress"=>"地址");
$attr=array("withName"=>"text","withSex"=>"bool","withSchoolNumber"=>"text","withAcdemicName"=>"text","withTel"=>"int","withIDnumber"=>"int","withOrignalPlace"=>"text","withAddress"=>"text");
$texts=[];
$texttype=[];
foreach ($optionalZiduan as  $key => $value)
{
    
    array_push($texts,$name[$value]);
    array_push($texttype,$attr[$value]);
}

foreach($zidingyiZiduan as $key=>$value)
{
    
    if (!empty($value)){
        array_push($texts,$value);
        array_push($texttype,$attributeName[$key]);

    }
    

}


$texts=serialize($texts);
$texttype=serialize($texttype);


echo '<br>';

$sql="INSERT INTO `business` ( `bussinessname`, `textstype`, `texts`, `starttime`, `endtime`, `approvelevel`, `allowret`) VALUES ( '$businessname', '$texttype', '$texts', CURDATE(), date_add(CURDATE(),interval $span day), '$approvelevel', '$allowret');";
execute($sql);
echo 'SQL语句：',$sql;
header('location: businessView.php');







