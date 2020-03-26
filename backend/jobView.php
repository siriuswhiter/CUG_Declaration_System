<?php
    header('content-type:text/html;charset=utf-8');
    require 'database.php';

    $sql="SELECT jobNO,jobName,create_time,is_over FROM `jobs`;";

    $result=query($sql);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    是否结束
                </th>
            </tr>
        </thead>
        <tbody>
    <?php $i=1;foreach($result as $val):?>
        <tr class="success">
            <td>
            <?php echo $val['jobNO'];?>
            </td>
            <td>
            <?php echo $val['jobName'];?>
            </td>
            <td>
            <?php echo date("m/d/Y ",$val['create_time']);?>
            </td>
            <td>
            <?php echo $val['is_over'];?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
			</table>
    <?php endif;?>
</body>
</html>

