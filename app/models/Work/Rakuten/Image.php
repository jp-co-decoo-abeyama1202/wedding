<?php
/**
 * @author admin-97
 */
class WorkRakutenImage extends Eloquent 
{
    public static $genreList = array(
        1 => '挙式',
        2 => '披露宴',
        3 => '料理・ケーキ',
        4 => '演出',
        5 => '眺望・庭・外観',
        10 => 'スタッフ',
        98 => 'ストック用写真'
    );
    
    public function getFileName()
    {
        return $this->id . ".jpg";
    }
    
    public function getFilePath($short=false)
    {
        $path = $short ? Config::get('application.work.img_short_path') : Config::get('application.work.img_path');
        $path.= substr($path,-1) === DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
        $path.= 'rakuten/';
        $path.= $this->getFileName();
        return $path;
    }
}
