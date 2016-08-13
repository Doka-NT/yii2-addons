<?php
/**
 * @author Soshnikov Artem <213036@skobka.com>
 * @copyright (c) 13.08.16
 */

namespace skobka\yii2\widgets;

use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * Provides dropdown widget to select perPage item list size
 *
 * Example:
 * <code>
 * use skobka\yii2\widgets\PageSizeWidget;
 *
 * echo PageSizeWidget::widget(['dataProvider' => $dataProvider]);
 * </code>
 */
class PageSizeWidget extends Widget
{
    /**
     * @var array
     */
    public $pageSizes = [10, 30, 60, 90];
    /**
     * @var ActiveDataProvider
     */
    public $dataProvider;
    /**
     * Options to be passed as html attributes
     * @var array
     */
    public $options = [];
    /**
     * @var string
     */
    public $dataRoleAttr = 'page-size-widget';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerJs();
        echo $this->getSelector();
    }

    /**
     * @return string
     */
    protected function getSelector()
    {
        $items = [];
        $currentPage = $this->dataProvider->pagination->page;
        $selection = null;
        foreach ($this->pageSizes as $size) {
            $url = $this->dataProvider->pagination->createUrl($currentPage, $size);
            $items[$url] = \Yii::t('app', 'По {n,number}', ['n' => $size]);
            if ($size == $this->dataProvider->pagination->pageSize) {
                $selection = $url;
            }
        }

        $this->options['data-role'] = $this->dataRoleAttr;

        return Html::dropDownList('page-size-widget-size', $selection, $items, $this->options);
    }

    /**
     * Additional js
     */
    public function registerJs()
    {
        $this->view->registerJs(
            "$('[data-role=\"page-size-widget\"]').on('change', function() { window.location.href = $(this).val()});",
            View::POS_LOAD
        );
    }
}
