<?php
    require_once 'database.php';
    $no=$_GET['no'];
    $sql="select * from business where businessid='$no' limit 1;";
    $result=query($sql)[0];
    $canReturn=$result['allowret']?'是':'否';
    
    // $dengji=$result['approvelevel']-2 ?'三级':'二级';
    $ziduan=unserialize( $result['texts']); 
    $attri= unserialize($result['textstype']);
    
    date_default_timezone_set('PRC');

    if (isset($_POST['pubMsg']))
    {
        date_default_timezone_set('PRC');
        $selectinfo= $_POST['ziduan'];
        $businessid=$_POST['no'];##userid 号咋读取还没写。

        $custominfo=serialize(array_slice($_POST,0,count($_POST)-2));
        $userid=9999;

        $sql="INSERT INTO `apply` (`applyid`, `businessid`, `userid`, `selectinfo`, `custominfo`, `submittime`) VALUES (NULL, $businessid, $userid, '$selectinfo', '$custominfo', CURDATE());";
        echo $sql;
        if(execute($sql)==false){
            echo 'insert wrong!';
            die();
        }
        echo '跳转到哪，我也不知道。';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>业务详情浏览</title>
</head>
<script>

    function tijiao(){
        
        a=document.getElementById("applyForm").submit();
    }
</script>
<body>
   <h1>
   业务： <?php  echo $result['businessname'];?>
   </h1>
   <h2>
   可退回：<?php  echo $canReturn ;?>
   </h2>
   <h3>
   业务审批等级：<?php  echo $dengji; ?>
   </h3>
<form method="post" action="#" id="applyForm">
 
<?php if(is_array($ziduan)&&count($ziduan)>0):?>
    <table class="table" > 
        <?php $i=1;foreach($ziduan as $key=>$val):?>
        <tr >
            <td>
            
            <?php echo $val;?>
            </td>
            <td>
            <?php if($attri[$key]==='text'):?>
                <input type="text" required="true" name=<?php echo $key;?> >
            <?php elseif($attri[$key]==='int'):?>
                <input type="text" required="required" name=<?php echo $key;?> >
            <?php elseif($attri[$key]==='bool'&&$val=='性别'):?>
                <input type="radio" name=<?php echo $key;?> value="男"  checked="checked" >男
                <input type="radio" name=<?php echo $key;?> value="女">女
            <?php elseif($attri[$key]==='bool'&&$val!='性别'):?>
                <input type="radio" name=<?php echo $key;?> value="是"  checked="checked" >是
                <input type="radio" name=<?php echo $key;?> value="否" >否
            <?php else:
                echo "error";
                ?>
            <?php endif;?>
            
            </td>
            
        </tr>
        <?php endforeach;?>
        </table>
<?php endif;?>
<input type="hidden" name="ziduan"  value=<?php echo $result['texts']; ?>  readonly="true"   >
<input type="hidden" name="no"  value=<?php echo $no;?>  readonly="true"   >
 <input type="submit" name="pubMsg" value="提交申请">
</form>






</body>
</html>

