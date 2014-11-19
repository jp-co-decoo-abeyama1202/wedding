<?php
/**
 * @author admin-97
 */
class WorkZexyImage extends Eloquent 
{
    public static $photoCategoryCdList = array(
        1 => 'フォトフォルダ1',
        2 => 'フォトフォルダ2',
        3 => 'フォトフォルダ3',
    );
    
    public function getFileName()
    {
        return $this->id . ".jpg";
    }
    
    public function getFilePath($short=false)
    {
        $path = $short ? Config::get('application.work.img_short_path') : Config::get('application.work.img_path');
        $path.= substr($path,-1) === DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
        $path.= 'zexy/';
        $path.= $this->getFileName();
        return $path;
    }
}
