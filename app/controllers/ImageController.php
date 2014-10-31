<?php

class ImageController extends BaseController 
{

    public function getIndex()
    {
        return View::make('image/index');
    }
    
    public function getUpload()
    {
        return View::make('image/upload');
    }

}
