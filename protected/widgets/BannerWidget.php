<?php
/**
 * Вывод баннеров на сайте
 * @property FrontController $controller
 */
class BannerWidget extends CWidget
{
    public $view = null;
    public $keywords = array();


    public function run()
    {
        $displayBanners = true;
	    $displayBannerPlaces = false;

	    if(_ENVIRONMENT == 'development') {
            $showBanners = Yii::app()->getRequest()->getParam('banners', false) !== false;
            if(!$showBanners){
                $displayBanners = false;
            }
        }

	    $showBannerPlaces = Yii::app()->getRequest()->getParam('adv', false) !== false;
	    if($showBannerPlaces) {
		    $displayBannerPlaces = true;
	    }

	    if ($this->controller->disableBanners === true) {
		    $displayBanners = false;
	    }

        $this->render('banners/'.$this->view, array(
                'keywords' => $this->keywords,
                'displayBanners' => $displayBanners,
                'displayBannerPlaces' => $displayBannerPlaces,
            )
        );
    }
}
