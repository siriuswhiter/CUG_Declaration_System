<?php
    require_once 'database.php';
    $no=$_GET['no'];
    $sql="select * from apply where businessid='$no' and applyid not in (select applyid from approval where ispass !=0);";
    $result=query($sql);
   
    // $dengji=$result['approvelevel']-2 ?'三级':'二级';
    if (count($result)>0)
    {$ziduan=unserialize( $result[0]['selectinfo']); }
        
    
    $sql="select * from business where businessid='$no' limit 1;";
    $business_result=query($sql)[0];
  
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申请情况浏览</title>
</head>
<script>

    function tijiao(){
        
        a=document.getElementById("applyForm").submit();
    }
</script>
<body>
   <h1>
   业务： <?php  echo $business_result['businessname'];?>
   </h1>


   <?php $i=0 ;?>
<?php if(is_array($ziduan)&&count($ziduan)>0):?>
    <table class="table" > 
    <tr >
        <?php foreach($ziduan as $val):?>
        
            <td>
            
            <?php echo $val;?>
            </td>
            <?php $i++;
    if ($i==5   ) break; ?>
        <?php endforeach;?>
        <?php else:echo '该业务暂无待审批申请！'?>
        <?php endif;?>    


</tr>
<tr >
<?php  foreach($result as $val):?>
<?php $customeinfo=unserialize($val['custominfo']); ?>
    


<tr >
<?php $i=0 ;?>
<?php  if(is_array($customeinfo)&&count($customeinfo)>0):?>
<?php foreach($customeinfo as $subval):?>
    
    <td>
        <?php
        
        echo $subval;?>
    </td>
    <?php $i++;
    if ($i==5   ) break; ?>
<?php endforeach;?>
<td>  <a href="approval.php?applyid=<?php echo $val['applyid']?>" >浏览更多...</a></td>
<?php endif;?>

    
</tr>
<?php endforeach;?>
        
        
</table>



<!-- 上面的代码再来一遍 -->
<?php
    
    // $sql="select * from apply where businessid='$no' and applyid in (select applyid from approval where ispass !=0);";
    
    // $result=query($sql);
   
    // $dengji=$result['approvelevel']-2 ?'三级':'二级';
   
        
    
    $sql="select * from business where businessid='$no' limit 1;";
    $business_result=query($sql)[0];
    

    $sql="select * from approval natural join apply where ispass !=0  ";
    
    $result=query($sql);
    if (count($result)>0)
    {$ziduan=unserialize( $result[0]['selectinfo']); }
 
?>
 <?php $i=0 ;?>
<h3>已审批结果</h3>
<?php if(is_array($ziduan)&&count($ziduan)>0):?>
    <table class="table" > 
    <tr >
        <?php foreach($ziduan as $val):?>
        
            <td>
            
            <?php echo $val;?>
            </td>
            <?php $i++;
    if ($i==5   ) break; ?>
        <?php endforeach;?>
        <td>审批结果</td>
        <?php else:echo '该业务暂无已经审批申请！'?>
        <?php endif;?>    


</tr>
<tr >
<?php  foreach($result as $val):?>
<?php $customeinfo=unserialize($val['custominfo']); ?>
    


<tr >
<?php $i=0 ;?>
<?php  if(is_array($customeinfo)&&count($customeinfo)>0):?>
<?php foreach($customeinfo as $subval):?>
    
    <td>
        <?php
        
        echo $subval;?>
    </td>
    <?php $i++;
    
    if ($i==5   ) break; ?>
<?php endforeach;?>
    <td>
        <?php  if( $val['ispass']==1)
                echo '通过';
                else
                echo '不通过';
        ?>
    </td>
<td> 
<?php endif;?>

    
</tr>
<?php endforeach;?>
        
        
</table>





</body>
</html>