<?php
    require_once '../backend/database.php';
    $no=$_GET['no'];
    $sql="select  apply.applyid,businessid,userid,selectinfo,custominfo,ispass from apply  left join approval on apply.applyid=approval.applyid  where businessid='$no' ;";
    
    $result=query($sql);
    
    
    // $dengji=$result['approvelevel']-2 ?'三级':'二级';
    if (count($result)>0)
    {
        $ziduan=unserialize($result[0]['selectinfo']); 
    
    
    }
        
    
    $sql="select * from business where businessid='$no' limit 1;";
    $business_result=query($sql)[0];
    
    $approvable_level=$business_result['approvable_level']; 
    
 
?>







</body>
</html>


<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../js/jquery.js" type="text/javascript" charset="utf-8"></script>
        <link rel = "stylesheet" type="text/css" href="../css/main_style.css">
    </head>
    <body>
        <div class="header">
            <div class="header-nav">
                <div class="header-nav-left">
                    <h3>中国地质大学申报系统业务详情</h3>
                </div>
                <div class="header-nav-right">
                    <ul id="loginbf">
                        <li><a href="./index.html">首页</a></li>
                        <li><a href="./login.html">登录</a></li>
                        <li><a href="./register.html">注册</a></li>
                    </ul>
                    <ul id="loginaf">
                        <li><a href="./index.html">首页</a></li>
                        <li><a id="welcome" href="./infocenter.html"></a></li>
                        <li id="logout"><a href="">退出</a></li>
                    </ul>
                    
                </div>
            </div>
        </div>
        
<script>
            function showUser(id){
                $("#welcome").html(id);
            }


            var cookie={
                getAll:function(){
                    var obj={};
                    var arr=document.cookie.split('; ');
                    for(var i=0;i<arr.length;i++){
                        obj[arr[i].split('=')[0]]=arr[i].split('=')[1];
                    }
                    return obj;
                },
                get:function(key){
                    return this.getAll()[key];
                },
                set:function(key,value,time){
                    var date=new Date().getTime()+time*1000;
                    document.cookie=key+'='+value+';expires='+new Date(date).toUTCString();
                },
                remove:function(key){
                    var date=new Date().getTime()-1;
                    document.cookie=key+'=;expires='+new Date(date).toUTCString();
                }
            };

            $('#logout').click(function(){
                cookie.remove('id');
                window.location.reload(true);
            })

            var islogin = cookie.get("id");
            if(islogin!==''){
                $id = islogin;
                showUser($id);
                $("#loginbf").hide();
                $("#loginaf").show();
            }else{
                $("#loginbf").show();
                $("#loginaf").hide();
            }
</script>
<body>
    <div class="business">

        <!-- 页面要显示的内容放这里就可以 -->
        <h1>
   业务： <?php  echo $business_result['businessname'];?>
   </h1>

   <table class="table" >
   <?php $i=0 ;?>
<?php if(is_array($ziduan)&&count($ziduan)>0):?>
    
     
    <tr >
        <?php foreach($ziduan as $val):?>
        
            <td>
            
            <?php echo $val;?>
            </td>
            <?php $i++;
        if ($i==4   ) break; ?>
        <?php endforeach;?>
        <?php else:echo '该业务暂无待审批申请！';?>
        <?php endif;?> 

        
        <?php if ($approvable_level%2):?>   
        <td>班审</td>
        <?php endif ?>
        <?php if (floor(($approvable_level%4)/2)):?>
            <td>院审</td>
            <?php endif ?>
        
        <?php if ($approvable_level>=4):?>
            
        <td>校审</td>
        <?php endif ?>
            
    </tr>

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
    if ($i==4   ) break; ?>
<?php endforeach;?>
<?php $ispass = $val['ispass'];?>
<?php if ($approvable_level%2&&$ispass%2&&$ispass>0):?>   
                  <td><font size="5" color="red">√</font></td>  

<?php elseif ($approvable_level%2&&$ispass<0&&$ispass>-10):?>   
    <td><font size="10" color="red">×</font></td>  
<?php elseif($approvable_level%2) :?>

    <td> 无</td>
        <?php endif ?>

<?php if (floor(($approvable_level%4)/2)&&floor(($ispass%4)/2)&&$ispass>0):?>
   <td><font size="5" color="red">√</font> </td>  
   <?php elseif (floor(($approvable_level%4)/2)&&$ispass<-9&&$ispass>-80):?>
 <td><font size="10" color="red">×</font></td>   
<?php elseif(floor(($approvable_level%4)/2)):?>
    <td> 无</td>
            <?php endif ?>
        

<?php if ($approvable_level>=4&&$ispass>=4):?>
                
<td><font size="5" color="red">√</font></td>    

<?php elseif ($approvable_level>=4&&$ispass<=-10&&$ispass>-100):?>
                
 <td><font size="10" color="red">×</font></td>    
        <?php elseif($approvable_level>=4):?>
    <td> 无</td>
        <?php endif ?>


</td>
<td>  <a href="approval.php?applyid=<?php echo $val['applyid'];?>" >浏览更多...</a></td>

<?php endif;?>


</tr>
<?php endforeach;?>

        

</table>




    </div>
</body>
</html>
