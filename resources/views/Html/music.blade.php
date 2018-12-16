<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/iconfont.css')}}">
    <title>音乐播放器</title>
    <style>
        /*移动端触摸不会出现阴影*/
        * {
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            -webkit-tap-highlight-color: transparent;
        }
        body{
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .container{
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            overflow: hidden;
        }
        .chapter-box p{
            text-align: center;
        }
        .chapter-name{
            font-size: 18px;
            font-weight: bold;
        }

        .book-cover{
            background: url(http://s.kjcdn.com/i/pubwmrs/6o/8w/1hdik.jpg) no-repeat center;
            background-size: cover;
            width: 70%;
            padding-bottom: 70%;
            border-radius: 50%;
            margin: 20px auto;
            box-shadow: 5px 5px 20px #9e9e9e5e;
        }
        .cover-active{
            animation:play 30s linear infinite;
            -webkit-animation-fill-mode: forwards;
            -moz-animation-fill-mode: forwards;
            -o-animation-fill-mode: forwards;
            animation-fill-mode: forwards;
        }

        @keyframes play{
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /*播放进度条*/
        .bar-box{
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            align-items: center;
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            justify-content: space-between;
            padding: 0 10px;
        }

        .left-box,.right-box{
            color: #ccc;
            font-size: 12px;
        }

        .center-box{
            -webkit-box-flex: 1;
            -webkit-flex: 1 1 0;
            flex: 1 1 0;
            padding: 0 12px;
        }
        .slider-bar{
            width: 100%;
            height:2px;
            border-radius: 2px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;

            position: relative;
            display: block;
            background-color: #ff2000;
        }
        .slider-progress{
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            left: 0;
            background: #e5e5e5;
        }
        .slider-dot-control{
            position: absolute;
            z-index: 99;
            width: 10px;
            height: 10px;
            top: -6px;
            left: -5px;
            background-color: #fff;
            border: 2px solid #ff2000;
            -webkit-border-radius: 50%;
            border-radius: 50%;
            -webkit-box-shadow: 0 0 4px hsla(0,0%,100%,.5);
            box-shadow: 0 0 4px hsla(0,0%,100%,.5);
        }

        .control-box{
            margin: 10px 10px 0;
            height: 50px;
            line-height: 50px;
        }
        .control-box:after{
            content: '';
            clear: both;
            display: block;
        }
        .control-box>div{
            float: left;
            width: 20%;
            margin: 0 auto;
            text-align: center;
        }
        .control-box .iconfont{
            font-size: 26px;
        }
        .control-box .icon-center{
            font-size: 40px;
            color: #ff2000;
        }

        .bottom-box{
            position: absolute;
            bottom: 5%;
            left:0;
            right:0;
        }

        .cover-box{
            position: absolute;
            left: 0;
            right: 0;
            top: 20%;
            max-width: 420px;
            margin: 0 auto;
        }

        .black-mask{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,.6);
            z-index: 99;
            top:0;
        }
        .category-list{
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #fafafa;

            -webkit-animation: catelist .3s;
            -o-animation: catelist .3s;
            animation: catelist .3s;
        }

        @keyframes catelist /* Safari and Chrome */
        {
            0%{opacity:0;-webkit-transform:translateY(100px);}
            100%{opacity:1;-webkit-transform:translateY(0);}
        }
        @-webkit-keyframes catelist /* Safari and Chrome */
        {
            0%{opacity:0;-webkit-transform:translateY(100px);}
            100%{opacity:1;-webkit-transform:translateY(0);}
        }

        .popup-header{
            height: 40px;
            line-height: 40px;
            padding: 0 10px;
            border-bottom: 1px solid #f0f0f0
        }
        .popup-header .header{
            font-size: 18px;
            font-weight: bold;
            padding-bottom: 4px;
            border-bottom: 1px solid #ff2000;
        }
        .popup-header .desc{
            color: #999;
            font-size: 13px;
            margin-left: 10px;
        }
        .popup-header .popup-close{
            position: absolute;
            right: 0;
            padding: 0 20px;
            font-size: 20px;
        }
        .move-list {
            height: 350px;
            overflow-x: hidden;
            overflow-y: auto;
            overflow-scrolling: touch;
            -webkit-overflow-scrolling: touch;
        }

        /*和上面的touch css 配合使用，解决ios端滑动不顺畅的问题*/
        .move-list:after {
            min-height: calc(100% + 1px);
        }
        ul.popup-list{
            margin: 0 auto;
            padding: 0 10px;
            list-style: none;
        }
        .item-box{
            position: relative;
            height: 55px;
            border-bottom: 1px solid #f0f0f0;
        }
        .item-box .title{
            line-height: 40px;
            height: 30px;
            color: #333;
        }
        .item-box .time{
            line-height: 20px;
            height: 20px;
            font-size: 12px;
            color: #999;
        }
        .icon-time{
            color: #999;
            font-size: 14px;
            padding-right: 2px;
        }
        .item-box .yinpin{
            display: none;
            position: absolute;
            right: 0;
            font-size: 24px;
            top: 13px;
            color: #ff2000;
        }
        .icon-vip{
            color: #ffc000;
            padding-left: 5px;
        }

        .expensive-box{
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #fafafa;
            height: 240px;

            -webkit-animation: buybox .3s;
            -o-animation: buybox .3s;
            animation: buybox .3s;
        }
        @keyframes buybox{
            0%{
                height: 150px;
            }
            100%{
                height: 240px;
            }
        }
        @-webkit-keyframes buybox{
            0%{
                height: 150px;
            }
            100%{
                height: 240px;
            }
        }
        .expensive-div{
            padding: 20px;
        }

        .expensive-desc{
            text-align: center;
            font-size: 20px;
            color: #a9965e;
        }
        .expensive-button a{
            margin: 0 auto;
            display: block;
            width: 100%;
            padding: 10px 0;
            background: #ff2000;
            box-shadow: 0 4px 20px 0 rgba(0,0,0,.1);
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            color: #fff;
        }
        .money{
            margin: 20px auto 10px;
            color: #999;
            letter-spacing: 1px;
            font-size: 14px;
        }
        .price{
            color: #ff2000;
            font-weight: bold;
        }
        .shubi{
            color: #4e4e4e;
            font-weight: bold;
        }
        .subscribe-box{
            text-align: center;
            padding: 15px 0 0;
        }
        #subscribe {
            display: none;
        }
        .sub-border {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 2px #9e9e9e solid;
            vertical-align: middle;
            -webkit-border-radius: 10%;
            margin: 0 4px 2px 0;
        }
        .sub-in {
            margin: 1px auto 0 auto;
            width: 9px;
            height: 9px;
            background: #ff2000;
            vertical-align: middle;
            -webkit-border-radius: 10%;
        }

        .mask-msg{
            display: none;
            position: fixed;
            top: 70%;
            left: 50%;
            margin: 0 auto;
            padding: 10px;
            max-width: 300px;
            -webkit-transform: translate(-50%,-50%);
            transform: translate(-50%,-50%);

            background-color: rgba(3,3,3,.8);
            -webkit-box-shadow: 0 0 4px #999;
            box-shadow: 0 0 4px #999;
            -webkit-border-radius: 8px;
            border-radius: 8px;
        }

        .mask-desc{
            color: #fff;
        }

    </style>
</head>
<body>
    <div class="container">
        {{--标题部分--}}
        <div class="chapter-box">
            <p class="chapter-name" id="chapterName"></p>
            <p class="speaker">主讲：徐徐</p>
        </div>

        {{--封面--}}
        <div class="cover-box">
            <div class="book-cover"></div>
        </div>

        <div class="bottom-box">
            {{--进度条--}}
            <div class="bar-box">
                <div class="left-box played-progress">00:00</div>
                <div class="center-box">
                    <div class="slider-bar">
                        <div class="slider-progress">
                            <div class="slider-dot-control"></div>
                        </div>
                    </div>
                </div>
                <div class="right-box all-progress">05:00</div>
            </div>

            {{--控制播放等--}}
            <div class="control-box">
                <div class="category-control">
                    <span class="iconfont icon-icon_Artboard"></span>
                </div>
                <div class="player-control-prev">
                    <span class="iconfont icon-shangyishouxianxing"></span>
                </div>
                <div class="player-control-play">
                    <span id="iconPlay" class="iconfont icon-bofang icon-center"></span>
                </div>
                <div class="player-control-next">
                    <span class="iconfont icon-xiayishouxianxing"></span>
                </div>
            </div>
        </div>

        <audio src="http://audio.xmcdn.com/group53/M06/54/F2/wKgLcVwHBODwq5b1ADM2evKoLHY587.m4a" id="bookAudio" data-index="1"></audio>
    </div>

    <div class="black-mask" id="catelist">
        <div class="category-list">
            <div class="popup-header">
                <span class="header">播放列表</span>
                <span class="desc" id="audioCount"></span>
                <span class="popup-close iconfont icon-guanbi"></span>
            </div>

            <div class="move-list">
                <ul class="popup-list" id="audioList"></ul>
            </div>
        </div>
    </div>

    <div class="black-mask" id="dingYue">
        <div class="expensive-box">
            <div class="expensive-div">
                <div class="expensive-desc">本章订阅后即可收听</div>
                <div class="money">
                    <div>价格:<span class="price">15</span>酷币</div>
                    <div>余额:<span class="shubi">10</span>书币</div>
                </div>
                <div class="expensive-button">
                    <a href="">订阅本集</a>
                </div>
                <div class="subscribe-box">
                    <input id="subscribe" type="checkbox" name="subscribe">
                    <label for="subscribe" style="font-size: 14px;font-weight: 300;">
                        <div class="sub-border">
                            <div class="sub-in" style="display: none;"></div>
                        </div>
                        不再提醒，自动订阅下一章
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="black-mask" id="buy">
        <div class="expensive-box">
            <div class="expensive-div">
                <div class="expensive-desc">本书购买后即可收听</div>
                <div class="money">
                    <div>价格:<span class="price">15</span>酷币</div>
                    <div>余额:<span class="shubi">10</span>书币</div>
                </div>
                <div class="expensive-button">
                    <a href="">购买本书</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mask-msg">
        <div class="mask-desc">列表循环</div>
    </div>
<script type="text/javascript" src="{{asset('/common/js/jquery2.2.1/jquery.min.js')}}"></script>
<script>
    var bAudio = document.getElementById('bookAudio');
    var audioList = $('#audioList');
    var chapterName = $('#chapterName');
    var playControl = $('.player-control-play')[0];  //播放或者暂停

    var sliderBar = $('.slider-bar')[0]; //进度条轨道
    var sliderProgress = $('.slider-progress')[0]; //进度条
    var playedProgress = $('.played-progress')[0]; //播放时间
    var allProgress = $('.all-progress')[0]; //音频总时长
    var dot = $('.slider-dot-control')[0]; //音频进度小圆点

    var prev = $('.player-control-prev')[0]; //上一首
    var next = $('.player-control-next')[0]; //下一首
    var curIndex = $(bAudio).attr('data-index'); //默认播放的用户点击进去的一首

    var timer; //设置一个定时器
    var power = false; //是否是手动控制进度条

    var list = [
        {'title':'第一章 好好说话','time':'06:54','src':'http://audio.xmcdn.com/group53/M06/54/F2/wKgLcVwHBODwq5b1ADM2evKoLHY587.m4a','is_vip':0},
        {'title':'第二章 好好做人','time':'04:50','src':'http://audio.xmcdn.com/group53/M06/54/F2/wKgLcVwHBODwq5b1ADM2evKoLHY587.m4a','is_vip':0},
        {'title':'第三章 好好发育','time':'05:20','src':'http://audio.xmcdn.com/group53/M06/54/F2/wKgLcVwHBODwq5b1ADM2evKoLHY587.m4a','is_vip':1},
        {'title':'第四章 厚积薄发','time':'09:20','src':'http://audio.xmcdn.com/group53/M06/54/F2/wKgLcVwHBODwq5b1ADM2evKoLHY587.m4a','is_vip':1}
    ];
    var length = 1; //列表个数

    //初始化音频列表
    initAudioList();
    //默认播放的第一首音频

    var ua = window.navigator.userAgent.toLowerCase();
    var is_weixin = false;
    if (ua.match(/MicroMessenger/i) == 'micromessenger') {
        is_weixin = true;
    }

    //初始化音频列表
    initAudioList();
    if (is_weixin) {
        //--创建页面监听，等待微信端页面加载完毕 触发音频播放
        document.addEventListener('WeixinJSBridgeReady', function () {
            changeAudio(curChapter);
        }, false);
    } else {
//        changeAudio(curIndex);
    }

    //点击音频列表切换歌曲
    $('#audioList li').on('click',function () {
        curIndex = $(this).attr('data-index');
        changeAudio(curIndex);
    });
    //点击按钮切换下一首
    $(next).on('click',function () {
        curIndex ++;
        changeAudio(curIndex);
    });
    //点击按钮切换上一首
    $(prev).on('click',function () {
        curIndex --;
        changeAudio(curIndex);
    });
    //控制音频播放和暂停
    $(playControl).on('click',function () {
        if(bAudio.paused){
            bAudio.play();
            play();
        }else{
            bAudio.pause();
            paused();
        }
    });
    //检测音频结束事件
    bAudio.onended = function () {
        if(!power){
            curIndex ++;
            changeAudio(curIndex);
        }
    };
    //检测音频播放事件
    bAudio.onplay = function () {
        play();
    };
    //检测音频暂停事件
    bAudio.onpaused = function () {
        paused();
    };

    //点击进度条改变音频播放进度
    sliderBar.addEventListener('click',function (ev) {
        var ev = ev || event;
        changeProgress(ev.clientX - 5);
    });

    //鼠标拖动小圆改变进度 开始 进行中 结束
    dot.addEventListener('touchstart',function (e) {
        power = true;
    });
    dot.addEventListener('touchmove',function (e) {
        var touch=e.touches[0];
        changeProgress(touch.clientX);
        if(bAudio.ended){
            bAudio.pause();
            paused();
        }
    });
    dot.addEventListener('touchend',function (e) {
        power = false;
    });

    //初始化音频数据列表
    function initAudioList() {
        var html = '';
        length = list.length;
        $('#audioCount').html('共'+length+'集');
        $.each(list,function (key,value) {
            html += '<li data-index="'+key+'"><div class="item-box">' +
                '<div class="title">'+value['title'];
            if(value['is_vip']){
                html += '<span class="iconfont icon-vip"></span>';
            }
            html += '</div><span class="iconfont icon-time"></span>' +
                '<span class="time">'+value['time']+'</span>' +
                '<span class="yinpin iconfont icon-yinpin"></span>';
            html += '</div></li>';
        });
        audioList.html(html);
    }
    //切歌
    function changeAudio(index) {
        if(index >= length){
            show_msg('列表播放完毕啦～');
            paused();
            return false;
        }
        if(index < 0){
            show_msg('已经是第一集啦～');
            paused();
            return false;
        }

        $(bAudio).attr('src',list[index]['src']);
        $(bAudio).attr('data-index',index);
        $(chapterName).html(list[index]['title']);
        $(allProgress).html(list[index]['time']);

        $('.yinpin').each(function (index_s,item) {
            if(index_s == index){
                $(this).show();
            }else {
                $(this).hide();
            }
        });

        //进度条归零
        $(sliderProgress).css('left',0);
        $('.played-progress').html('00:00');

        //封面归位
        $('.book-cover').removeClass('cover-active');
        paused();

        //判断是不是要花钱 能不能播放
        var is_vip = list[index]['is_vip'];
        if(is_vip == 1){
            $('#dingYue').show();
            return false;
        }

        setTimeout(function () {
            bAudio.play();
            play();
        },200);
        return true;
    }
    //播放
    function play() {
//        $(allProgress).html(format(bAudio.duration));
        $('#iconPlay').removeClass('icon-bofang').addClass('icon-bofang1');
        $('.book-cover').addClass('cover-active');
        $('.book-cover').css('animation-play-state','running');
        timer = setInterval(setProgress,1000);
    }
    //暂停
    function paused() {
        $('#iconPlay').removeClass('icon-bofang1').addClass('icon-bofang');
        $('.book-cover').css('animation-play-state','paused');
        timer = clearInterval(timer);
    }
    //自动变换进度条进度
    function setProgress() {
        var percent = bAudio.currentTime/bAudio.duration * 100;
        $(sliderProgress).css('left',percent+'%');
        $(playedProgress).html(format(bAudio.currentTime));
    }
    //手动改变进度
    function changeProgress(clientX){
        var width = sliderBar.clientWidth;
        var percent = parseInt(clientX - 55) / width * 100;
        if(percent < 0){
            percent = 0
        }
        if(percent > 100){
            percent = 100;
        }

        $(sliderProgress).css('left',percent+'%');
        bAudio.currentTime=percent/100*bAudio.duration;    //设置当前时间，以改变真正的播放进度
        $(playedProgress).html(format(bAudio.currentTime));
    }
    //时间格式化为 分：秒
    function format(time) {
        time = parseInt(time);
        var fen=parseInt(time/60);
        var miao=time%60;
        if(fen<=9){
            fen="0"+fen;
        }
        if(miao<=9){
            miao="0"+miao;
        }
        return fen+':'+miao;
    }
    //提示信息
    function show_msg(msg) {
        $('.mask-desc').html(msg);
        $('.mask-msg').fadeIn().delay(500).fadeOut();
    }

    //    自动订阅下一章
    $("#subscribe").change(function () {
        var is_auto = $("#subscribe").is(':checked');
        if (is_auto) {
            $('.sub-in').show();
            $('.sub-border').css('border', '2px #ff2000 solid');
        } else {
            $('.sub-in').hide();
            $('.sub-border').css('border', '2px #9e9e9e solid');
        }
    });

    $('.category-control').on('click',function () {
        $('#catelist').fadeIn(200);
    });
    $('#catelist').on('click',function () {
        $('#catelist').fadeOut(200);
    });
    $('.popup-close').on('click',function () {
        $('#catelist').hide();
    });
</script>
</body>
</html>