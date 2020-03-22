<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>业务生成界面</title>
    <link rel="stylesheet" id="templatecss" type="text/css" href="css/smart-green.css">
</head>
<body>

<form action="#" method="post" class="smart-green">
    <h1>业务生成界面</h1>
        <h2>业务基本信息</h2>
        业务名称：
            <input type="text" name="jobName" id="jobName">
            
            <div>
            业务等级：
            两级<input type="radio" name="twoORthree" id="twoORthree">
            三级<input type="radio" name="twoORthree" id="">
            <br>
            是否可退回修改：
            是<input type="radio" name="canReturn" id="">
            否<input type="radio" name="canReturn" id="">
            </div>
            
        <h2>业务字段信息</h2>
        <h3>业务可选字段</h3>
        <div>
            姓名<input type="checkbox" name="optionalZiduan[]" id="withName">
            性别<input type="checkbox" name="optionalZiduan[]" id="withSex">
            学号<input type="checkbox" name="optionalZiduan[]" id="withSchoolNumber">
            学院名<input type="checkbox" name="optionalZiduan[]" id="withAcdemicName">
            电话号<input type="checkbox" name="optionalZiduan[]" id="withTel">
            <br>
            身份证号<input type="checkbox" name="optionalZiduan[]" id="withIDnumber">
            地址<input type="checkbox" name="optionalZiduan[]" id="withAddress">
            籍贯<input type="checkbox" name="optionalZiduan[]" id="withOrignalPlace">

        
        </div>
        <h3>业务自定义字段</h3>
        <div id="zidingyi" class="zidingyi">
        <label for="name1">自定义字段名：</label>
        <input type="text" name="zidingyiZiduan" id="name1">
        <label for="select1">自定义属性：</label>
            <select name="attributeName[]" id="select1">
            <option value="text">文本</option>
            <option value="int">整数</option>
            <option value="bool">布尔</option>        
            </select>
            <button onclick="add(); return false;">+</button>
            <!-- <button onclick="del()">-</button> -->

        </div>
        

</form>
</body>
</html>

<script>
    count=1
    function add(){
        count++;
        zidingyi=document.getElementById("zidingyi");
        var div = document.createElement('div');
        div.class="zidingyi";
        div.id=count;
        
        
        var label1 = document.createElement('label');
        var t = document.createTextNode("自定义字段名：");
        label1.appendChild(t);
        div.appendChild(label1);
        
        var input=document.createElement('input');
        input.type="text";
        input.name="attributeName[]";
        div.appendChild(input);

        var label2 = document.createElement('label');
        var t2 = document.createTextNode("自定义属性：");
        label2.appendChild(t2);
        div.appendChild(label2);

        var select =document.createElement('select');
        var option0  =   new  Option("文本","text");  
        var option1  =   new  Option("整数","int");  
        var option2  =   new  Option("布尔","bool");  
        select.options[0] = option0;  
        select.options[1] = option1;  
        select.options[2] = option2;  

        div.appendChild(select);

        

        var button2=document.createElement('button');
        
        button2.name=count;
        button2.onclick=function() {
                        del(button2.name);
                        return false;
                    };
        button2.innerText="-";
        
        div.appendChild(button2);

        zidingyi.appendChild(div);
        return false;
    }

    
    function del(selfid){
        del_div=document.getElementById(selfid);
        zidingyi=document.getElementById("zidingyi");
        zidingyi.removeChild(del_div);
        return false;
    }
</script>