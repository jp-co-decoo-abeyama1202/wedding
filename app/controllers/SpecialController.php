<?php

class SpecialController extends BaseController 
{
    public function getIndex()
    {
        return View::make('special/index');
    }
    
}
