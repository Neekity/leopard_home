<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        #wrapper{width: 1300px;
            display: flex;
            min-height: 100vh; /*1vh表示浏览器高度的1%，100vh为浏览器高度，感觉这个挺好的*/
            flex-direction: column;/*灵活的项垂直显示*/}
        #content{flex: 1;}
        #footer{height: 100px;
            background-color: black;}
    </style>
</head>
<body>
<center>
    <div id="wrapper">
        <div id="header"></div>
        <div id="content"></div>
        <div id="footer"></div>
    </div>
</center>
</body>
</html>
