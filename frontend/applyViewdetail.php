<?php
    require_once '../backend/database.php';
    $no=$_GET['no'];
    $sql="select * from apply where businessid='$no' and applyid not in (select applyid from approval where ispass !=0);";
    $result=query($sql);
   
    // $dengji=$result['approvelevel']-2 ?'三级':'二级';
    if (count($result)>0)
    {$ziduan=unserialize( $result[0]['selectinfo']); }
        
    
    $sql="select * from business where businessid='$no' limit 1;";
    $business_result=query($sql)[0];
  
 
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
    </div>
</body>
</html>
