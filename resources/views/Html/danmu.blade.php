<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('/common/barrager/css/barrager.css')}}">
    <title>弹幕</title>
    <style>
        body,html{
            padding: 0;
            margin: 0;
            overflow-x: hidden;
        }
        .barrage {
            position: absolute;
        }
        .barrager-space{
            position: relative;
            width: 100%;
            height: 200px;
            margin-top:200px;
        }
        .barrage-text-box{
            text-align: center;
        }
        .barrage-text{
            border: 1px solid #5ab7f4;
            border-radius: 4px;
            height: 30px;
            line-height: 30px;
            width: 70%;
        }
        .barrage-btn{
            border-radius: 4px;
            line-height: 30px;
            height: 34px;
            width: 50px;
            background: #5ab7f4;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="barrager-space"></div>
    <div class="barrage-text-box">
        <input type="text" class="barrage-text" placeholder="请输入您要说的话哦～" >
        <button class="barrage-btn">发送</button>
    </div>
</div>
<script type="text/javascript" src="{{asset('/common/js/jquery2.2.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/common/barrager/js/jquery.barrager.js?1')}}"></script>
<script>
    var item = {
        info:'弹幕文字信息弹幕文字信息弹幕文字信息弹幕文字',
        close:false,
    };

    // alert(Math.floor(Math.random(10)*10));
    var isClick = true;
        $('.barrage-btn').on('click',function () {
            if(isClick){
                isClick = false;
                item.info = $('.barrage-text').val();
                $('.barrager-space').barrager(item);
                $('.barrage-text').val('');
                setTimeout(function(){
                    isClick = true;
                    console.log('sdfdf');
                }, 2000);
            }
        });
        $('.barrager-space').barrager(item);
</script>
</body>
</html>