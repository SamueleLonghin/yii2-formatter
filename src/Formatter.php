<?php

namespace samuelelonghin\formatter;

use rmrevin\yii\fontawesome\component\Icon;
use rmrevin\yii\fontawesome\FA;
use samuelelonghin\db\ModelString;
use samuelelonghin\db\ActiveRecord;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\bootstrap5\Html;

class Formatter extends \yii\i18n\Formatter
{
	public $dbDateTimeFormat = 'yyyy-MM-dd HH:mm:ss';
	public $dbDateFormat = 'yyyy-MM-dd';
	public $dbTimeFormat = 'HH:mm:ss';

	public $formDateTimeFormat;
	public $formDateFormat;
	public $formTimeFormat;
	public $userPermission;
	public $userClass;
	public $telPrefix = "";

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
	public function asRawTime($value)
	{
		$temp = $this->timeZone;
		$this->timeZone = $this->defaultTimeZone;
		$res = $this->asTime($value, $this->dbTimeFormat);
		$this->timeZone = $temp;

		return $res;
	}

	public function asMinutes($value)
	{
		return $this->asRawTime(intval($value) * 60);
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


	public function asScadenzaMesi($value): string
	{
		$mesi = intval($value);
		return $this->asText(
			Yii::t('app/formatter', '{n,plural,=0{non ha scadenza} =1{1 mese} other{# mesi}}', ['n' => $mesi])
		);
	}

	public function asScadenza($value): string
	{
		if (($mesi = intval($value)))
			throw new Exception('cambia in ScadenzaMesi');
		return $this->asText(
			Yii::t('app/formatter', '{n,plural,=0{non ha scadenza} =1{1 mese} other{# mesi}}', ['n' => $mesi])
		);
	}

	public function asDataScadenza($value): string
	{
		if (!$value || $value < 0) {
			return Yii::t('app/formatter', 'mai');
		}
		return $this->asDate($value);
	}

	/**
	 * @param $value
	 * @return string|null
	 */
	public function asLink($value): ?string
	{
		if ($value instanceof ModelString && $value instanceof ActiveRecord) {
			$text = $this->asText($value->toString());
			return Html::a($text, ['/' . $value::getController() . '/view', 'id' => $value->id]);
		}
		if (is_array($value)) {
			$out = '';
			foreach ($value as $item) {
				$out .= $this->asLink($item) . "\n";
			}
			return $out;
		}
		return null;
	}

	/**
	 * @param $value
	 * @return string|null
	 */
	public function asLinkIfCan($value): ?string
	{
		if ($value instanceof ModelString && $value instanceof ActiveRecord) {
			$text = $this->asText($value->toString());
			if (isset($this->userClass) && isset($this->userPermission)) {
				if ($this->userClass::_can(get_class($value), $value->id, $this->userPermission))
					return Html::a($text, [$value::getBaseUrl('view'), 'id' => $value->id]);
				return $text;
			}
		}
		return null;
	}


	public function asTel($value): string
	{
		return Html::a($value, "tel:$value");
	}

	public function asTelephone($value): string
	{
		return $this->asTel($value) . ' ' . $this->asWhatsapp($value);
	}

	public function asWhatsapp($value): string
	{
		return Html::a(Html::tag('i', '', ['class' => 'fab fa-' . FA::_WHATSAPP]), "https://wa.me/{$this->telPrefix}{$value}");
	}

	public function asTextArea($value): string
	{
		return Html::tag('div', $value, ['style' => 'white-space: pre-line']);
	}
}
