<?php

namespace samuelelonghin\formatter;

use yii\base\InvalidConfigException;

class Formatter extends \yii\i18n\Formatter
{
	public $dbDateTimeFormat = 'yyyy-MM-dd HH:mm:ss';
	public $dbDateFormat = 'yyyy-MM-dd';
	public $dbTimeFormat = 'HH:mm:ss';

	public $formDateTimeFormat;
	public $formDateFormat;
	public $formTimeFormat;

	/**
	 * @param $value
	 * @return string
	 * @throws InvalidConfigException
	 */
	public function asDbDateTime($value)
	{
		return $this->asDateTime($value, $this->dbDateTimeFormat);
	}

	/**
	 * @param $value
	 * @return string
	 * @throws InvalidConfigException
	 */
	public function asFormDateTime($value)
	{
		return $this->asDateTime($value, $this->formDateTimeFormat);
	}

	/**
	 * @param $value
	 * @return string
	 * @throws InvalidConfigException
	 */
	public function asDbDate($value)
	{
		return $this->asDate($value, $this->dbDateFormat);
	}

	/**
	 * @param $value
	 * @return string
	 * @throws InvalidConfigException
	 */
	public function asFormDate($value)
	{
		return $this->asDate($value, $this->formDateFormat);
	}

	/**
	 * @param $value
	 * @return string
	 * @throws InvalidConfigException
	 */
	public function asDbTime($value)
	{
		return $this->asTime($value, $this->dbTimeFormat);
	}

	/**
	 * @param $value
	 * @return string
	 * @throws InvalidConfigException
	 */
	public function asFormTime($value)
	{
		return $this->asTime($value, $this->formTimeFormat);
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
