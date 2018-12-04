<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>转盘抽奖</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}"/>
    {{--变化参数--}}
    {{--https://c.runoob.com/codedemo/3391--}}
    <style>
        html,body{
            overflow-x: hidden;
        }

        body{
            padding:0;
            margin:0;
            /*background-color: #ff9700;*/
        }
        .container{
            position: relative;
            width:100%;
            height:100%;
            max-width:420px;
            margin:0 auto;
            background: url({{ asset('pic/turntable/body_bg2.jpg') }}) no-repeat center top;
            background-size: 100%;
            padding-top: 48%;
            padding-bottom: 30%;

            animation: fadeInDown 1.5s;
        }
        @media only screen and (min-width: 420px){
            .container{
                padding-top: 200px;
            }
        }
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                -webkit-transform: translateY(-10%);
                transform: translateY(-10%);
            }

            to {
                opacity: 1;
                -webkit-transform: none;
                transform: none
            }
        }
        .turntable{
            display: block;
            width: 90%;
            margin: 0 auto;
            position: relative;
        }
        .turntable-bg{
            width:100%;
        }
        .bg-active{
            animation: play1 30s linear infinite;
        }
        .pointer{
            position: absolute;
            left: 30%;
            top: 29.5%;
            width: 40%;
            z-index: 1;
        }
        .ding{
            position: absolute;
            left: 43%;
            top: 0;
            width: 15%;
            z-index: 1;
        }
        canvas.item{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1;
        }
        canvas.canvas-active{
            animation: play 30s linear infinite;
        }

        @keyframes play{
            0%  {
                transform:rotate(0deg);
            }
            100% {
                transform:rotate(360deg);
            }
        }
        @keyframes play1{
            0%  {
                transform:rotate(360deg);
            }
            100% {
                transform:rotate(0deg);
            }
        }
        .dialog-bg{
            display: none;
            position: fixed;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,.4);
            z-index: 99;
        }
        .dialog {
            position: absolute;
            left:0;
            right:0;
            top:0;
            width: 300px;
            margin: 0 auto;
            animation: hdggResultShow 1s;
        }
        .dialog img{
            width: 100%;
        }
        .dialog p{
            position: absolute;
            left: 0;
            right: 0;
            text-align: center;
            top: 35%;
            font-size: 20px;
            color: #fff;
        }
        @keyframes hdggResultShow {
            0% {
                opacity: 0;
                -webkit-transform: translateY(-40%);
                transform: translateY(-40%)
            }
            50% {
                opacity: 1;
                -webkit-transform: translateY(15%);
                transform: translateY(15%)
            }
            60% {
                -webkit-transform: translateY(-10%);
                transform: translateY(-10%)
            }
            70% {
                -webkit-transform: translateY(6%);
                transform: translateY(6%)
            }
            80% {
                -webkit-transform: translateY(-3%);
                transform: translateY(-3%)
            }
            90% {
                -webkit-transform: translateY(1%);
                transform: translateY(1%)
            }
            to {
                -webkit-transform: translateY(0);
                transform: translateY(0)
            }
        }

        .jiang{
            position: absolute;
            top:0;
            right:0;
        }
        .jiang img{
            width: 65px;
        }

