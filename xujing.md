### 核心点
1、控制器文件：app-http-controllers
2、视图文件：resources-views
命名格式 .blade.php
3、修改数据库：.env
4、入口文件位置【静态资源文件位置】：public
5、配置路由：routes-web.php

### 具体操作
1、设置公共的头尾
公共部分页面：layout
```html

@include('header')---header视图文件

@yield('content')

@include('footer')---footer视图文件

```

调用子页面：show
```html

@extends('layout')

@section('content')
-----这里是子页面的具体内容
@endsection

```


2、引用资源文件：
{{asset('')}}
