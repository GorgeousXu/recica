<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>文字轮播</title>
    <style>
        .news-box{
            position: relative;
            height: 30px;
            overflow: hidden;
            border: 1px solid lightgrey;
        }
        .news-ul{
            list-style: none;
            margin: 0;
            padding: 0;

            position: absolute;
            top:0;
            left:0;
            right:0;
            line-height: 30px;
            height: 30px;
            font-size: 18px;
            text-align: center;
        }
        
        .news-ul li{
            position: relative;
        }

        .news-ul li:before{
            content: '';
            background: url(http://s.kjcdn.com/groundwork/images/golden_heart.png) no-repeat center;
            background-size: contain;
            width: 30px;
            height: 30px;
            position: absolute;
            top:0;
            left:0;
            right:0;
        }
    </style>
</head>
<body>
    <div class="news-box">
        <ul class="news-ul">
            <li>1、琵琶行</li>
            <li>2、浔阳江头夜送客</li>
            <li>3、枫叶荻花秋瑟瑟</li>
            <li>4、主人下马客在船</li>
            <li>5、举酒欲饮无管弦</li>
            <li>6、忽闻水上琵琶声</li>
            <li>7、主人忘归客不发</li>
        </ul>
    </div>
<script type="text/javascript" src="{{asset('/common/js/jquery2.2.1/jquery.min.js')}}"></script>
<script>
    $(function () {
        var i = 0;
        var news = $('.news-ul');
        var length = news.children('li').length;

        wzlb();
        function wzlb() {
            i = i+1;

            if(i>=length){
                i = 0;
                news.css('top',30);
            }
            var top = parseInt(news.css('top'));

            news.animate({
                top: top - 30 + 'px'
            },'slow');
            setTimeout(wzlb,3000);
        }
    })
</script>
</body>
</html>