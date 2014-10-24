<?php

class FairController extends BaseController {

    public function getIndex()
    {
        $dates = FairDate::all();
        return View::make('fair/_index',compact('dates'));
    }
    
    public function getDetail($id)
    {
        $fair = Fair::findOrFail($id);
        return View::make('fair/_detail',compact('fair'));
    }
    
    public function getNew()
    {
        $fair = new Fair();
        return View::make('fair/_edit',compact('fair'));
    }
}
