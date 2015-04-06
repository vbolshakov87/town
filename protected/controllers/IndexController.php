<?php
/**
 * Главная страница сайта
 */
class IndexController extends IndexTownController
{
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['view'] = 'index_2015';
        $actions['index']['limit'] = Yii::app()->params['limitOnPage'];

        return $actions;
    }
}