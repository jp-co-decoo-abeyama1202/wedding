<?php
/**
 * 画像のダウンロード処理を行うQueue
 * @author admin-97
 */
class QueueImageDownload 
{
    /**
     * $data = array(
     *     'id' => 'ログインサイト毎に割り振っているID',
     *     'kbn' => 'Zexyのみで使用。1～3の区分を割り振る。nullの場合は1～3を全てやるようにQueueを登録しなおす'
     *     'page' => 'Zexyのみで使用。ページ数が多い場合タイムアウトするのでページを区切って取得する'
     * );
     * @param type $job
     * @param type $data
     */
    public function fire($job,$data)
    {
        $site = null;
        $id = $data['id'];
        switch($id) {
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
            $job->delete();
        }
        if($id == SiteZexy::SITE_LOGIN_ID) {
            $kbn = isset($data['kbn']) ? $data['kbn'] : null;
            $page = isset($data['page']) ? $data['page'] : 0;
            if(!$kbn) {
                Queue::push('QueueImageDownload',array('id'=>$id,'kbn'=>1));
                Queue::push('QueueImageDownload',array('id'=>$id,'kbn'=>2));
                Queue::push('QueueImageDownload',array('id'=>$id,'kbn'=>3));
            } else {
                $site->getImages($page,$kbn);
            }
        } else {
            $site->getImages();
        }
        $job->delete();
    }
}
