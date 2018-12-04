<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>瀑布流</title>

    <style>
        ul{
            position: relative;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            list-style: none;
            padding: 0;
        }
        ul:after{
            display: block;
            content: '';
            clear: both;
        }
       .box{
            float: left;
           width: 48%;
           margin: 10px 1%;
            /*width: 23%;*/
            /*margin: 10px 1%;*/
            border-radius: 10px;
            box-shadow: 0 1px 5px #9e9e9e5e;
        }
        .img{
            height: 0;
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="container">
    <ul data-page=1></ul>
</div>
<script type="text/javascript" src="{{asset('/common/js/jquery2.2.1/jquery.min.js')}}"></script>
<script>
//    $(function () { //不能在页面加载好之后执行，不加这个会先执行

    var load = true;
    get_data(); //页面第一次加载获取数据
    waterfall(); //获取数据之后进行页面排版--瀑布流
    lazyload();//数据里面有图片元素，可以不一次性都显示出来，所以加上懒加载

    //这个页面判断和懒加载不一样，这个是加载一页的书籍[可能超出屏幕]，而懒加载是加载显示出来的一个屏幕的图片 ！！！！！！
    $(window).scroll(function () { //页面滚动到数据底部，再次加载下一页的数据，重复上述操作
        var winHeight = $(window).height(),
            pageHeight = $(document).height(),
            scrollHeight = $(window).scrollTop();
        if((winHeight + scrollHeight) >= pageHeight){
            get_data();
            waterfall();
        }
        lazyload();
    });






    function get_data() {
        var html,rate;
        var page = $('ul').attr('data-page');
        if(load){
            load = false;
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'/ajax_waterfall',
                async:false,//false为同步执行，ajax所有执行完毕才会往下，true是异步执行
                data:{
                    page:page
                },
                beforeSend:function () {
                    $('.container').append('<div class="load-text" style="text-align: center;">正在加载~'+page+'</div>');
                },
                success:function (res) {
                    $('.load-text').remove();
                    if(res.code == 100){
                        $('ul').attr('data-page',res.page);
                        $.each(res.data,function (index,item) {
                            rate = (item.height/item.width)*100;
                            html = '<li class="box box-item">' +
                                '<div class="img" style="padding-bottom: '+rate+'%" data-src="'+item.url+'"></div>' +
                                '<div>天行九歌韩非卫庄</div>' +
                                '</li>';
                            $('ul').append(html);
                        });

                        load = true;
                    }else{
                        $('.container').append('<div style="text-align: center;">加载完成~</div>');
                    }
                },
                error:function (error) {
                    console.log(error);
                }
            });
        }
    }

//    });
    function waterfall() {
        //num：浏览器一行可以存储多少个图片 outWidth(true)就包括了所有margin padding border所有【因为例子中确定一列有4个图，所以可以直接写为4】
        //columnHeightArr:存储每一列图片的高度，这个数组的长度就是num
        //minHeight:最小高度
        //minHeightIndex：最小高度的列
        //之后遍历所有的图片，将图片高度存储到columnHeightArr数组里，从第二行开始，将图片定位到高度最小的一列下面
        //然后放完一张图片就增加该列的高度
        var boxArr = $('.box'),
            num = 2,
//                    num = Math.floor(document.body.clientWidth / boxArr.eq(0).outerWidth(true)),
            columnHeightArr = [],
            minHeight = 0,
            minHeightIndex = 0;
        columnHeightArr.length = num;


        boxArr.each(function (index,item) {
            if(index < num){
                columnHeightArr[index] = $(item).position().top + $(item).outerHeight(true);
            }else{
                minHeight = Math.min.apply(null,columnHeightArr);//计算数组中的最小值
                minHeightIndex = $.inArray(minHeight,columnHeightArr);//计算该值在数组中的位置，返回索引

                $(item).css({
                    'position':'absolute',
                    'top':minHeight,
                    'left':boxArr.eq(minHeightIndex).position().left
                });

                columnHeightArr[minHeightIndex] += $(item).outerHeight(true);//b1943b
            }
        });

        //这个相当于控制了ul的长度
        $('ul').css('min-height',Math.max.apply(null,columnHeightArr));
    }
    //图片懒加载---就是在图片没有显示之前，先将框框留出来
    function lazyload() {
        var boxItemArr = $('.box-item');

        boxItemArr.each(function (index,item) {
            var viewTop = $(item).offset().top - $(window).scrollTop(), //元素头部的距离去掉滚动的距离，就是落在屏幕上的距离
                viewBottom = $(item).offset().top + $(item).outerHeight(true); //元素自身的高度，加上头部的距离。就是离屏幕上面有多远
            if(viewTop <= $(window).height() && viewBottom >= $(window).scrollTop()){ //临界点：元素头部与屏幕底部平齐，元素底部与屏幕头部平齐
                var imgObj = $(item).find('.img');
                imgObj.css('backgroundImage','url('+imgObj.attr('data-src')+')').removeAttr('data-src');
                $(item).removeClass('box-item');
            }
        });
    }
</script>
</body>
</html>
