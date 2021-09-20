<?php

namespace samuelelonghin\formatter;

class Formatter extends \yii\i18n\Formatter
{
    public $dbDateTimeFormat = 'yyyy-MM-dd HH:mm:ss';
    public $dbDateFormat = 'yyyy-MM-dd';
    public $dbTimeFormat = 'HH:mm:ss';

    /**
     * @param $value
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function asDbDateTime($value)
    {
        return $this->asDateTime($value, $this->dbDateTimeFormat);
    }

    /**
     * @param $value
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function asDbDate($value)
    {
        return $this->asDate($value, $this->dbDateFormat);
    }

    /**
     * @param $value
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function asDbTime($value)
    {
        return $this->asTime($value, $this->dbTimeFormat);
    }

    /**
     * @param $value
     * @return string
     */
    public function asNumber($value): string
    {
        return $this->asText($value);
    }
}
