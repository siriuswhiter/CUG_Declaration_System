<?php
    header('content-type:text/html;charset=utf-8');
    require 'database.php';
    date_default_timezone_set('PRC');
    $sql="SELECT bussinessid,bussinessname,starttime,endtime FROM `business`;";

    $result=query($sql);
    array_pop($result);
    // print_r($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>业务列表浏览</title>
</head>
<body>
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
            
            <?php echo $val['bussinessid'];?>
            </td>
            <td>
            <a href="businessViewDetail.php?no=<?php echo $val['bussinessid'] ?>"><?php echo $val['bussinessname'];?></a>
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
</body>
</html>

