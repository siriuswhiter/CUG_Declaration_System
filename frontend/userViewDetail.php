<?php
    require_once '../backend/database.php';
    // cookie验证
    if(!isset($_COOKIE['id'])||$_COOKIE['id']==''){
        // 弹窗出不来 不太会弹。。
        echo"<script>alert('还未登录，请先登录...')</script>";
        header('Location:./login.html');
    }

    $no=$_GET['no'];
    $sql="select username,sex,academy,class,role from users where userid='$no' limit 1;";
    $result=query($sql)[0];


    date_default_timezone_set('PRC');

    $role = 0;
    if(isset($_POST['editAuth'])){
        if(isset($_POST['auth-apply'])){
            $role |= 1;
        }
        if(isset($_POST['auth-approval'])){
            $role |= 2;
            $manage = $_POST['manage'];
            // 权限细节
        }
        if(isset($_POST['auth-admin'])){
            $role |= 4;
        }
        if($role!=$result['role']){
            $sql = "UPDATE users SET role = '$role' WHERE userid = '$no'";
            if(execute($sql)==false){
                echo 'insert wrong!';
                die();
            }
            header('location: '.$_SERVER['HTTP_REFERER']);
        }


        
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

            function tijiao(){
                
                a=document.getElementById("applyForm").submit();
            }
</script>


<body>
<div class="business">
    <!-- <div class="business-div" style="text-align: center;"> -->

<h2>
用户ID： <?php  echo $no;?>
<br>
用户名： <?php  echo $result['username']?>
<br>
性 别 ： <?php  echo $result['sex'];?>
<br>
学 院 ： <?php  echo $result['academy'];?>
<br>
班 级 ： <?php  echo $result['class'];?>
<br>
权 限 ：<?php  
    echo $result['role'];
 ?>
</h2>

<form method="post" action="#" id="applyForm" content-type="multipart/form-data">
<input type="checkbox" name="auth-admin" id='admin-ck' value="admin" <?php if (($result['role']>>2)%2==1) echo 'checked="checked"';?>>管理权限</input>
<input type="checkbox" name="auth-approval" id="approval-ck" value="approval" <?php if (($result['role']>>1)%2==1) echo 'checked="checked"';?>>审批权限</input>
<input type="checkbox" name="auth-apply" id="apply-ck" value="apply" <?php if ($result['role']%2==1) echo 'checked="checked"';?>>申请权限</input>
<br>
<div class="manage">
<input type="radio" name="manage" value="class" id='class' checked="checked">班级审批权限</input>
<input type="radio" name="manage" value="academy" id='academy'>院级审批权限</input>
<input type="radio" name="manage" value="college" id='college'>校级审批权限</input>
</div>

<script>
$(".manage").hide();
$("#approval-ck").change(function() {
    if($("#approval-ck").prop("checked")){
        $("#approval-ck").prop("checked",true);
        $(".manage").show();
    }else{
        $("#approval-ck").prop("checked",false);
        $(".manage").hide();
    }
})
$("#approval-ck").change();
</script>
<input type="submit" name="editAuth" value="权限修改">
</form>


<!-- </div> -->
</div>
        </body>
</html>