.jiang-box {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            z-index: 100;

            transform-origin: 100% 0 0;
            transition: .4s cubic-bezier(1, .55, .51, 1.29);
        }

        .jiang-box-hide {
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        .jiang-box-show {
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        .jiang-header {
            background-color: #000;
            color: #fff;
            height: 45px;
            line-height: 45px;
        }

        .jiang-header .return-container {
            position: absolute;
            padding: 0 20px;
        }

        .jiang-header > p {
            text-align: center;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="turntable">
        <canvas class="item canvas-active" id="wheelcanvas" width="522px" height="522px"></canvas>
        <img class="turntable-bg bg-active" src="{{ asset('pic/turntable/zhuanpan.png') }}">
        <img class="pointer" src="{{ asset('pic/turntable/jt2.png') }}">
        <img class="ding" src="{{ asset('pic/turntable/dingbu.png') }}">
    </div>

    <div style="display: none;">
        <?php
        for ($i = 1; $i < 7; $i++) { ?>
        <img src="{{ asset('pic/turntable').'/'.$i.'.png' }}" alt="" id="reward_img_<?php echo $i; ?>">
        <?php } ?>
    </div>

    <div class="dialog-bg">
        <div class="dialog">
            <p>恭喜中奖-<span class="award-name"></span></p>
            <img src="{{ asset('pic/turntable/dialog.png') }}">
        </div>
    </div>

    <div class="jiang">
        <img src="{{ asset('pic/turntable/wp3wf4tauu.png') }}">
    </div>

    <div class="jiang-box jiang-box-hide">
        <div class="jiang-header">
            <div class="return-container">返回</div>
            <p>我的奖品</p>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('/common/js/jquery2.2.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/common/js/awardrotate.js')}}"></script>
<script>
    $('.dialog-bg').on('click',function () {
        $(this).hide();
    });
    $('.return-container').on('click',function () {
        $('.jiang-box').removeClass('jiang-box-show').addClass('jiang-box-hide');
    });
    $('.jiang').on('click',function () {
        $('.jiang-box').removeClass('jiang-box-hide').addClass('jiang-box-show');
    });
    var turnplate = {
        restaraunts: ["水果拼盘300元月卡", "2元现金红包", "夏威夷果一袋", "3元现金红包", "松子一袋 ", "5元现金红包"],				//大转盘奖品名称
        colors: ["#ffc41f", "#fff9e8", "#ffc41f", "#fff9e8", "#ffc41f", "#fff9e8"],					//大转盘奖品区块对应背景颜色
        outsideRadius: 235,			//大转盘外圆的半径
        textRadius: 180,				//大转盘奖品位置距离圆心的距离
        insideRadius: 83,			//大转盘内圆的半径
        startAngle: 0,				//开始角度

        bRotate: false				//false:停止;ture:旋转
    };

    $(document).ready(function () {
        var rotateTimeOut = function () {
            $('#wheelcanvas').rotate({
                angle: 0,
                animateTo: 2160,
                duration: 8000,
                callback: function () {
                    alert('网络超时，请检查您的网络设置！');
                }
            });
        };

        //旋转转盘 item:奖品位置; txt：提示语;
        var rotateFn = function (item, txt) {
            var angles = item * (360 / turnplate.restaraunts.length) - (360 / (turnplate.restaraunts.length * 2));
            if (angles < 270) {
                angles = 270 - angles;
            } else {
                angles = 360 - angles + 270;
            }
            $('#wheelcanvas').stopRotate();
            $('canvas').removeClass('canvas-active');

            $('#wheelcanvas').rotate({
                angle: 0,
                animateTo: angles + 1800,
                duration: 5000,
                callback: function () {
                    turnplate.bRotate = !turnplate.bRotate;

                    $('.pointer').attr('src', '{{ asset('pic/turntable/jt2.png') }}');
                    $('span.award-name').text(txt);
                    $('.dialog-bg').show();

                    $('canvas').addClass('canvas-active');
                }
            });
        };

        $('.pointer').click(function () {
            if (turnplate.bRotate)return;
            turnplate.bRotate = !turnplate.bRotate;
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/ajax_turntable",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function (res) {
                    if (res.code == 100) { //success
                        $('.pointer').attr('src', '{{ asset('pic/turntable/jted.png') }}');
                        rotateFn(res.data.award_id, res.data.award_name);
                    } else {
                        turnplate.bRotate = false;
                    }
                }
            });
        });
    });

    //页面所有元素加载完毕后执行drawRouletteWheel()方法对转盘进行渲染
    window.onload = function () {
        drawRouletteWheel();
    };

    function drawRouletteWheel() {
        var canvas = document.getElementById("wheelcanvas");
        if (canvas.getContext) {
            //根据奖品个数计算圆周角度
            var arc = Math.PI / (turnplate.restaraunts.length / 2);
            var ctx = canvas.getContext("2d");
            //在给定矩形内清空一个矩形
            ctx.clearRect(0, 0, 522, 522);
            //strokeStyle 属性设置或返回用于笔触的颜色、渐变或模式
            ctx.strokeStyle = "#FFBE04";
            //font 属性设置或返回画布上文本内容的当前字体属性
            ctx.font = ' 18px Microsoft YaHei';
            for (var i = 0; i < turnplate.restaraunts.length; i++) {
                var angle = turnplate.startAngle + i * arc;
                ctx.fillStyle = turnplate.colors[i];
                ctx.beginPath();
                //arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）
                ctx.arc(261, 261, turnplate.outsideRadius, angle, angle + arc, false);
                ctx.arc(261, 261, turnplate.insideRadius, angle + arc, angle, true);
                ctx.stroke();
                ctx.fill();
                //锁画布(为了保存之前的画布状态)
                ctx.save();


                ctx.fillStyle = '#000';
                ctx.beginPath();
                //arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）
                ctx.arc(261, 261, turnplate.outsideRadius, angle, angle + arc, false);
//                ctx.arc(261, 261, turnplate.outsideRadius + 15, angle + arc, angle, true);
                ctx.arc(261, 261, turnplate.outsideRadius, angle + arc, angle, true);
                ctx.stroke();
                ctx.fill();
                //锁画布(为了保存之前的画布状态)
                ctx.save();


                //改变画布文字颜色
                var b = i + 2;
                if (b % 2) {
                    ctx.fillStyle = "#ffc41f";
                } else {
                    ctx.fillStyle = "#ffeda0";
                }
                ;

                //----绘制奖品开始----


                var line_height = 17;
                //translate方法重新映射画布上的 (0,0) 位置
                ctx.translate(261 + Math.cos(angle + arc / 2) * turnplate.textRadius, 261 + Math.sin(angle + arc / 2) * turnplate.textRadius);

                //rotate方法旋转当前的绘图
                ctx.rotate(angle + arc / 2 + Math.PI / 2);

                //添加对应图标
                var img = document.getElementById('reward_img_' + (i + 1));
                if (typeof img != 'undefined' && img != null) {
                    if (i == 5) {
                        img.onload = function () {
                            ctx.drawImage(img, -45, -20);
                        };
                        ctx.drawImage(img, -45, -20);
                    } else {
                        img.onload = function () {
                            ctx.drawImage(img, -30, -20);
                        };
                        ctx.drawImage(img, -30, -20);
                    }
                }
                //把当前画布返回（调整）到上一个save()状态之前
                //把当前画布返回（调整）到上一个save()状态之前
                ctx.restore();
                //----绘制奖品结束----
            }
        }
    }
</script>
</body>
</html>