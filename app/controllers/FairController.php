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
    
    public function postPageValidation($page)
    {
        list($result,$messages) = FairValidation::pageValidation($page);
        $m = array();
        if(is_array($messages)) {
            foreach($messages as $key => $values) {
                foreach($values as $v) {
                    $m[] = $v;
                }
            }
        } else {
            $m[] = $messages;
        }
        $m = array_unique($m);
        $response = array(
            'result' => $result ? 'success' : 'failed',
            'message' => implode('<br/>',$m),
        );
        return Response::json($response);
    }
    
    public function postPageLast()
    {
        $keys = Fair::getNewKeys();
        $inputs = Input::only($keys);
        $fair = new Fair();
        $fair->fill($inputs);
        //FairContents作成
        $fairContents = array();
        for($i=1;$i<=8;++$i) {
            if(Input::get('content_id_'.$i)) {
                $keys = array(
                    'content_id_'.$i => 'content_id',
                    'content_text_'.$i => 'name',
                    'content_title_'.$i => 'title', 
                    'content_shoyo_h_'.$i => 'shoyo_h', 
                    'content_shoyo_m_'.$i => 'shoyo_m',
                    'content_description_'.$i => 'description', 
                    'content_reserve_'.$i => 'reserve', 
                    'content_price_flg_'.$i => 'price_flg', 
                    'content_price_'.$i => 'price', 
                    'content_stock_'.$i => 'stock', 
                );
                $params = array();
                foreach($keys as $key => $contentKey) {
                    $params[$contentKey] = Input::get($key);
                }
                $content = new FairContent();
                $content->fill($params);
                $fairContents[] = $content;
            }
        }
        
        return View::make('fair/edit/page9_body',compact('fair','fairContents'));
    }
    
    public function postPageGnaviFreeword()
    {
        $contentIds = array();
        for($i=1;$i<=8;$i++) {
            if(Input::get('content_id_'.$i)) {
                $contentIds[] = Input::get('content_id_'.$i);
            }
        }
        if(!$contentIds) {
            return Response::json(array('result'=>'failed','message'=>'フェア内容が設定されていません。'));
        }
        $message = array();
        foreach(Content::whereIn('id',$contentIds)->get() as $content) {
            if(!$content->gnavi_id) {
                $message[] = $content->getContentName();
            } else if($content->rakuten_name_3) {
                $message[] = $content->rakuten_name_2;
                $message[] = $content->rakuten_name_3;
            } else if($content->rakuten_name_2) {
                $message[] = $content->rakuten_name_2;
            }
        }
        $message = array_unique($message);
        return Response::json(array('result'=>'success','message'=>implode(',',$message)));
    }
}
