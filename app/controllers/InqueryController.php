<?php

class InqueryController extends BaseController {

    public function showTop()
    {
        return View::make('index');
    }
    
    public function showWelcome()
    {
        return View::make('hello');
    }

}
