<?php

namespace Benjafield\Checkout;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

class Address implements Arrayable, Jsonable
{

	/**
	 * The first line of the address.
	 *
	 * @var string
	 */
	public $addressLine1;

	/**
	 * The second line of the address.
	 *
	 * @var string
	 */
	public $addressLine2;

	/**
	 * The third line of the address.
	 *
	 * @var string
	 */
	public $addressLine3;

	/**
	 * The town/city of the address.
	 *
	 * @var string
	 */
	public $city;

	/**
	 * The country of the address.
	 *
	 * @var string
	 */
	public $country;

	/**
	 * The postcode of the address.
	 *
	 * @var string
	 */
	public $postcode;

	/**
	 * Address constructor.
	 *
	 * @param array $components
	 */
	public function __construct(array $components = [])
	{
		$components = new Collection((object) $components);

		if(!$components->has('address_line_1')) throw new \InvalidArgumentException('The first line of the address is required.');
		if(!$components->has('city')) throw new \InvalidArgumentException('The city of the address is required.');
		if(!$components->has('postcode')) throw new \InvalidArgumentException('The postcode of the address is required.');

		$this->addressLine1 = $components->get('address_line_1');
		$this->addressLine2 = $components->get('address_line_2');
		$this->addressLine3 = $components->get('address_line_3');
		$this->city = $components->get('city');
		$this->country = $components->get('country');
		$this->postcode = $components->get('postcode');
	}

	/**
	 * Convert the object to its JSON representation.
	 *
	 * @param int      $options
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return json_encode($this->toArray(), $options);
	}

	/**
	 * Get the instance as an array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return [
			'address_line_1' => $this->addressLine1,
			'address_line_2' => $this->addressLine2,
			'address_line_3' => $this->addressLine3,
			'city' => $this->city,
			'country' => $this->country,
			'postcode' => $this->postcode
		];
	}
}