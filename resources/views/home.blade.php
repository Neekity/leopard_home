@extends('layouts.header')
@section('content')
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>傻豹子</title>
    <link type="text/css" rel="stylesheet" src="{{ asset('css/default.css') }}">
    <style type="text/css">
        <!--
        .STYLE1 {color: #666666}
        -->
        body{margin:0;padding:0;background:#ffe;font-size:14px;font-family:'微软雅黑','宋体',sans-serif;color:#231F20;overflow:auto}
        a {color:#000;font-size:14px;}
        #main{width:100%;}
        #wrap{position:relative;margin:0 auto;width:1100px;height:680px;margin-top:10px;}
        #text{width:400px;height:425px;left:60px;top:80px;position:absolute;}
        #code{display:none;font-size:16px;}
        #clock-box {position:absolute;left:60px;top:550px;font-size:28px;display:none;}
        #clock-box a {font-size:28px;text-decoration:none;}
        #clock{margin-left:48px;}
        #clock .digit {font-size:64px;}
        #canvas{margin:0 auto;width:1100px;height:680px;}
        #error{margin:0 auto;text-align:center;margin-top:60px;display:none;}
        .hand{cursor:pointer;}
        .say{margin-left:5px;}
        .space{margin-right:150px;}
    </style>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jscex.min.js') }}"></script>
    <script src="{{ asset('js/jscex-parser.js') }}"></script>
    <script src="{{ asset('js/jscex-jit.js') }}"></script>
    <script src="{{ asset('js/jscex-builderbase.min.js') }}"></script>
    <script src="{{ asset('js/jscex-async.min.js') }}"></script>
    <script src="{{ asset('js/jscex-async-powerpack.min.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="{{ asset('js/love.js') }}"></script>
</head>
<body>

<div id="main">
     <div id="wrap">
        <div id="text">
            <div id="code">
                <span class="say">* 相遇相爱</span><br>
                <span class="say"> </span><br>
                <span class="say"> 傻孢子，我又开始想你了。</span><br>
                <span class="say"> </span><br>
                <span class="say"> 你我的相遇，缘于奇妙的缘分，</span><br>
                <span class="say"> </span><br>
                <span class="say"> 你我的相爱，应是上天的安排，</span><br>
                <span class="say"> </span><br>
                <span class="say"> 就算是被你虐，笑容也会从我的心底溢出。</span><br>
                <span class="say"> </span><br>
                <span class="say"> 我要用我的一生去好好爱你。</span><br>
                <span class="say"> </span><br>
                <span class="say"> 你来的日子里，甜蜜是藏不住的。</span><br>
                <span class="say"> </span><br>
                <span class="say"> 如果天天都能看到你，</span><br>
                <span class="say"> </span><br>
                <span class="say"> 我感觉我会幸福到死。</span><br>
                <span class="say"> </span><br>
                <span class="say"> 人生路上有你真好！
						<span class="say"> </span><br>
                        <span class="say"><span class="space"></span> --成天儿黄-- </span>
            </div>
        </div>
        <div id="clock-box">
            慧哲儿陶<span class="STYLE1">与</span> 成天儿黄 <span class="STYLE1">已经相❤️了</span>
            <div id="clock"></div>
        </div>
        <canvas id="canvas" width="1100" height="680"></canvas>
    </div>

</div>
<script>
    (function(){
        var canvas = $('#canvas');

        if (!canvas[0].getContext) {
            $("#error").show();
            return false;
        }

        var width = canvas.width();
        var height = canvas.height();

        canvas.attr("width", width);
        canvas.attr("height", height);

        var opts = {
            seed: {
                x: width / 2 - 20,
                color: "rgb(190, 26, 37)",
                scale: 2
            },
            branch: [
                [535, 680, 570, 250, 500, 200, 30, 100, [
                    [540, 500, 455, 417, 340, 400, 13, 100, [
                        [450, 435, 434, 430, 394, 395, 2, 40]
                    ]],
                    [550, 445, 600, 356, 680, 345, 12, 100, [
                        [578, 400, 648, 409, 661, 426, 3, 80]
                    ]],
                    [539, 281, 537, 248, 534, 217, 3, 40],
                    [546, 397, 413, 247, 328, 244, 9, 80, [
                        [427, 286, 383, 253, 371, 205, 2, 40],
                        [498, 345, 435, 315, 395, 330, 4, 60]
                    ]],
                    [546, 357, 608, 252, 678, 221, 6, 100, [
                        [590, 293, 646, 277, 648, 271, 2, 80]
                    ]]
                ]]
            ],
            bloom: {
                num: 700,
                width: 1080,
                height: 650,
            },
            footer: {
                width: 1200,
                height: 5,
                speed: 10,
            }
        }

        var tree = new Tree(canvas[0], width, height, opts);
        var seed = tree.seed;
        var foot = tree.footer;
        var hold = 1;

        canvas.click(function(e) {
            var offset = canvas.offset(), x, y;
            x = e.pageX - offset.left;
            y = e.pageY - offset.top;
            if (seed.hover(x, y)) {
                hold = 0;
                canvas.unbind("click");
                canvas.unbind("mousemove");
                canvas.removeClass('hand');
            }
        }).mousemove(function(e){
            var offset = canvas.offset(), x, y;
            x = e.pageX - offset.left;
            y = e.pageY - offset.top;
            canvas.toggleClass('hand', seed.hover(x, y));
        });

        var seedAnimate = eval(Jscex.compile("async", function () {
            seed.draw();
            while (hold) {
                $await(Jscex.Async.sleep(10));
            }
            while (seed.canScale()) {
                seed.scale(0.95);
                $await(Jscex.Async.sleep(10));
            }
            while (seed.canMove()) {
                seed.move(0, 2);
                foot.draw();
                $await(Jscex.Async.sleep(10));
            }
        }));

        var growAnimate = eval(Jscex.compile("async", function () {
            do {
                tree.grow();
                $await(Jscex.Async.sleep(10));
            } while (tree.canGrow());
        }));

        var flowAnimate = eval(Jscex.compile("async", function () {
            do {
                tree.flower(2);
                $await(Jscex.Async.sleep(10));
            } while (tree.canFlower());
        }));

        var moveAnimate = eval(Jscex.compile("async", function () {
            tree.snapshot("p1", 240, 0, 610, 680);
            while (tree.move("p1", 500, 0)) {
                foot.draw();
                $await(Jscex.Async.sleep(10));
            }
            foot.draw();
            tree.snapshot("p2", 500, 0, 610, 680);

            // 会有闪烁不得意这样做, (＞﹏＜)
            canvas.parent().css("background", "url(" + tree.toDataURL('image/png') + ")");
            canvas.css("background", "#ffe");
            $await(Jscex.Async.sleep(300));
            canvas.css("background", "none");
        }));

        var jumpAnimate = eval(Jscex.compile("async", function () {
            var ctx = tree.ctx;
            while (true) {
                tree.ctx.clearRect(0, 0, width, height);
                tree.jump();
                foot.draw();
                $await(Jscex.Async.sleep(25));
            }
        }));

        var textAnimate = eval(Jscex.compile("async", function () {
            var together = new Date();
            together.setFullYear(2019, 09, 25); 			//时间年月日
            together.setHours(21);						//小时
            together.setMinutes(1);					//分钟
            together.setSeconds(0);					//秒前一位
            together.setMilliseconds(2);				//秒第二位

            $("#code").show().typewriter();
            $("#clock-box").fadeIn(500);
            while (true) {
                timeElapse(together);
                $await(Jscex.Async.sleep(1000));
            }
        }));

        var runAsync = eval(Jscex.compile("async", function () {
            $await(seedAnimate());
            $await(growAnimate());
            $await(flowAnimate());
            $await(moveAnimate());

            textAnimate().start();

            $await(jumpAnimate());
        }));

        runAsync().start();
    })();
</script>
</body>
</html>
@endsection
