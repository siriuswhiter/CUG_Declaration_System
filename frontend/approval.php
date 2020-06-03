<?php
    require_once '../backend/database.php';
    $applyid=$_GET['applyid'];
    $userid=$_COOKIE['id'];

    
    $sql="select approval_level from users where userid='$userid';";
    
    $approval_level=query($sql)[0]['approval_level'];
    $approval_level=intval($approval_level);

    $sql="select * from apply natural join business where applyid='$applyid' ;";
    
    $result=query($sql)[0];
    $no=$result['businessid'];
    
    $approvable_level=$result['approvable_level'] ;

    if (is_array($result))
    {$ziduan=unserialize( $result['selectinfo']); 
    

    $approval_show=$approval_level&$approvable_level;
    
    }

    $sql="select ispass from approval where applyid='$applyid'";
    $ispassInfo=query($sql)[0]['ispass'];
    
    if(!$ispassInfo)
        $ispassInfo=0;
    $fail=($ispassInfo<0);
    var_dump($fail);
        

    
    $sql="select * from business where businessid='$no' limit 1;";
    $business_result=query($sql)[0];
    $canReturn=$business_result['allowret'];
    $customeinfo=unserialize($result['custominfo']);
    if (isset($_POST['pubMsg']))
    {
        date_default_timezone_set('PRC');
        
        

        $ispass=$_POST['ispass'];

        $userid=$_COOKIE['id'];

        $sql="INSERT ignore INTO `approval` (`applyid`, `approverid`, `ispass`, `approvertime`) VALUES ('$applyid', '$userid', '0', CURDATE());";
        

        $sql2="UPDATE `approval` SET ispass = ispass +'$ispass' where applyid=$applyid";
        $res1=execute($sql);
        $res2=execute($sql2);
        if(!$res1&&!$res2){
            
            echo ($sql);
            echo '\n\r';
            echo ($sql2);
            echo 'insert wrong!';
            die();
        }

        else{
            echo "<script>alert('审批成功');</script>";
            $url="applyViewdetail.php?no=".$no;
            echo "<meta http-equiv='refresh'  content=0.8;url=".$url.'>';
            print('正在加载，请稍等...<br>一秒后自动跳转。'); 
                }
        
        // 这边加个跳转回该业务的审批界面
        // Header("Location:./applyViewDetail.php?no="+$no);

    }
    
?>




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
                window.location.href = "./login.html";
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

<?php echo $ispassInfo ;?>
<?php if ($approvable_level%2):?>
<?php 
$tongguo=(($ispassInfo%2)>=1);
$editbale=($approval_show%2)&&($ispassInfo==0);
?>
班级审批：
<form action="#" method="post">
<input type="radio" name="ispass" value=1 <?php if ($tongguo) echo "checked='checked'"?> <?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>通过
<input type="radio" name="ispass" value=-9 <?php if ($fail) echo "checked='checked'"?> <?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>不通过
<?php if ($canReturn):?>
<input type="radio" name="ispass" value=0 <?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>退回修改
<?php endif;?>
<br>
<input type="submit" value="提交审批结果" name="pubMsg"<?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>
</form>
<? elseif($ispassInfo==2):
    $ispassInfo+=1;
    ?>

<?php endif ?>





<?php if (floor(($approvable_level%4)/2)):?>
    <?php 
    $tongguo=(($ispassInfo%4)>=2);
    $editbale=(floor(($approval_show%4)/2))&&($ispassInfo==1);
?>

院级审批：
<form action="#" method="post">
<input type="radio" name="ispass" value=2 <?php if ($tongguo) echo "checked='checked'"?> <?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>通过
<input type="radio" name="ispass" value=-20 <?php if ($fail) echo "checked='checked'"?> <?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>不通过
<?php if ($canReturn):?>
<input type="radio" name="ispass" value=0 <?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>退回修改
<?php endif;?>
<br>
<input type="submit" value="提交审批结果" name="pubMsg"<?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>

</form>

<? elseif($ispassInfo==1):
    $ispassInfo+=2;
    ?>

<?php endif ?>



<?php if (floor(($approvable_level>=4))):?>

    校级审批：
<?php 
    $tongguo=($ispassInfo>=4);
    $editbale=(floor($approval_show/4))&&($ispassInfo==3);
?>

<br>
<form action="#" method="post">
<input type="radio" name="ispass" value=4 <?php if ($tongguo) echo "checked='checked'"?> <?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?> >通过
<input type="radio" name="ispass" value=-100 <?php if ($fail) echo 'checked=True'?>  <?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>不通过
<?php if ($canReturn):?>
<input type="radio" name="ispass" value=0 <?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>退回修改
<?php endif;?>
<br>
<input type="submit" value="提交审批结果" name="pubMsg" <?php if ($tongguo||$fail||!$editbale) echo "disabled=True"?>>
</form>

<? elseif($ispassInfo==0):
    $ispassInfo+=4;
    ?>

<?php endif ?>





    </div>


</body>
</html>
