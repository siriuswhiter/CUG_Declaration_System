<?php
    header('content-type:text/html;charset=utf-8');
    require_once '../backend/database.php';
    date_default_timezone_set('PRC');
    $sql="SELECT businessid,businessname,starttime,endtime FROM `business`;";
    $result=query($sql);
    array_pop($result);
    // print_r($result);
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
                    <h3>中国地质大学申报系统待审批业务浏览</h3>
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

    <?php if(is_array($result)&&count($result)>0):?>
    <table class="table">
        <thead>
            <tr>
                <th>
                    业务编号
                </th>
                
                <th>
                    业务名称
                </th>
                <th>
                    创建时间
                </th>
                <th>
                    结束时间
                </th>
            </tr>
        </thead>
        <tbody>
    <?php $i=1;foreach($result as $val):?>
        <tr class="success">
            <td>
            
            <?php echo $val['businessid'];?>
            </td>
            <td>
            <a href="applyViewDetail.php?no=<?php echo $val['businessid'] ?>"><?php echo $val['businessname'];?></a>
            </td>
            <td>
            <?php echo  substr($val['starttime'],0,10) ;?>
            
            </td>
            <td>
            <?php echo substr($val['endtime'],0,10);?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
			</table>
    <?php endif;?>

    </div>
</body>
</html>
