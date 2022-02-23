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

	protected function swipeTimeZone()
	{
		$temp = $this->timeZone;
		$this->timeZone = $this->defaultTimeZone;
		$this->defaultTimeZone = $temp;
	}

	/**
	 * @param $value
	 * @return string
	 * @throws InvalidConfigException
	 */
	public function asDbDateTime($value)
	{
		$this->swipeTimeZone();
		$res = $this->asDateTime($value, $this->dbDateTimeFormat);
		$this->swipeTimeZone();

		return $res;
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
		$this->swipeTimeZone();
		$res = $this->asDate($value, $this->dbDateFormat);
		$this->swipeTimeZone();

		return $res;
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
		$this->swipeTimeZone();
		$res = $this->asTime($value, $this->dbTimeFormat);
		$this->swipeTimeZone();

		return $res;
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
