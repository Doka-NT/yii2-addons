<?php
/**
 * @author Soshnikov Artem <213036@skobka.com>
 * @copyright (c) 06.08.16
 */
namespace skobka\yii2\widgets;

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\web\JqueryAsset;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\LinkSorter;

class DropdownSorter extends LinkSorter
{
    /**
     * jQuery selector of direction switcher html element.
     * If is null, nothing handler will be attached
     * @var string
     */
    public $directionSwitcher;
    /**
     * @var []
     */
    public static $attributeOrders = [];

    /**
     * @return int SORT_ACS or SORT_DESC
     */
    public static function getDirection()
    {
        if (!static::$attributeOrders) {
            return SORT_ASC;
        }

        return reset(static::$attributeOrders);
    }

    public function init()
    {
        parent::init();
        static::$attributeOrders = $this->sort->getAttributeOrders();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->renderDropdownSorter();
        echo $this->renderJsHandlers();
    }

    /**
     * @return string
     */
    private function renderDropdownSorter()
    {
        $attributes = empty($this->attributes) ? array_keys($this->sort->attributes) : $this->attributes;
        $items = [];

        $sortParams = explode(',', \Yii::$app->getRequest()->get($this->sort->sortParam)) ?: [];
        $sortParam = $sortParams ? ltrim($sortParams[0], '-') : null;
        $selection = null;
        foreach ($attributes as $attribute => $data) {
            $url = $this->sort->createUrl($attribute);
            $items[$url] = $this->getSortItemLabel($attribute);
            if (isset($sortParam) && ($sortParam== $attribute)) {
                $selection = $url;
            }
        }

        $options = $this->options + [
                'data-sort' => 'dropdown',
                'data-sort-dir' => json_encode(static::$attributeOrders),
            ];

        return Html::dropDownList($this->sort->sortParam, $selection, $items, $options);
    }

    /**
     * @param $attribute
     * @return string
     */
    protected function getSortItemLabel($attribute)
    {
        $options = $this->linkOptions;

        if (isset($options['label'])) {
            $label = $options['label'];
            unset($options['label']);
        } else {
            if (isset($this->attributes[$attribute]['label'])) {
                $label = $this->attributes[$attribute]['label'];
            } else {
                $label = Inflector::camel2words($attribute);
            }
        }

        return $label;
    }

    /**
     * Render widget JS
     */
    private function renderJsHandlers()
    {
        JqueryAsset::register($this->view);
        $this->view->registerJs(
            new JsExpression(
                "$('[data-sort=\"dropdown\"]').on('change', function() { console.log(123); window.location.href = $(this).val(); });"
            ),
            View::POS_LOAD
        );

        if ($this->directionSwitcher) {
            $this->view->registerJs(
                "$('".$this->directionSwitcher."').on('click', function(e) { e.preventDefault(); $('[data-sort=\"dropdown\"]').trigger('change'); return false});",
                View::POS_LOAD
            );
        }
    }
}
