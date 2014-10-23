<?php
class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }
    
    protected function getModel($id)
    {
        $model = isset(Site::$_site_models[$id]) ? Site::$_site_models[$id] : null;
        if(!$model) {
            throw new Exception("mode not found");
        }
        return $model;
    }
    
    public function getIndex()
    {
        exit("index");
    }

    public function getLogin($id)
    {
        $siteModel = $this->getModel($id);
        $site = new $siteModel();
        echo get_class($site)."<br/>";
        if($site->login(true)) {
            echo "成功！";
            echo $site->_curl->getInfo()['http_code']."<br/>";
            echo $site->_curl->getInfo()['url']."<br/>";
        } else {
            echo $site->_curl->getInfo()['http_code']."<br/>";
            echo $site->_curl->getInfo()['url']."<br/>";
            echo $site->_curl->getExec();
        }
    }
    
    public function getFair($id)
    {
        $siteModel = $this->getModel($id);
        $site = new $siteModel();
        echo get_class($site)."<br/>";
        if($site->getFairs(date('Y'),date('m'))) {
            echo "成功！";
            echo $site->_curl->getInfo()['http_code']."<br/>";
            echo $site->_curl->getInfo()['url']."<br/>";
        } else {
            echo "失敗！";
            echo $site->_curl->getInfo()['http_code']."<br/>";
            echo $site->_curl->getInfo()['url']."<br/>";
            //echo $site->_curl->getExec();
        }
    }
    
    public function getDetail($id)
    {
        $siteModel = $this->getModel($id);
        $site = new $siteModel();
        //echo get_class($site)."<br/>";
        if($site->getFairDetail(2425515)) {
            //echo "成功！";
            //echo $site->_curl->getInfo()['http_code']."<br/>";
            //echo $site->_curl->getInfo()['url']."<br/>";
            //echo $site->_curl->getExec();
        } else {
            //echo "失敗！";
            //echo $site->_curl->getInfo()['http_code']."<br/>";
            //echo $site->_curl->getInfo()['url']."<br/>";
            //echo $site->_curl->getExec();
        }
    }
    
    public function getAdd($id)
    {
        $siteModel = $this->getModel($id);
        $site = new $siteModel();
        //echo get_class($site)."<br/>";
        if($site->addFair(87)) {
            //echo "成功！";
            //echo $site->_curl->getInfo()['http_code']."<br/>";
            //echo $site->_curl->getInfo()['url']."<br/>";
            //echo $site->_curl->getExec();
        } else {
            //echo "失敗！";
            //echo $site->_curl->getInfo()['http_code']."<br/>";
            //echo $site->_curl->getInfo()['url']."<br/>";
            //echo $site->_curl->getExec();
        }
    }
    
    public function getUpdate($id)
    {
        $siteModel = $this->getModel($id);
        $site = new $siteModel();
        //echo get_class($site)."<br/>";
        if($site->updateFair(87)) {
            //echo "成功！";
            //echo $site->_curl->getInfo()['http_code']."<br/>";
            //echo $site->_curl->getInfo()['url']."<br/>";
            //echo $site->_curl->getExec();
        } else {
            //echo "失敗！";
            //echo $site->_curl->getInfo()['http_code']."<br/>";
            //echo $site->_curl->getInfo()['url']."<br/>";
            //echo $site->_curl->getExec();
        }
    }
    
    public function getDelete($id)
    {
        $siteModel = $this->getModel($id);
        $site = new $siteModel();
        //echo get_class($site)."<br/>";
        $site->deleteFair(87);
    }
    
    public function getTokuten()
    {
        $site = new SiteRakuten();
        $site->getTokuten();
    }
    
    public function getUtokuten()
    {
        $site = new SiteRakuten();
        $site->updateTokuten();
    }
}
