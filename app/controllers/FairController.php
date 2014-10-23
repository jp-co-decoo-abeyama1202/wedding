<?php

class FairController extends BaseController {

    public function getIndex()
    {
        return View::make('fair/_index');
    }
    
    public function getDetail($id)
    {
        return View::make('fair/_detail');
    }
}
