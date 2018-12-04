<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function databaseUsage(){
        //查询语句1
//        $books = DB::select('select * from book where book = :books',['books'=>1]);
        //查询语句2
//        $books = DB::select('select * from book where book = ?',[1]);
        //更新语句--返回执行多少条
//        $rows = DB::update('update book set size=? where book = ?',[1000,1]);
        //删除语句--返回执行多少条
//        $rows = DB::delete('delete from book where book > ?',[80]);
        //插入语句
//        DB::insert('insert into books() VALUE ()',[]);
//        return view('index.data',['books'=>$books]);

        set_time_limit(0);
        $data = [
            '都市神王'=>'http://s.kjcdn.com/i/pubwmrsn/8c/b4/ke72.jpg',
            '都市逆天神豪'=>'http://s.kjcdn.com/i/pubwmrsn/8c/b4/1h5mr.jpg',
            '阴阳镇鬼师'=>'http://s.kjcdn.com/i/pubwmrsn/8c/b4/1h5bs.jpg'
        ];
        $saveDir = '../../';
        foreach ($data as $name=>$cover){
            $this->crabImage($cover,$saveDir,$name.'.jpg');
        }
    }

    /**
     * PHP将网页上的图片攫取到本地存储
     * @param string $imgUrl 图片url地址
     * @param string $saveDir 本地存储路径 默认存储在当前路径
     * @param null $fileName 图片存储到本地的文件名
     * @return mix
     */
    function crabImage($imgUrl, $saveDir='../../', $fileName=null){
        if(empty($imgUrl)){
            return false;
        }

        //获取图片信息大小
        $imgSize = getImageSize($imgUrl);
        if(!in_array($imgSize['mime'],array('image/jpg', 'image/gif', 'image/png', 'image/jpeg'),true)){
            return false;
        }

        //获取后缀名
        $_mime = explode('/', $imgSize['mime']);
        $_ext = '.'.end($_mime);

        if(is_null($fileName)){  //生成唯一的文件名
            $fileName = uniqid(time(),true).'.jpg';
        }

        //开始攫取
        ob_start();
        readfile($imgUrl);
        $imgInfo = ob_get_contents();
        ob_end_clean();

        if(!file_exists($saveDir)){
            mkdir($saveDir,0777,true);
        }
        $fp = fopen($saveDir.$fileName, 'a');
        $imgLen = strlen($imgInfo);    //计算图片源码大小
        $_inx = 1024;   //每次写入1k
        $_time = ceil($imgLen/$_inx);
        for($i=0; $i<$_time; $i++){
            fwrite($fp,substr($imgInfo, $i*$_inx, $_inx));
        }
        fclose($fp);
        return array('file_name'=>$fileName,'save_path'=>$saveDir.$fileName);
    }

}