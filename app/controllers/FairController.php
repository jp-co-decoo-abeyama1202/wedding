<?php

class FairController extends BaseController 
{   
    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => 'post'));
    }
    
    public function getIndex()
    {
        $dates = FairDate::all();
        return View::make('fair/index',compact('dates'));
    }
    
    public function getDetail($id)
    {
        $fair = Fair::findOrFail($id);
        return View::make('fair/detail',compact('fair'));
    }
    
    public function getNew()
    {
        $fair = new Fair();
        $fair->formatting();
        $tokutens = Tokuten::all();
        return View::make('fair/edit',compact('fair','tokutens'));
    }
    
    public function getEdit($id)
    {
        $fair = Fair::findOrFail($id);
        $fair->formatting();
        $tokutens = Tokuten::all();
        return View::make('fair/edit',compact('fair','tokutens'));
    }
    
    public function getContent($id)
    {
        $contents = Content::all();
        return View::make('fair/content',compact('id','contents'));
    }
    
    public function postConfirm()
    {
        $inputs = Input::all();
        $params = array(
            'total' => array(),
            'gnavi' => array(),
            'mwed' => array(),
            'mynavi' => array(),
            'park' => array(),
            'rakuten' => array(),
            'sugukon' => array(),
            'zexy' => array(),
        );
        $fairId = null;    
        foreach($inputs as $key => $value) {
            if(in_array($key,array('_token','q'))) {
                continue;
            }
            if($key === 'id') {
                $fairId = (int)$value;
                continue;
            }
            //ぐるナビ
            if(preg_match('/gnavi/',$key)) {
                $key = str_replace('gnavi_','',$key);
                $params['gnavi'][$key] = $value;
                continue;
            }
            //みんなの
            if(preg_match('/mwed/',$key)) {
                $key = str_replace('mwed_','',$key);
                $params['mwed'][$key] = $value;
                continue;
            }
            //マイナビ
            if(preg_match('/mynavi/',$key)) {
                $key = str_replace('mynavi_','',$key);
                $params['mynavi'][$key] = $value;
                continue;
            }
            //パーク
            if(preg_match('/park/',$key)) {
                $key = str_replace('park_','',$key);
                $params['park'][$key] = $value;
                continue;
            }
            //楽天
            if(preg_match('/rakuten/',$key)) {
                $key = str_replace('rakuten_','',$key);
                $params['rakuten'][$key] = $value;
                continue;
            }
            //すぐ婚
            if(preg_match('/sugukon/',$key)) {
                $key = str_replace('sugukon_','',$key);
                $params['sugukon'][$key] = $value;
                continue;
            }
            //ゼクシィ
            if(preg_match('/zexy/',$key)) {
                $key = str_replace('zexy_','',$key);
                $params['zexy'][$key] = $value;
                continue;
            }
            //その他
            $params['total'][$key] = $value;
        }
        foreach($params['total'] as $key => $value) {
            echo $key ." => ".$value."<br/>\n";
        }
    }
    
    public function getList()
    {
        $fairs = Fair::all();
        return View::make('fair/list',compact('fairs'));
    }
}
