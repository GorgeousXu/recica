<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;

class HtmlController extends Controller{

    /** 瀑布流+图片懒加载+滑动加载更多（分页加载） */
    public function waterfall(){
        return view('html/waterfall');
    }

    /**
     * 瀑布流页面加载数据
     * @param Request $request
     * @return array
     */
    public function ajax_waterfall(Request $request){
        if($request->ajax()){
            $page = $request->input('page');
            if($page > 2){ //页面限制最多2页数据
                return ['code'=>0];
            }
            $data = [];
            for($i=1;$i<9;$i++){
                $url = asset('/pic/'.$i.'.png');
                list($width,$height) = getimagesize($url);
                $data[] = [
                    'width' => $width,
                    'height' => $height,
                    'url' => $url
                ];
            }
            $data = array_merge($data,$data);

            return ['code'=>100,'data'=>$data,'page'=>$page+1]; //laravel默认return的数组为json格式。这2个同：return response()->json($data);
        }else{
            throw new Exception('非正常访问！');
        }
    }

    /**
     * canvas 学习
     */
    public function canvas(){
        return view('html/canvas');
    }

    /** 转盘抽奖 */
    public function turntable(){
        return view('html.turntable');
    }

    /**
     * 转盘抽奖ajax后台逻辑
     * @param Request $request
     * @return array
     */
    public function ajax_turntable(Request $request){
        if($request->ajax()){
            $reward  = [
                0=>[
                    'award_id' => 1,
                    'award_name' => '500酷币'
                ],
                1=>[
                    'award_id' => 2,
                    'award_name' => '300酷币'
                ],
                2=>[
                    'award_id' => 3,
                    'award_name' => '200酷币'
                ],
                3=>[
                    'award_id' => 4,
                    'award_name' => '50酷币'
                ],
                4=>[
                    'award_id' => 5,
                    'award_name' => '100酷币'
                ],
                5=>[
                    'award_id' => 6,
                    'award_name' => 'iPhone X手机'
                ]
            ];
            shuffle($reward);
            return [
                'code'=>100,
                'data'=>$reward[0]
            ]; //laravel默认return的数组为json格式。这2个同：return response()->json($data);
        }else{
            return [
                'code'=>1,
                'data'=>'非正常访问'
            ];
        }
    }

    /** 视频播放功能 */
    public function video(){
        return view('html.video');
    }

    /** 音乐播放器功能 */
    public function music(){
        return view('html.music');
    }
}