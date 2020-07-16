<?php

namespace Benjafield\Checkout;

class CheckoutSuccess
{
	/**
	 * Store the successful transaction Id.
	 *
	 * @var string
	 */
	protected $transactionId;

	/**
	 * Store the payment gateway message.
	 *
	 * @var string
	 */
	protected $gatewayMessage;

	/**
	 * Store the Auth Code.
	 *
	 * @var string
	 */
	protected $authCode;

	/**
	 * Store the payment user.
	 *
	 * @var \App\Libraries\DrivingSchoolBasket\CheckoutUser
	 */
	protected $user;

	/**
	 * Create a new instance.
	 *
	 * @param  string                                           $transactionId
	 * @param  \Cbenjafield\DrivingSchoolBasket\CheckoutUser    $user
	 * @param  string                                           $gatewayMessage
	 * @param  string                                           $authCode
	 */
	public function __construct(string $transactionId, CheckoutUser $user, string $gatewayMessage, string $authCode)
	{
		$this->gatewayMessage = $gatewayMessage;
		$this->transactionId = $transactionId;
		$this->user = $user;
		$this->authCode = $authCode;
	}

	/**
	 * Return the checkout user.
	 *
	 * @return Cbenjafield\DrivingSchoolBasket\CheckoutUser
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Return the transaction ID.
	 *
	 * @return string
	 */
	public function getTransactionId()
	{
		return $this->transactionId;
	}

	/**
	 * Return the gateway message.
	 *
	 * @return string
	 */
	public function getGatewayMessage()
	{
		return $this->gatewayMessage;
	}

	/**
	 * Pluck the auth code from the gateway message.
	 *
	 * @return string|null
	 */
	public function getAuthCode()
	{
		if(is_null($this->gatewayMessage)) return null;

		$parts = explode('#', $this->gatewayMessage);

		if(isset($parts[1])) {
			return trim($parts[1]);
		}

		return null;
	}

}