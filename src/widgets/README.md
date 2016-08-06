# Examples
## Yii2 DropdownSorter
```php
use skobka\yii2\widgets\DropdownSorter;
// render dropdown
<?=DropdownSorter::widget([
    'sort' => $dataProvider->sort, // Required
    'attributes' => $dataProvider->sort->attributes, // Required
    'directionSwitcher' => '[data-role="sort-switcher"]', // Optional, use with direction switcher. Must be valid CSS selector
]);?>
<!-- Use direction switc button -->
<button
    data-role="sort-switcher"
    class="<?=DropdownSorter::getDirection() == SORT_DESC ? 'order-desc' : 'order-asc';?> ">
    Change sort direction
</button>
```
