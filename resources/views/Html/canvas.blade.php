<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>canvas</title>
    <style>
        body{
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<canvas id="tutorial" width="500" height="500">
    这段话将在不支持canvas的地方显示出来[没测试过，看描述是这样的]
</canvas>
<h1>test dom</h1>
<script type="text/javascript" src="{{asset('/common/js/jquery2.2.1/jquery.min.js')}}"></script>
<script>
    //https://developer.mozilla.org/zh-CN/docs/Web/API/Canvas_API/Tutorial/Basic_usage
    $(function () {
        //jquery获取图形容器需要注意，见下，因为这是js原生方法，所以也建议直接用原生法申明
        // var canvas = $('#tutorial')[0];
        var canvas = document.getElementById('tutorial');
        if (canvas.getContext){ //判断浏览器是否支持 canvas
            var ctx = canvas.getContext('2d');

            //设置颜色
            ctx.fillStyle = "rgb(200,0,0)";
            //填充一个坐标是(10,10)，宽55高50的矩形
            ctx.fillRect (0, 0, 55, 50);

            //绘制一个矩形的边框
            ctx.fillStyle = "rgba(0, 0, 200, 0.5)";
            ctx.strokeRect (20, 20, 55, 50);

            //清除指定矩形区域，让清除部分完全透明
            ctx.clearRect (5, 5, 10, 10);


            //绘制路径 fill填充默认是关闭路径
            ctx.beginPath();
            ctx.moveTo(75,50);
            ctx.lineTo(100,75);
            ctx.lineTo(100,25);
            ctx.fill();

            //绘制路径 stroke则需要closePath来关闭路径
            ctx.beginPath();
            ctx.moveTo(100,100);
            ctx.lineTo(100,150);
            ctx.lineTo(50,150);
            ctx.closePath();
            ctx.stroke();

            //画一个圆 arc(圆心横坐标，纵坐标，半径，开始角，结束角，false顺时针|true逆时针)
            ctx.beginPath();
            ctx.arc(170,50,30,0,2*Math.PI,false);
            ctx.moveTo(190,50);
            ctx.arc(170,50,20,0,Math.PI,false);
            ctx.moveTo(158,40);
            ctx.arc(155,40,3,0,2*Math.PI,false);
            ctx.moveTo(188,40);
            ctx.arc(185,40,3,0,2*Math.PI,false);
            ctx.stroke();

            //画一段曲线 二次贝塞尔曲线--气泡对话框
            ctx.beginPath();
            ctx.moveTo(175,125);
            ctx.quadraticCurveTo(125,125,125,162.5);
            ctx.quadraticCurveTo(125,200,150,200);
            ctx.quadraticCurveTo(150,220,130,225);
            ctx.quadraticCurveTo(160,220,165,200);
            ctx.quadraticCurveTo(225,200,225,162.5);
            ctx.quadraticCurveTo(225,125,175,125);
            ctx.stroke();

            //三次贝塞尔曲线--爱心
            ctx.beginPath();
            ctx.moveTo(300,200);
            ctx.bezierCurveTo(290,160,250,170,250,200);
            ctx.bezierCurveTo(250,220,280,250,300,260);
            ctx.bezierCurveTo(320,250,350,220,350,200);
            ctx.bezierCurveTo(350,170,310,160,300,200);
            ctx.fillStyle = '#f59790';
            ctx.fill();

            ctx.beginPath();
            ctx.fillStyle = '#000';
            ctx.arc(300,100,20,0.2*Math.PI,1.8*Math.PI,false);
            ctx.lineTo(300,100);
            ctx.lineTo(300,100);
            ctx.fill();


            //画布
            var rectangle = new Path2D();
            rectangle.rect(330,95,10,10);
            ctx.fill(rectangle);

            var circle = new Path2D();
            circle.arc(355,100,5,0,2*Math.PI,true);
            ctx.stroke(circle);

            //调色板--色值问题，具体没看
            for (var i=0;i<6;i++){
                for (var j=0;j<6;j++){
                    ctx.fillStyle = 'rgb(' + Math.floor(255-42.5*i) + ',' +
                        Math.floor(255-42.5*j) + ',0)';
                    ctx.fillRect(j*25+300,i*25+300,25,25);
                }
            }

            //移动：translate   旋转：rotate   放大缩小：scale  变形：transform
            //中心圆
            ctx.translate(100,400);//移动
            for (var i=1;i<6;i++){ // Loop through rings (from inside to out)
                ctx.save();
                ctx.fillStyle = 'rgb('+(51*i)+','+(255-51*i)+',255)';

                for (var j=0;j<i*6;j++){ // draw individual dots
                    ctx.rotate(Math.PI*2/(i*6));
                    ctx.beginPath();
                    ctx.arc(0,i*12.5,5,0,Math.PI*2,true);
                    ctx.fill();
                }

                ctx.restore();
            }


            ctx.translate(-100,-400); //改变上面的相对位置
            //动画：animation
            //绘制小球
            var raf;
            var ball = {
                x: 100,
                y: 100,
                vx:5,
                vy:2,
                radius: 25,
                color: 'blue',
                draw: function() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, true);
                    ctx.closePath();
                    ctx.fillStyle = this.color;
                    ctx.fill();
                }
            };

            function animation_draw() {
                ctx.fillStyle = 'rgba(255,255,255,0.3)';
                ctx.fillRect(0,0,canvas.width,canvas.height);
//                ctx.clearRect(0,0, canvas.width, canvas.height);
                ball.x += ball.vx;
                ball.y += ball.vy;

                ball.vy *= .99;
                ball.vy += .25;

                ball.draw();

                if (ball.y + ball.vy > canvas.height || ball.y + ball.vy < 0) {
                    ball.vy = -ball.vy;
                }
                if (ball.x + ball.vx > canvas.width || ball.x + ball.vx < 0) {
                    ball.vx = -ball.vx;
                }
                raf = window.requestAnimationFrame(animation_draw);
            }

            canvas.addEventListener('mouseover', function(e){
                animation_draw();
            });

            canvas.addEventListener('mouseout', function(e){
                window.cancelAnimationFrame(raf);
            });
            ball.draw();

        }
    });
</script>
</body>
</html>
