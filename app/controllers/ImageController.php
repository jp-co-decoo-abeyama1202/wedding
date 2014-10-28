<?php

class ImageController extends BaseController 
{

    public function getUpload()
    {
        return View::make('image/upload');
    }

}
