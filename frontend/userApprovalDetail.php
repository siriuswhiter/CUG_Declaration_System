
<?php

   
    require_once "../backend/database.php";
    $no=$_GET['no'];
    $userid = $_COOKIE['id'];
    $sql="select ispass from business NATURAL join apply NATURAL join approval where businessid='$no' and userid='$userid' limit 1;";
    
    $ispass=query($sql)[0]['ispass'];
    if (isset($ispass))
        $ispass=intval($ispass);
    else
        $ispass=0;
    

       
    $sql="select businessname,submittime,approvable_level from business NATURAL join apply  where businessid='$no' and userid='$userid' limit 1;";
    
    $approvalInfo=query($sql)[0];
    $approvable_level=intval($approvalInfo['approvable_level']);
    $businessname=$approvalInfo['businessname'];
    $submittime=$approvalInfo['submittime'];
    



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

        <h1><?php echo $businessname?></h1>

        <h3><?php echo $submittime?></h3>
        
        <?php if ($ispass==0):?>
            <h3>暂未审查</h3>
        <?php else:?>
            <table class="table">

            <?php if ($approvable_level%2&&$ispass%2&&$ispass>0):?>   
            <tr> <td>班级审查结果</td>       <td><font size="6" color="red">√</font></td>  </tr> 
            <?php endif ?>   
            <?php if ($approvable_level%2&&$ispass<0&&$ispass>-10):?>   
            <tr> <td>班级审查结果</td>       <td><font size="10" color="red">×</font></td>  </tr>   
            <?php endif ?>
            <?php if ($approvable_level%2==0)
                $ispass+=1;
            ?>
 

            <?php if (floor(($approvable_level%4)/2)&&floor(($ispass%4)/2)&&$ispass>0):?>

                <tr> <td>院级审查结果</td><td><font size="6" color="red">√</font> </td>  </tr> 
                <?php endif ?>
                <?php if (floor(($approvable_level%4)/2)&&$ispass<-9&&$ispass>-80):?>
                <tr> <td>院级审查结果</td> <td><font size="10" color="red">×</font></td>   </tr> 
                <?php endif ?>

                <?php if (!floor(($approvable_level%4)/2))
                        $ispass+=2;
                ?>
                

                
            
            <?php if ($approvable_level>=4&&$ispass>=4):?>
                
                <tr> <td>校级审查结果</td><td><font size="10" color="red">√</font></td>    </tr>
            <?php endif ?>

            <?php if ($approvable_level>=4&&$ispass<=-10&&$ispass>-100):?>
                
                <tr> <td>校级审查结果</td><td><font size="10" color="red">×</font></td>    </tr>
            <?php endif ?>
            <?php if (!$approvable_level>=4)
                $ispass+=4;
            ?>
          
          

            </table>


            
            <?php if ($ispass==7):?>
                
                <tr> <td>最终审查结果：</td><td><font size="10" color="red">恭喜你，通过啦！</font></td>    </tr>
            <?php endif ?>

            <?php if ($ispass<0):?>
                
                <tr> <td>最终审查结果：</td><td><font size="5" color="red">很遗憾，再接再励</font></td>    </tr>
            <?php endif ?>
            
        <?php endif ?>

        <br>


        <br>
        <br>
        <a href="infocenter.html#applied">回到首页</a>
    </div>
</body>
</html>
