<?php

namespace Benjafield\Checkout;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class BasketItem implements Arrayable, Jsonable
{
	/**
	 * The generated ID of the basket item.
	 *
	 * @var string
	 */
	public $itemId;

	/**
	 * The FQN of the associated item.
	 *
	 * @var string
	 */
	public $type;

	/**
	 * The ID of the added item.
	 *
	 * @var int|string
	 */
	public $id;

	/**
	 * The quanity of this item.
	 *
	 * @var int
	 */
	public $quantity;

	/**
	 * Options for this item.
	 *
	 * @var array
	 */
	public $options;

	/**
	 * The price group for this item.
	 *
	 * @var string
	 */
	public $group;

	/**
	 * The category for this item.
	 *
	 * @var string
	 */
	public $category;

	/**
	 * Basket Item Constructor
	 *
	 * @param string $type
	 * @param mixed  $id
	 * @param string $name
	 * @param float  $price
	 * @param array  $options
	 */
	public function __construct($type, $id, $name, $price, $group, $category = null, array $options = [])
	{
		if(empty($type)) throw new \InvalidArgumentException('Please supply a valid item type.');
		if(empty($id)) throw new \InvalidArgumentException('Please supply a valid ID.');
		if(empty($name)) throw new \InvalidArgumentException('Please supply a valid name.');
		if(empty($group)) throw new \InvalidArgumentException('Please supply a valid price group.');
		if(strlen($price) < 0 || !is_numeric($price)) throw new \InvalidArgumentException('Please supply a valid price.');

		$this->type     = $type;
		$this->id       = $id;
		$this->name     = $name;
		$this->price    = $price;
		$this->group    = $group;
		$this->category = $category;
		$this->options  = new BasketItemOptions($options);
		$this->itemId   = $this->generateItemId($id, $options);
	}

	/**
	 * Returns the formatted price.
	 *
	 * @param  int    $decimalPlaces
	 * @param  string $decimalPoint
	 * @param  string $thousandSeparator
	 * @return string
	 */
	public function price($decimalPlaces = null, $decimalPoint = null, $thousandSeparator = null)
	{
		return $this->formatNumber($this->price, $decimalPlaces, $decimalPoint, $thousandSeparator);
	}

	/**
	 * Return the price in pence.
	 *
	 * @param  int    $decimalPlaces
	 * @param  string $decimalPoint
	 * @param  string $thousandSeparator
	 * @return int
	 */
	public function pencePrice($decimalPlaces = null, $decimalPoint = null, $thousandSeparator = null)
	{
		return $this->price($decimalPlaces, $decimalPoint, $thousandSeparator) * 100;
	}

	/**
	 * Returns the subtotal of the item.
	 * @param  int    $decimalPlaces
	 * @param  string $decimalPoint
	 * @param  string $thousandSeparator
	 * @return string
	 */
	public function subtotal($decimalPlaces = null, $decimalPoint = null, $thousandSeparator = null)
	{
		return $this->formatNumber($this->subtotal, $decimalPlaces, $decimalPoint, $thousandSeparator);
	}

	/**
	 * Get the singular string type.
	 *
	 * @return string
	 */
	public function getSingularType()
	{
		return ($this->type == 'App\\Service') ? 'service' : 'product';
	}

	/**
	 * Set the item quantity.
	 *
	 * @param int $quantity
	 */
	public function setQuantity(int $quantity)
	{
		if(empty($quantity) || !is_numeric($quantity)) throw new \InvalidArgumentException('Please supply a valid quantity.');

		$this->quantity = $quantity;
	}

	/**
	 * Get an attribute from the basket item.
	 *
	 * @param  string $attribute
	 * @return mixed
	 */
	public function __get($attribute)
	{
		if(property_exists($this, $attribute)) return $this->{$attribute};

		if($attribute === 'subtotal') return $this->quantity * $this->price;

		return null;
	}

	/**
	 * Create a new BasketItem from the given attributes.
	 *
	 * @param string $type
	 * @param mixed  $id
	 * @param string  $name
	 * @param float  $price
	 * @param array  $options
	 * @return \Cbenjafield\DrivingSchoolBasket\BasketItem
	 */
	public static function fromAttributes($type, $id, $name, $price, $group, $category = null, array $options = [])
	{
		return new self($type, $id, $name, $price, $group, $category, $options);
	}

	/**
	 * Returns a number format.
	 *
	 * @param  float  $value
	 * @param  int    $decimalPlaces
	 * @param  string $decimalPoint
	 * @param  string $thousandSeparator
	 * @return string
	 */
	protected function formatNumber($value, $decimalPlaces, $decimalPoint, $thousandSeparator)
	{
		if(is_null($decimalPlaces)) $decimalPlaces = is_null(config('basket.format.decimal_places')) ? 2 : config('basket.format.decimal_places');
		if(is_null($decimalPoint)) $decimalPoint = is_null(config('basket.format.decimal_point')) ? '.' : config('basket.format.decimal_point');
		if(is_null($thousandSeparator)) $thousandSeparator = is_null(config('basket.format.thousand_separator')) ? ',' : config('basket.format.thousand_separator');

		return number_format($value, $decimalPlaces, $decimalPoint, $thousandSeparator);
	}

	/**
	 * Generate a random unique id for the item.
	 *
	 * @param  mixed $id
	 * @param  array $options
	 * @return string
	 */
	protected function generateItemId($id, array $options)
	{
		ksort($options);
		return sha1($id . serialize($options));
	}

	/**
	 * Get the instance as an array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return [
			'itemId'   => $this->itemId,
			'id'       => $this->id,
			'name'     => $this->name,
			'type'     => $this->type,
			'quantity' => $this->quantity,
			'price'    => $this->price,
			'category' => $this->category,
			'options'  => $this->options->toArray(),
			'subtotal' => $this->subtotal
		];
	}

	/**
	 * Convert the object to JSON representation.
	 *
	 * @param  $options
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return json_encode($this->toArray(), $options);
	}
}
