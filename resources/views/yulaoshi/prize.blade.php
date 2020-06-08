<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1,minimum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
<title>俞老师抽奖啦</title>
	<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/turntable.js')}}"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>
	.lottery {
		position: relative;
		display: inline-block;
		text-align:center
	}

	.lottery img {
		position: absolute;
		top: 50%;
		left: 50%;
		margin-left: -76px;
		margin-top: -82px;
		cursor: pointer;
	}

	#message {
		position: absolute;
		top: 0px;
		left: 10%;
	}
</style>
<!--[if lte IE 8]>
	<style>
		.lottery img{
			display: none;
		}   
	</style>
<![endif]-->

</head>
<body>

<audio src="mp3/prize.mp3" autoplay="autoplay" loop="loop"></audio>
<center>
<div class="lottery">
	<canvas id="myCanvas" width="600" height="600" style="border:1px solid #d3d3d3;">
		当前浏览器版本过低，请使用其他浏览器尝试
	</canvas>
	<p id="message"></p>
	<img src="images/start.png" id="start">
</div>
</center>
<script>
	var wheelSurf
	// 初始化装盘数据 正常情况下应该由后台返回
	var initData = {
		"success": true,
		"list": [{
				"id": 100,
				"name": "蓝牙耳机",
				"image": "images/3.png",
				"rank":1,
				"percent":10
			},
			{
				"id": 101,
				"name": "神仙水",
				"image": "images/3.png",
				"rank":2,
				"percent":8
			},
			{
				"id": 102,
				"name": "运动鞋",
				"image": "images/3.png",
				"rank":3,
				"percent":10
			},
			{
				"id": 103,
				"name": "愿望卡",
				"image": "images/3.png",
				"rank":4,
				"percent":8
			},
			{
				"id": 104,
				"name": "项链",
				"image": "images/3.png",
				"rank":5,
				"percent":8
			},
			{
				"id": 105,
				"name": "衣服",
				"image": "images/3.png",
				"rank":6,
				"percent":8
			},
			{
				"id": 106,
				"name": "逛商场",
				"image": "images/3.png",
				"rank":7,
				"percent":8
			},
			{
				"id": 107,
				"name": "小棕瓶",
				"image": "images/3.png",
				"rank":8,
				"percent":8
			},
			{
				"id": 108,
				"name": "演唱会",
				"image": "images/3.png",
				"rank":9,
				"percent":8
			},
			{
				"id": 109,
				"name": "双肩包",
				"image": "images/3.png",
				"rank":10,
				"percent":8
			},
			{
				"id": 110,
				"name": "链条包",
				"image": "images/3.png",
				"rank":11,
				"percent":8
			},
			{
				"id": 111,
				"name": "零食大礼包",
				"image": "images/3.png",
				"rank":12,
				"percent":8
			}
		]
	}

	// 计算分配获奖概率(前提所有奖品概率相加100%)
	function getGift(){
		var percent = Math.random()*100
		var totalPercent = 0
		for(var i = 0 ,l = initData.list.length;i<l;i++){
			totalPercent += initData.list[i].percent
			if(percent<=totalPercent){
				return initData.list[i]
			}
		}           
	}

	var list = {}
	
	var angel = 360 / initData.list.length
	// 格式化成插件需要的奖品列表格式
	for (var i = 0, l = initData.list.length; i < l; i++) {
		list[initData.list[i].rank] = {
			id:initData.list[i].id,
			name: initData.list[i].name,
			image: initData.list[i].image
		}
	}
	// 查看奖品列表格式
	
	// 定义转盘奖品
	wheelSurf = $('#myCanvas').WheelSurf({
		list: list, // 奖品 列表，(必填)
		outerCircle: {
			color: '#df1e15' // 外圈颜色(可选)
		},
		innerCircle: {
			color: '#f4ad26' // 里圈颜色(可选)
		},
		dots: ['#fbf0a9', '#fbb936'], // 装饰点颜色(可选)
		disk: ['#ffb933', '#ffe8b5','#fff000'], //中心奖盘的颜色，默认7彩(可选)
		title: {
			color: '#5c1e08',
			font: '19px Arial'
		} // 奖品标题样式(可选)
	})

	// 初始化转盘
	wheelSurf.init()
	// 抽奖
	var throttle = true;
	$("#start").on('click', function () {

		var winData = getGift() // 正常情况下获奖信息应该由后台返回

		$("#message").html('')
		if(!throttle){
			return false;
		}
		throttle = false;
		var count = 0
		// 计算奖品角度

		for (const key in list) {
			if (list.hasOwnProperty(key)) {                    
				if (winData.id == list[key].id) {
					break;
				}
				count++    
			}
		}
  
		// 转盘抽奖，
		wheelSurf.lottery((count * angel + angel / 2), function () {
			axios.post('yulaoshi.res',{
				message:winData.name,
			}).then()
			$("#message").html(winData.name)
			throttle = true;
		})
	})

	
</script>
<div class="col-lg-10 col-lg-offset-1">

	<hr>
	<div class="table-responsive">
<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>俞老师已有的心愿列表</th>
		<th>是否实现</th>
		<th>最晚时间</th>
	</tr>
	</thead>
	<tbody>
	@foreach ($prizes as $prize)
		<tr>

			<td>{{ $prize->prize_name }}</td>
			<td>{{ $prize->prize_time }}</td>
			<td>{{ $prize->prize_deadline }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
	</div>

</div>
</body>
</html>