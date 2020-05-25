<?php
    require_once 'database.php';
    $applyid=$_GET['applyid'];
    $sql="select * from apply where applyid='$applyid' ;";
    $result=query($sql)[0];
    
    // $dengji=$result['approvelevel']-2 ?'三级':'二级';
    if (is_array($result))
    {$ziduan=unserialize( $result['selectinfo']); 
    
    }
        

    
    $sql="select * from business where businessid='$no' limit 1;";
    $business_result=query($sql)[0];
    $canReturn=$business_result['allowret']?'是':'否';;
    $customeinfo=unserialize($result['custominfo']);
    if (isset($_POST['pubMsg']))
    {
        date_default_timezone_set('PRC');

        $businessid=$_POST['no'];##userid 号咋读取还没写。
        $ispass=$_POST['ispass'];

        $userid=9999;

        $sql="INSERT INTO `approval` (`applyid`, `approverid`, `ispass`, `approvertime`) VALUES ('$applyid', '$userid', '$ispass', CURDATE());";
        echo $sql;
        if(execute($sql)==false){
            echo 'insert wrong!';
            die();
        }
        
    }


?>


<body>
   <h1>
   业务： <?php  echo $business_result['businessname'];?>
   </h1>


 
<?php if(is_array($ziduan)&&count($ziduan)>0):?>
    <table class="table" > 
    
        <?php foreach($ziduan as $key=>$val):?>
            <tr>
            <td>
            
            <?php echo $val;?>
            </td>


            <td>
            
            <?php echo $customeinfo[$key];?>
            </td>
            </tr>
            

        <?php endforeach;?>

<?php endif;?>
        
</table>


<form action="#" method="post">
<input type="radio" name="ispass" value=1 checked='checked'>通过
<input type="radio" name="ispass" value=-1>不通过
<?php if ($canReturn):?>
<input type="radio" name="ispass" value=0>退回修改
<?php endif;?>
<br>
<input type="submit" value="提交审批结果" name="pubMsg">

</form>






</body>
</html>