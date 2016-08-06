# Yii2 DropdownSorted
## Example
```php
use skobka\yii2\widgets\DropdownSorter;
// render dropdown
<?=DropdownSorter::widget([
    'sort' => $dataProvider->sort,
    'attributes' => $dataProvider->sort->attributes,
    'directionSwitcher' => '[data-role="sort-switcher"]',
    'options' => [
        'class' => 'filter-sort-by-field ss-ui-select',
    ],
]);?>
<!-- Use direction switc button -->
<button
    data-role="sort-switcher"
    class="filter-sort-by-order ss-ui-button ss-ui-button-light-gray ss-ui-icon
        <?=DropdownSorter::getDirection() == SORT_DESC ? 'ss-ui-icon-order-desc' : 'ss-ui-icon-order-asc';?> "
    >
</button>
```