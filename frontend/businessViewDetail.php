<?php
    require_once '../backend/database.php';
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
        //（cookie里面有）cookie['id']，这个页面加个登陆验证，没有登录的话跳转到登录页面../frontend/login.html

        // cookie验证
        if(!isset($_COOKIE['id'])||$_COOKIE['id']==''){
            // 弹窗出不来 不太会弹。。
            echo"<script>alert('还未登录，请先登录...')</script>";
            header('Location:../frontend/login.html');
        }
        $userid = $_COOKIE['id'];
        $businessid=$no;##userid 号咋读取还没写。

        $custominfo=serialize(array_slice($_POST,0,count($_POST)-2));

        $sql="INSERT INTO `apply` (`applyid`, `businessid`, `userid`, `selectinfo`, `custominfo`, `submittime`) VALUES (NULL, $businessid, $userid, '$selectinfo', '$custominfo', CURDATE());";
        if(execute($sql)==false){
            echo 'insert wrong!';
            die();
        }
        //想要个弹窗申请成功
        header('Location:infocenter.html#applied');
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

            function tijiao(){
                
                a=document.getElementById("applyForm").submit();
            }
</script>
<body>
<div class="business">
    <!-- <div class="business-div" style="text-align: center;"> -->
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
<table class="table"  > 
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


<!-- </div> -->
</div>
        </body>
</html>




