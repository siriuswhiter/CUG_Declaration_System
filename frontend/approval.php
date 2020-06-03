<?php
    require_once '../backend/database.php';
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

        if(execute($sql)==false){
            echo 'insert wrong!';
            die();
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


<form action="#" method="post">
<input type="radio" name="ispass" value=1 checked='checked'>通过
<input type="radio" name="ispass" value=-1>不通过
<?php if ($canReturn):?>
<input type="radio" name="ispass" value=0>退回修改
<?php endif;?>
<br>
<input type="submit" value="提交审批结果" name="pubMsg">

</form>
    </div>
</body>
</html>
