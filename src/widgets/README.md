# Examples
## Yii2 DropdownSorter
```php
<?php
/* @var $dataProvider yii\data\ActiveDataProvider */

use skobka\yii2\widgets\DropdownSorter;

// render dropdown
echo DropdownSorter::widget([
    'sort' => $dataProvider->sort, // Required
    'attributes' => $dataProvider->sort->attributes, // Required
    'directionSwitcher' => '[data-role="sort-switcher"]', // Optional, use with direction switcher. Must be valid CSS selector
]);?>
<!-- Use direction switch button -->
<button
    data-role="sort-switcher"
    class="<?=DropdownSorter::getDirection() == SORT_DESC ? 'order-desc' : 'order-asc';?> ">
    Change sort direction
</button>
```

## PageSizeWidget
```php
<?php
/* @var $dataProvider yii\data\ActiveDataProvider */

use skobka\yii2\widgets\PageSizeWidget;

//...
echo PageSizeWidget::widget(['dataProvider' => $dataProvider]);
```
**Options**
- *dataProvider* - *required* instanceof yii\data\ActiveDataProvider;
- *pageSizes* - array like [10, 30, 60, 90]
- *options* - array of html attributes, like ['class' => 'my-super-class']
- *dataRoleAttr* - custom data-role attribute value, if your prefer to attach custom event listeners

