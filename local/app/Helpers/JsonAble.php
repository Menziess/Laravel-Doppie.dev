<?php

namespace App\Helpers;

trait JsonAble
{
 	/**
	 * Grab data attribute.
	 *
	 * @param 	string	$key
	 * @return 	mixed
	 */
	public function getData($key)
	{
		$data = is_null($this->data) ? new \stdClass() : json_decode(json_encode($this->data));
		return isset($data->{$key}) ? $data->{$key} : null;
	}

	/**
	 * Set data attribute.
	 *
	 * @param 	string	$key
	 * @param 	mixed	$value
	 * @return 	App\Content
	 */
	public function setData($key, $value)
	{
		$data = is_null($this->data) ? new \stdClass() : json_decode(json_encode($this->data));
		$data->{$key} = $value;
		$data = (object) array_merge((array) $this->data, (array) $data);
		$this->attributes['data'] = json_encode($data);

		return $this;
	}
}
