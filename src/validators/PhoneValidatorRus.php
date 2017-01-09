<?php
/**
 * @author Soshnikov Artem <213036@skobka.com>
 * @copyright (c) 17.10.16
 */

namespace skobka\yii2\validators;

use yii\validators\Validator;

/**
 * Валидатор номера телефона
 * @package components\validators
 */
class PhoneValidatorRus extends Validator
{
    /**
     * @var string Сообщение об ошибке, о допустимости только российских номеров
     */
    public $messageRus;
    /**
     * @var string Сообщение об ошибке, о необходимости указания код региога
     */
    public $messageReg;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->messageRus === null) {
            $this->messageRus = 'Телефонный номер указан неверно: допустимы только номера российских операторов связи';
        }
        if ($this->messageReg === null) {
            $this->messageReg = 'Телефонный номер указан неверно: возможно, Вы забыли указать код региона';
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = (string)preg_replace('/(\D+)/', '', $model->$attribute);
        $len = strlen($model->$attribute);
        if ($len == 11 && in_array($model->{$attribute}[0], ['7', '8'])) {
            $model->$attribute = substr($model->$attribute, 1);
        } else {
            if ($len >= 11) {
                $this->addError($model, $attribute, $this->messageRus);
                return;
            } else {
                if ($len < 10) {
                    $this->addError($model, $attribute, $this->messageReg);
                    return;
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $options = [
            'message' => $this->messageRus
        ];
        $optionJson = json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
        var options = {$optionJson};
        var regexp = /^(\+7{0,1}|8{0,1})\d{10}$/;
        value = value.replace(/[\(\)-\s]+/g, '');

        if (value && !regexp.test(value)){
            //noinspection JSUnresolvedVariable
            messages.push(options.message);
        }
JS;
    }
}
