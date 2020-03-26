<?php
    require_once 'database.php';
    $no=$_GET['no'];
    $sql="select * from jobs where jobNO='$no' limit 1;";
    
    $result=query($sql)[0];
    $canReturn=$result['canReturn']?'是':'否';
    
    $dengji=$result['twoORthree']-2 ?'三级':'二级';
    $ziduan=unserialize( $result['ziduans']); 
    $attri= unserialize($result['attributes']);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>业务详情浏览</title>
</head>
<body>
   <h1>
   业务： <?php  echo $result['jobName'];?>
   </h1>
   <h2>
   可退回：<?php  echo $canReturn ;?>
   </h2>
   <h3>
   业务审批等级：<?php  echo $dengji; ?>
   </h3>

<?php if(is_array($ziduan)&&count($ziduan)>0):?>
    <table class="table">   
        <?php $i=1;foreach($ziduan as $key=>$val):?>
        <tr >
            <td>
            
            <?php echo $val;?>
            </td>
            <td>
            <?php if($attri[$key]==='text'):?>
                <input type="text" name=<?php echo $key;?>>
            <?php elseif($attri[$key]==='int'):?>
                <input type="text" name=<?php echo $key;?>>
            <?php elseif($attri[$key]==='bool'&&$val=='性别'):?>
                <input type="radio" name=<?php echo $key;?> value="男">男
                <input type="radio" name=<?php echo $key;?> value="女">女
            <?php elseif($attri[$key]==='bool'&&$val!='性别'):?>
                <input type="radio" name=<?php echo $key;?> value="是">是
                <input type="radio" name=<?php echo $key;?> value="否">否
            <?php else:
                echo "error";
                ?>
            <?php endif;?>
            
            </td>
            
        </tr>
        <?php endforeach;?>
		</table>
<?php endif;?>
</body>
</html>