<?php
/**
 * 画像のアップロード処理を行うQueue
 * @author admin-97
 */
class QueueImageUpload
{
    /**
     * $data = array(
     *     'image_id' => 'images.id',
     *     'site_id' => 'ログインサイト毎に割り振っているID',
     * );
     * @param type $job
     * @param type $data
     */
    public function fire($job,$data)
    {
        $imageId = isset($data['image_id']) ? $data['image_id'] : null;
        if(!$imageId) {
            $job->delete();
            return;
        }
        $image = Image::find($imageId);
        if(!$image) {
            $job->delete();
            return;
        }
        $site = null;
        $siteId = isset($data['site_id']) ? $data['site_id'] : null;
        switch($siteId) {
            case SiteZexy::SITE_LOGIN_ID:
                $site = new SiteZexy();
                break;
            case SiteMynavi::SITE_LOGIN_ID:
                $site = new SiteMynavi();
                break;
            case SiteRakuten::SITE_LOGIN_ID:
                $site = new SiteRakuten();
                break;     
        }
        if(!$site) {
            if($image->upload_zexy === Image::UPLOAD_REGIST) {
                Queue::push('QueueImageUpload',array('image_id'=>$imageId,'site_id'=>SiteZexy::SITE_LOGIN_ID));
            }
            if($image->upload_mynavi === Image::UPLOAD_REGIST) {
                Queue::push('QueueImageUpload',array('image_id'=>$imageId,'site_id'=>SiteMynavi::SITE_LOGIN_ID));
            }
            if($image->upload_rakuten === Image::UPLOAD_REGIST) {
                Queue::push('QueueImageUpload',array('image_id'=>$imageId,'site_id'=>SiteRakuten::SITE_LOGIN_ID));
            }
        }
        $site->uploadImage($imageId);
        $job->delete();
    }
}
