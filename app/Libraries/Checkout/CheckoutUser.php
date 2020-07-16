<?php

namespace Benjafield\Checkout;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Notifications\Notifiable;

class CheckoutUser implements Arrayable, Jsonable
{
	use Notifiable;
	
	/**
	 * The customer's name.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * The customer's email address.
	 *
	 * @var string
	 */
	public $email;

	/**
	 * The customer's phone number.
	 *
	 * @var string
	 */
	public $phone;

	/**
	 * The pupil's name.
	 *
	 * @var string
	 */
	public $pupil_name;

	/**
	 * The CheckoutUser constructor.
	 *
	 * @param  string $name
	 * @param  string $email
	 * @param  string $phone
	 * @param  string $pupil_name
	 */
	public function __construct($name, $email, $phone, $pupil_name)
	{
		if(is_null($name)) throw new \InvalidArgumentException("Please supply a customer name.");
		if(is_null($email)) throw new \InvalidArgumentException("Please supply an email address.");
		if(is_null($phone)) throw new \InvalidArgumentException("Please supply a phone number.");
		if(is_null($pupil_name)) throw new \InvalidArgumentException("Please supply a pupil name.");

		$this->name = $name;
		$this->email = $email;
		$this->phone = $phone;
		$this->pupil_name = $pupil_name;
	}

	/**
	 * Return the instance as an array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return [
			'name' => $this->name,
			'email' => $this->email,
			'phone' => $this->phone,
			'pupil_name' => $this->pupil_name,
		];
	}

	/**
	 * Return the instance in its JSON representation.
	 *
	 * @param  int|bool $options
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return json_encode($this->toArray(), $options);
	}

}