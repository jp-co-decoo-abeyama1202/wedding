<?php
/**
 * 画像情報クラス
 * @author admin-97
 */
class Image extends Eloquent 
{
    public function getFileName()
    {
        return $this->id . ".jpg";
    }
    
    public function getFilePath()
    {
        $path = Config::get('application.sc.img_path');
        $path.= substr($path,-1) === DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
        $path.= $this->getFileName();
        return $path;
    }
}
